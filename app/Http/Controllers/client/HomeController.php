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
        $product = Product::paginate(8);

        return view('client.index', compact('categories', 'product'));
    }
    public function filterByCategory($id)
{
    $categories = Category::all();
    $product = Product::where('category_id', $id)->paginate(8);
    return view('client.index', compact('categories', 'product'));
}

}
