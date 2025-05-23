<?php

namespace App\Http\Controllers\admin\product;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Danh sách sản phẩm
    public function index()
    {
        // Get all active products for main list
        $activeProducts = Product::with('category')
            ->withoutTrashed()
            ->latest()
            ->get();

        // Get soft deleted products
        $deletedProducts = Product::with('category')
            ->orderBy('deleted_at', 'desc')
            ->onlyTrashed()
            ->latest()
            ->get();

        $categories = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->get();

        // Format data for active products
        $data = $activeProducts->map(function ($product) {
            return [
                'id' => $product->id,
                'product' => [
                    'img' => asset('client/images/fashion/product/' . $product->image),
                    'title' => $product->name,
                    'category' => $product->category->name ?? 'Uncategorized',
                ],
                'stock' => (string) $product->total_stock,
                'price' => rtrim(rtrim(number_format($product->price), '0'), '.'),
                'rating' => number_format($product->ratings->avg('rating'), 1),
                'published' => [
                    'publishDate' => $product->created_at->format('d M, Y'),
                    'publishTime' => $product->created_at->format('H:i A'),
                ],
            ];
        });

        // Format data for deleted products
        $deletedData = $deletedProducts->map(function ($product) {
            return [
                'id' => $product->id,
                'product' => [
                    'img' => asset('client/images/fashion/product/' . $product->image),
                    'title' => $product->name,
                    'category' => $product->category->name ?? 'Uncategorized',
                ],
                'stock' => (string) $product->total_stock,
                'price' => rtrim(rtrim(number_format($product->price), '0'), '.'),
                'rating' => number_format($product->ratings->avg('rating'), 1),
                'published' => [
                    'publishDate' => $product->deleted_at ? $product->deleted_at->format('d M, Y') : null, // Lấy thời gian xóa nếu có
                    'publishTime' => $product->deleted_at ? $product->deleted_at->format('H:i A') : null,

                ]
            ];
        });


        return view('admin.product.index', compact('data', 'categories', 'activeProducts', 'deletedData', 'deletedProducts'));
    }
    public function show($id)
    {
        $product = Product::with('category', 'ratings.customer', 'variants','comments.customer')->findOrFail($id);

        
        $variants = $product->variants;
        // Tính điểm đánh giá trung bình
        $averageRating = $product->ratings->avg('rating');

        // Đếm số lượt đánh giá từ khách hàng duy nhất
        $reviewCount = Comment::where('product_id', $product->id)
            ->whereNotNull('customer_id')
            ->distinct('customer_id')
            ->count('customer_id');

        return view('admin.product.show', compact('product', 'averageRating', 'reviewCount', 'variants'));
    }


    // Form tạo mới
    public function create()
    {
        $categories = Cache::remember('categories', 3600, function () {
            return Category::all();
        });
        $products = Product::all();
        return view('admin.product.create', compact('categories', 'products'));
    }

    // Lưu sản phẩm mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|unique:products',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,gif,jpg',
            'status' => 'required|in:Active,Inactive',
            'description' => 'required|string|max:1000',
            'total_stock' => 'required|numeric',
        ]);

        // Prepare data
        $data = $request->all();
        $data['slug'] = Str::slug($request->input('name'));

        $imagePath = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            try {
                $directory = 'client/images/fashion/product';
                $fullPath = public_path($directory);

                // Create directory if it doesn't exist
                if (!file_exists($fullPath)) {
                    mkdir($fullPath, 0755, true);
                    Log::info("Directory created: {$directory}");
                }

                $image = $request->file('image');
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

                // Move uploaded file to destination
                if ($image->move($fullPath, $imageName)) {
                    // Log::info("Image uploaded successfully: {$directory}/{$imageName}");
                    $data['image'] = $imageName; // Store only filename
                } else {
                    // Log::error("Failed to move uploaded file to {$directory}");
                    return redirect()->back()->withErrors(['image' => 'Failed to save image.']);
                }
            } catch (\Exception $e) {
                // Log::error("Failed to upload image: " . $e->getMessage());
                return redirect()->back()->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()]);
            }
        }

        // Debug data before saving
        // Log::info('Data to be saved:', $data);

        // Create product
        $product = Product::create($data);

        // Verify data saved
        // Log::info('Product created with ID: ' . $product->id . ', Image: ' . $product->image);

        // Verify file still exists after product creation
        // Verify file still exists after product creation
        if ($imagePath) {
            $fullPath = storage_path('app/public/' . $imagePath);
            sleep(5); // Đợi 5 giây
            if (!file_exists($fullPath)) {
                // Log::error("Image file missing after 5-second delay at {$fullPath}");
                $product->delete();
                return redirect()->back()->withErrors(['image' => 'Image file was deleted after 5 seconds.']);
            } else {
                Log::info("Image file still exists after 5-second delay: {$imagePath}");
            }
        }
        // dd($data);
        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    // Form chỉnh sửa
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.product.edit', compact('product', 'categories'));
    }

    // Cập nhật sản phẩm
    // Cập nhật sản phẩm
