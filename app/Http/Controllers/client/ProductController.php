<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Rating;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Lấy tất cả danh mục
        $categories = Category::withCount('products')->get();
$colors = ProductVariant::select('color')->distinct()->pluck('color')->filter();
$sizes = ProductVariant::select('size')->distinct()->pluck('size')->filter();


        // Xây dựng query sản phẩm
        $query = Product::with(['variants', 'category']);

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

        // Lấy sản phẩm với phân trang (10 sản phẩm mỗi trang)
        $products = $query->paginate(16)->appends($request->query());
        return view('client.shop', compact('products', 'categories', 'colors', 'sizes'));
    }
    public function filterByCategory($id)
    {
        $categories = Category::all();
        $product = Product::where('category_id', $id)->paginate(8);
        return view('client.shop', compact('categories', 'product'));
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
            ->take(5)
            ->get();

        return view('client.show', compact('product', 'variants', 'averageRating', 'reviewCount', 'relatedProducts', 'ratingPercentages'));
    }
    public function submitReview(Request $request, $id)
    {
        // Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
            'terms_condition' => 'accepted',
        ]);

        // Lưu comment
        $comment = new Comment();
        $comment->product_id = 1;
        $comment->customer_id = 1; // Nếu có đăng nhập
        // $comment->name = $request->name;
        // $comment->email = $request->email;
        $comment->content = $request->comment;
        $comment->save();

        // Lưu rating
        $rating = new Rating();
        $rating->product_id = 1;
        $rating->customer_id = 1;
        $rating->rating = $request->rating;
        $rating->save();

        return redirect()->back()->with('success', 'Bình luận đã được gửi.');
    }
    public function search(Request $request)
    {
        $categories = Category::all();
        $keyword = $request->q;

        $product = Product::where('name', 'like', "%$keyword%")
            ->orWhere('description', 'like', "%$keyword%")
            ->paginate(10);

        return view('client.shop', compact('product', 'keyword', 'categories'));
    }
}
