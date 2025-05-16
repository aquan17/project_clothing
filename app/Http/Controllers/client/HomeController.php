<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
{
    $categories = Category::all();

    // Phần trên: sản phẩm trending (bán chạy)
    $trendingProducts = Product::orderByDesc('buyer_count')->take(10)->get();

    // Phần dưới: danh sách sản phẩm phân trang
    $product = Product::with('variants')->paginate(10);


    return view('client.index', compact('categories', 'trendingProducts', 'product'));
}

    

}
