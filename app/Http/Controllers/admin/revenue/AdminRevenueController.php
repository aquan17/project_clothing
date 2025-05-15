<?php

namespace App\Http\Controllers\admin\revenue;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminRevenueController extends Controller
{
    public function getRevenueData(Request $request)
    {
        try {
            $query = Order::query();
            $orders = [];
            $earnings = [];
            $cancelled = [];
            $months = [];
            $totalEarnings = 0;
            $totalCustomers = User::where('role', 'user')->count(); // Đếm số lượng trực tiếp
            $totalBalance = Order::where('status', 'completed')
                ->get()
                ->sum(function ($order) {
                    return $order->total_price - ($order->total_price * 0.1);
                }) / 1000;



            if ($request->has(['startDate', 'endDate'])) {
                $startDate = Carbon::parse($request->startDate)->startOfDay();
                $endDate = Carbon::parse($request->endDate)->endOfDay();
                if ($startDate > $endDate) {
                    [$startDate, $endDate] = [$endDate, $startDate];
                }
                $query->whereBetween('created_at', [$startDate, $endDate]);
                $monthlyData = $query->selectRaw('
                    YEAR(created_at) as year,
                    MONTH(created_at) as month,
                    COUNT(*) as order_count,
                    SUM(CASE WHEN status = "completed" THEN total_price ELSE 0 END) as earnings,
                    COUNT(CASE WHEN status = "cancelled" THEN 1 ELSE NULL END) as cancelled
                ')
                    ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
                    ->orderBy('year')
                    ->orderBy('month')
                    ->get();

                $currentDate = Carbon::parse($startDate);
                while ($currentDate <= $endDate) {
                    $month = $currentDate->month;
                    $year = $currentDate->year;
                    $monthData = $monthlyData->firstWhere(fn($data) => $data->month == $month && $data->year == $year);
                    $orders[] = $monthData ? (int)$monthData->order_count : 0;
                    $earnings[] = $monthData ? round($monthData->earnings / 1000, 2) : 0;
                    $cancelled[] = $monthData ? (int)$monthData->cancelled : 0;
                    $totalEarnings += $monthData ? $monthData->earnings : 0;
                    $months[] = $currentDate->format('M Y');
                    $currentDate->addMonth();
                }
            } elseif ($request->has('filter') && $request->filter !== 'all') {
                $startDate = now();
                $endDate = now()->endOfDay();
                switch ($request->filter) {
                    case 'month':
                        $startDate = now()->subMonth()->startOfDay();
                        break;
                    case 'halfYear':
                        $startDate = now()->subMonths(6)->startOfDay();
                        break;
                    case 'year':
                        $startDate = now()->subYear()->startOfDay();
                        break;
                }
                $query->whereBetween('created_at', [$startDate, $endDate]);
                $monthlyData = $query->selectRaw('
                    YEAR(created_at) as year,
                    MONTH(created_at) as month,
                    COUNT(*) as order_count,
                    SUM(CASE WHEN status = "completed" THEN total_price ELSE 0 END) as earnings,
                    COUNT(CASE WHEN status = "cancelled" THEN 1 ELSE NULL END) as cancelled
                ')
                    ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
                    ->orderBy('year')
                    ->orderBy('month')
                    ->get();

                $currentDate = Carbon::parse($startDate);
                while ($currentDate <= $endDate) {
                    $month = $currentDate->month;
                    $year = $currentDate->year;
                    $monthData = $monthlyData->firstWhere(fn($data) => $data->month == $month && $data->year == $year);
                    $orders[] = $monthData ? (int)$monthData->order_count : 0;
                    $earnings[] = $monthData ? round($monthData->earnings / 1000, 2) : 0;
                    $cancelled[] = $monthData ? (int)$monthData->cancelled : 0;
                    $totalEarnings += $monthData ? $monthData->earnings : 0;
                    $months[] = $currentDate->format('M Y');
                    $currentDate->addMonth();
                }
            } else {
                // Filter 'all' - Lấy tất cả dữ liệu
                $monthlyData = Order::selectRaw('
                    YEAR(created_at) as year,
                    MONTH(created_at) as month,
                    COUNT(*) as order_count,
                    SUM(CASE WHEN status = "completed" THEN total_price ELSE 0 END) as earnings,
                    COUNT(CASE WHEN status = "cancelled" THEN 1 ELSE NULL END) as cancelled
                ')
                    ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
                    ->orderBy('year')
                    ->orderBy('month')
                    ->get();

                foreach ($monthlyData as $data) {
                    $orders[] = (int)$data->order_count;
                    $earnings[] = round($data->earnings / 1000, 2);
                    $cancelled[] = (int)$data->cancelled;
                    $totalEarnings += $data->earnings;
                    $months[] = Carbon::createFromDate($data->year, $data->month, 1)->format('M Y');
                }
            }
            $totalOrders = array_sum($orders);
            $totalCancelled = array_sum($cancelled);
            $conversionRate = $totalOrders > 0 ? round(($totalOrders - $totalCancelled) / $totalOrders * 100, 2) : 0;

            return response()->json([
                'orders' => $orders,
                'earnings' => $earnings,
                'cancelled' => $cancelled,
                'categories' => $months,
                'totalOrders' => array_sum($orders),
                'totalEarnings' => round($totalEarnings / 1000, 2),
                'totalCustomers' => $totalCustomers,
                'totalBalance' => round($totalBalance, 2),
                'totalCanceled' => array_sum($cancelled),
                'conversionRate' => $conversionRate,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error fetching revenue data',
                'message' => $e->getMessage()
            ], 500);
        }

        //      try {
        //     $totalOrders = Order::count();
        //     $totalEarnings = Order::where('status', 'completed')->sum('total_price') / 1000;
        //     $totalCanceled = Order::where('status', 'cancelled')->count();
        //     $conversionRate = $totalOrders > 0 ? round(($totalOrders - $totalCanceled) / $totalOrders * 100, 2) : 0;

        //     $data = [
        //         'orders' => [89, 70, 123, 81, 110, 75, 100, 87, 140, 91, 120, 93],
        //         'earnings' => [120, 100, 150, 120, 100, 110, 100, 130, 200, 130, 170, 140],
        //         'refunds' => [20, 25, 30, 35, 27, 32, 22, 28, 35, 30, 25, 28],
        //         'totalOrders' => $totalOrders,
        //         'totalEarnings' => $totalEarnings,
        //         'totalCanceled' => $totalCanceled,
        //         'conversionRate' => $conversionRate
        //     ];

        //     return response()->json($data);
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'error' => 'Error fetching revenue data',
        //         'message' => $e->getMessage()
        //     ], 500);
        // }
    }
}