public function update(Request $request, $id)
{
    // Lấy sản phẩm cần chỉnh sửa
    $product = Product::findOrFail($id);

    // Validate dữ liệu
    $request->validate([
        'name' => 'required|string|max:255',
        'sku' => 'required|unique:products,sku,' . $id,
        'price' => 'required|numeric',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|mimes:jpeg,png,gif,jpg',
        'status' => 'required|in:Active,Inactive',
        'description' => 'required|string|max:1000',
        'total_stock' => 'required|numeric',
    ]);

    // Lấy dữ liệu từ request
    $data = $request->all();
    $data['slug'] = Str::slug($request->input('name'));

    // Kiểm tra và xử lý hình ảnh
    if ($request->hasFile('image') && $request->file('image')->isValid()) {
        try {
            $directory = 'client/images/fashion/product';
            $fullPath = public_path($directory);

            // Tạo thư mục nếu chưa có
            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
                Log::info("Directory created: {$directory}");
            }

            // Xử lý tải ảnh lên
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

            // Di chuyển ảnh vào thư mục
            if ($image->move($fullPath, $imageName)) {
                // Cập nhật tên ảnh vào dữ liệu
                $data['image'] = $imageName;
            } else {
                return redirect()->back()->withErrors(['image' => 'Failed to save image.']);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()]);
        }
    } else {
        // Nếu không có ảnh mới, giữ nguyên ảnh cũ
        $data['image'] = $product->image;
    }

    // Cập nhật thông tin sản phẩm
    $product->update($data);

    // Chuyển hướng và thông báo thành công
    return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
}


    public function destroy($id)
    {
        Log::info('Attempting to delete product', ['id' => $id, 'user_id' => Auth::id()]);

        // Kiểm tra quyền admin
        if (Auth::user()->role !== 'admin') {
            Log::warning('Unauthorized attempt to delete product', ['id' => $id, 'user_id' => Auth::id()]);
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Kiểm tra ID hợp lệ
        if (!is_numeric($id) || $id <= 0) {
            Log::error('Invalid product ID', ['id' => $id]);
            return response()->json([
                'success' => false,
                'message' => 'Invalid product ID'
            ], 400);
        }

         try {
        $product = Product::find($id);

        // Kiểm tra nếu không tìm thấy sản phẩm
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        $product->delete(); // Hoặc sử dụng soft delete nếu cần

        return response()->json(['success' => true, 'message' => 'Đã xóa sản phẩm thành công']);
    } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Add restore method
    public function restore($id)
    {
        try {
            $product = Product::onlyTrashed()->findOrFail($id);
            $product->restore();

            // Format product data for response
            $formattedProduct = [
                'id' => $product->id,
                'product' => [
                    'img' => asset('client/images/fashion/product/' . $product->image),
                    'title' => $product->name,
                    'category' => $product->category->name ?? 'Uncategorized',
                ],
                'stock' => (string) $product->total_stock,
                'price' => number_format($product->price, 0, '', ','), // 50000 -> "50,000"
                'rating' => $product->ratings->count() > 0
                    ? number_format($product->ratings->avg('rating'), 1)
                    : '0.0',
                'published' => [
                    'publishDate' => $product->created_at->format('d M, Y'),
                    'publishTime' => $product->created_at->format('H:i A'),
                ],
            ];

            return response()->json([
                'success' => true,
                'message' => 'Sản phẩm được khôi phục thành công',
                'product' => $formattedProduct
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to restore product'
            ], 500);
        }
    }


    // Add force delete method
    public function forceDelete($id)
    {
        try {
            $product = Product::withTrashed()->findOrFail($id);
            $product->forceDelete();

            return response()->json([
                'success' => true,
                'message' => 'Sản phẩm đã bị xóa vĩnh viễn'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product'
            ], 500);
        }
    }
}
