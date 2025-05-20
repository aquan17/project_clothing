<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Lấy tất cả danh mục
        $categories = Category::withCount('products')->get();
        $colors = ProductVariant::select('color')->distinct()->pluck('color')->filter();
        $sizes = ProductVariant::select('size')->distinct()->pluck('size')->filter();

        // Xây dựng query sản phẩm
        $query = Product::with(['variants', 'category', 'ratings']);

        // Lọc theo danh mục
        if ($request->has('category')) {
            $categorySlug = $request->input('category');
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // Lọc theo màu sắc
        if ($request->has('color')) {
            $color = $request->input('color');
            $query->whereHas('variants', function ($q) use ($color) {
                $q->where('color', $color);
            });
        }

        // Lọc theo kích cỡ
        if ($request->has('size')) {
            $size = $request->input('size');
            $query->whereHas('variants', function ($q) use ($size) {
                $q->where('size', $size);
            });
        }

        // Tìm kiếm theo tên sản phẩm
        if ($request->has('query')) {
            $keyword = $request->input('query');
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        // Sắp xếp sản phẩm
        if ($request->has('sort')) {
            $sortType = $request->input('sort');
            if ($sortType === 'low_to_high') {
                $query->orderBy('price', 'asc');
            } elseif ($sortType === 'high_to_low') {
                $query->orderBy('price', 'desc');
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        // Lấy tất cả sản phẩm (không phân trang để JavaScript xử lý)
        $products = $query->get()->map(function ($product) {
            // Lấy màu sắc và kích cỡ từ variants
            $colors = $product->variants->pluck('color')->filter()->unique()->toArray();
            $sizes = $product->variants->pluck('size')->filter()->unique()->toArray();

            // Tính trung bình rating (nếu có)
            $rating = $product->ratings->avg('rating') ?? 0;

            return [
                'id' => $product->id,
                'wishList' => false, // Giá trị mặc định vì không có cột wish_list
                'productImg' => $product->image ? asset('client/images/fashion/product/' . $product->image) : '', // Đường dẫn hình ảnh
                'productTitle' => $product->name,
                'category' => $product->category->name ?? '', // Tên danh mục
                'price' => number_format($product->price, 2), // Giá dạng chuỗi
                'discount' => '0%', // Giá trị mặc định vì không có cột discount
                'rating' => number_format($rating, 1), // Rating dạng chuỗi
                'arrival' => false, // Giá trị mặc định vì không có cột arrival
                'color' => $colors, // Mảng màu sắc
                'size' => $sizes, // Mảng kích cỡ
            ];
        });
        // dd($sizes);
        return view('client.shop', compact('products', 'categories', 'colors', 'sizes'));
    }
    public function filterByCategory($id)
    {
        $categories = Category::withCount('products')->get();
        $colors = ProductVariant::select('color')->distinct()->pluck('color')->filter();
        $sizes = ProductVariant::select('size')->distinct()->pluck('size')->filter();

        $products = Product::with(['variants', 'category', 'ratings'])
            ->where('category_id', $id)
            ->orderBy('id', 'desc')
            ->paginate(16);

        return view('client.shop', compact('categories', 'products', 'colors', 'sizes'));
    }
    public function show($id)
    {
        // $categories = Category::findOrFail($id);

        // Lấy sản phẩm cùng với variants và comments với customer
        $product = Product::with('variants', 'comments.customer', 'ratings.customer', 'category')->findOrFail($id);

        // Tính điểm đánh giá trung bình
        $averageRating = $product->ratings->avg('rating');

        // Đếm số lượt đánh giá từ khách hàng duy nhất
        $reviewCount = Comment::where('product_id', $product->id)
            ->whereNotNull('customer_id')
            ->distinct('customer_id')
            ->count('customer_id');

        // Thống kê phần trăm rating (5 sao, 4 sao, ...)
        $ratingStats = Rating::where('product_id', $product->id)
            ->groupBy('rating')
            ->selectRaw('rating, COUNT(*) as count')
            ->pluck('count', 'rating')
            ->toArray();

        $totalRatings = array_sum($ratingStats);
        $ratingPercentages = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingPercentages[$i] = $totalRatings > 0 ? round(($ratingStats[$i] ?? 0) / $totalRatings * 100) : 0;
        }

        // Lấy biến thể
        $variants = $product->variants;
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id) // Loại trừ sản phẩm hiện tại
            ->take(4)
            ->get();

        $vouchers = Coupon::where('status', 1)->orderBy('end_date', 'desc')->get(); // lấy các voucher còn hiệu lực
        return view('client.show', compact('product', 'variants', 'averageRating', 'reviewCount', 'relatedProducts', 'ratingPercentages', 'vouchers'));
    }
    public function submitReview(Request $request, $id)
    {
        // Validate dữ liệu
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:1000',
        ]);

        // Tìm sản phẩm
        $product = Product::findOrFail($id);

        // Lưu comment
        Comment::create([
            'product_id' => $product->id,
            'customer_id' => Auth::id(),
            'name' => Auth::user()->name,
            'content' => $request->content,
        ]);

        // Lưu rating (nếu bạn vẫn muốn tách bảng ratings)
        Rating::create([
            'product_id' => $product->id,
            'customer_id' => Auth::id(),
            'rating' => $request->rating,
        ]);

        // Log::info('Comment submitted for product ID: ' . $product->id . ' by user ID: ' . Auth::id());

        // Chuyển hướng về trang trước với #comments
        return redirect()->to(url()->previous() . '#comments')->with('success', 'Bình luận đã được gửi.');
    }
    public function search(Request $request)
    {
        $categories = Category::withCount('products')->get();
        $colors = ProductVariant::select('color')->distinct()->pluck('color')->filter();
        $sizes = ProductVariant::select('size')->distinct()->pluck('size')->filter();

        $keyword = $request->q;

        $products = Product::with(['variants', 'category', 'ratings'])
            ->where('name', 'like', "%$keyword%")
            ->orWhere('description', 'like', "%$keyword%")
            ->orderBy('id', 'desc')
            ->paginate(16)
            ->appends($request->query());

        return view('client.shop', compact('products', 'keyword', 'categories', 'colors', 'sizes'));
    }
    public function header(Request $request)
    {
        $query = Product::query();

        if ($request->has('category')) {
            $categorySlug = $request->input('category');
            $query->whereHas('category', fn($q) => $q->where('slug', $categorySlug));
        }

        $products = $query->paginate(12);

        $categoriesGrouped = Category::withCount('products')->get()->groupBy('group');

        return view('client.layout.component.header', compact('categoriesGrouped'));
    }
}
