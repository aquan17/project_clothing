<?php

namespace App\Http\Controllers\admin\category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class AdminCategoryController extends Controller
{
   public function index()
    {
        $categories = Category::all();
        return view('admin.category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

         Category::create([
        'name' => $request->category_name,
        'slug' => Str::slug($request->category_name),
    ]);

        return redirect()->back()->with('success', 'Category added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->category_name,
        ]);
        

        return redirect()->back()->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
{
    $category = Category::findOrFail($id);
    
    // Xóa category
    $category->delete();

    // Trả về phản hồi JSON thành công
    return response()->json(['success' => true]);
}

}