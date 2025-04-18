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
    public function index()
    {
        $categories = Category::all();
        $product = Product::paginate(8);

        return view('client.shop', compact('categories', 'product'));
    }
    public function filterByCategory($id)
    {
        $categories = Category::all();
        $product = Product::where('category_id', $id)->paginate(8);
        return view('client.shop', compact('categories', 'product'));
    }
    public function show($id)
    {
        $categories = Category::find($id);
        
        // Lấy sản phẩm cùng với variants và comments với customer
        $product = Product::with('variants', 'comments.customer','ratings.customer')->findOrFail($id);
        $averageRating = $product->ratings->avg('rating');
        $reviewCount =Comment::where('product_id', $product->id)
        ->whereNotNull('customer_id') // đảm bảo có user
        ->distinct('customer_id')      // không tính trùng user
        ->count('customer_id');
        // Truy xuất biến thể (size, color)
        $variants = $product->variants;
    
        $relatedProducts = Product::where('category_id', $product->category_id)
                                ->where('id', '!=', $product->id) // Loại trừ sản phẩm hiện tại
                                ->take(5)
                                ->get();

        return view('client.show', compact('categories', 'product', 'variants','averageRating','reviewCount','relatedProducts'));
    }
    public function submitReview(Request $request, $id)
    {
        // Validate dữ liệu
        $request->validate([
            'product_id' => 'required|exists:products,id', // Kiểm tra sản phẩm có tồn tại
            'name' => 'required|string',
            'email' => 'required|email',
            'review' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);
    
        // Trong quá trình test, chúng ta chỉ hardcode customer_id là 1
        $customer_id = 1; // Tạm thời sử dụng ID khách hàng cố định để test
    
        // Tạo mới bình luận
        $comment = Comment::create([
            'product_id' => $request->product_id,
            'customer_id' => $customer_id, // Tạm thời hardcode customer_id
            'content' => $request->review,
        ]);
    
        // Tạo mới đánh giá (rating)
        Rating::create([
            // 'comment_id' => $comment->id,
            'product_id' => $request->product_id, // Đảm bảo truyền product_id vào bảng ratings
            'rating' => $request->rating,
            'customer_id' => $customer_id, // Thêm customer_id vào bảng ratings
        ]);
    
        // Trả về thông báo thành công
        return redirect()->back()->with('success', 'Đánh giá của bạn đã được gửi!');
    }
    
    
}
