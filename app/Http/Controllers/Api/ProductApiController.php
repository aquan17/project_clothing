<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class ProductApiController extends Controller
{
    public function index()
    {
        // Lấy sản phẩm chưa xóa (active)
        $activeProducts = Product::with('category')
            ->withoutTrashed()
            ->latest()
            ->get();

        // Lấy sản phẩm đã xóa mềm
        $deletedProducts = Product::with('category')
            ->orderBy('deleted_at', 'desc')
            ->onlyTrashed()
            ->latest()
            ->get();

        // Lấy danh mục kèm số lượng sản phẩm
        $categories = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->get();

        // Định dạng dữ liệu sản phẩm chưa xóa
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

        // Định dạng dữ liệu sản phẩm đã xóa mềm
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
                    'publishDate' => $product->deleted_at ? $product->deleted_at->format('d M, Y') : null,
                    'publishTime' => $product->deleted_at ? $product->deleted_at->format('H:i A') : null,
                ],
            ];
        });

        return response()->json([
            'message' => 'Lấy Danh Sách Sản Phẩm Thành Công',
            'activeProducts' => $data,
            'deletedProducts' => $deletedData,
            'categories' => $categories,
        ]);
    }
    public function show($id)
    {
        // Lấy sản phẩm với các quan hệ cần thiết
        $product = Product::with('category', 'ratings.customer', 'variants', 'comments.customer')->findOrFail($id);

        // Tính điểm đánh giá trung bình
        $averageRating = $product->ratings->avg('rating') ?? 0;

        // Đếm số lượt đánh giá từ khách hàng duy nhất
        $reviewCount = Comment::where('product_id', $product->id)
            ->whereNotNull('customer_id')
            ->distinct('customer_id')
            ->count('customer_id');

        // Format dữ liệu trả về
        $formattedData = [
            'id' => $product->id,
            'name' => $product->name,
            'image' => asset('client/images/fashion/product/' . $product->image), // Định dạng URL ảnh
            'price' => number_format($product->price, 2),
            'description' => $product->description,
            'total_stock' => $product->variants->sum('stock'),
            'created_at' => $product->created_at->format('d M, Y'),
            'category' => [
                'id' => $product->category?->id,
                'name' => $product->category?->name,
            ],
            'variants' => $product->variants->map(function ($variant) {
                return [
                    'id' => $variant->id,
                    'size' => $variant->size,
                    'color' => $variant->color,
                    'stock' => $variant->stock,
                ];
            })->values()->toArray(),
            'comments' => $product->comments->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'rating' => $comment->rating,
                    'created_at' => $comment->created_at->format('d M, Y'),
                    'customer' => [
                        'id' => $comment->customer?->id,
                        'name' => $comment->customer?->name,
                    ],
                ];
            })->values()->toArray(),
            'average_rating' => number_format($averageRating, 1),
            'review_count' => $reviewCount,
        ];

        // Trả về JSON
        return response()->json([
            'message' => 'Xem chi tiết sản phẩm',
            'data' => $formattedData,
        ]);
    }

    public function create()
    {
        $categories = Cache::remember('categories', 3600, function () {
            return Category::all();
        });

        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
    }
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

            // Validation biến thể
            'variants' => 'required|array|min:1',
            'variants.*.color' => 'required|string|max:50',
            'variants.*.size' => 'required|string|max:50',
            'variants.*.price' => 'required|numeric',
            'variants.*.stock' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            $data = $request->all();
            $data['slug'] = Str::slug($request->input('name'));

            // Xử lý upload ảnh
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $directory = 'client/images/fashion/product';
                $fullPath = public_path($directory);
                if (!file_exists($fullPath)) {
                    mkdir($fullPath, 0755, true);
                }
                $image = $request->file('image');
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $image->move($fullPath, $imageName);
                $data['image'] = $imageName;
            }

            // Tạo sản phẩm
            $product = Product::create($data);

            // Lưu biến thể sản phẩm
            foreach ($request->variants as $variant) {
                $product->variants()->create([
                    'color' => $variant['color'],
                    'size' => $variant['size'],
                    'price' => $variant['price'],
                    'stock' => $variant['stock'],
                ]);
            }

            DB::commit();

            // Trả về JSON response
            return response()->json([
                'message' => 'Thêm sản phẩm và biến thể thành công!',
                'product' => $product->load('variants')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Lỗi khi lưu dữ liệu.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function edit($id)
    {
        try {
            $product = Product::with(['variants', 'category'])->findOrFail($id);
            $categories = Category::all();

            return response()->json([
                'message' => 'Lấy thông tin sản phẩm thành công',
                'data' => [
                    'product' => $product,
                    'categories' => $categories
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Không thể lấy thông tin sản phẩm',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            // Lấy sản phẩm cần chỉnh sửa
            $product = Product::findOrFail($id);

            // Validate dữ liệu
            $request->validate([
                'name' => 'required|string|max:255',
                'sku' => 'required|unique:products,sku,' . $id,
                'price' => 'required|numeric',
                'category_id' => 'required|exists:categories,id',
                'image' => 'nullable|image|mimes:jpeg,png,gif,jpg|max:2048',
                'status' => 'required|string|in:active,inactive,Active,Inactive,ACTIVE,INACTIVE',
                'description' => 'required|string|max:1000',
                'total_stock' => 'required|numeric',
                'variants' => 'required|array',
                'variants.*.size' => 'required|string',
                'variants.*.color' => 'required|string',
                'variants.*.stock' => 'required|numeric|min:0',
            ]);

            // Lấy dữ liệu từ request
            $data = $request->except(['variants', 'image']);
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

                    // Xóa ảnh cũ nếu tồn tại
                    if ($product->image && file_exists(public_path($directory . '/' . $product->image))) {
                        unlink(public_path($directory . '/' . $product->image));
                    }

                    // Xử lý tải ảnh lên
                    $image = $request->file('image');
                    $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

                    // Di chuyển ảnh vào thư mục
                    if ($image->move($fullPath, $imageName)) {
                        $data['image'] = $imageName;
                    } else {
                        throw new \Exception('Failed to save image.');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json([
                        'message' => 'Lỗi khi upload ảnh',
                        'error' => $e->getMessage()
                    ], 422);
                }
            }

            // Cập nhật thông tin sản phẩm
            $product->update($data);

            // Cập nhật variants
            if ($request->has('variants')) {
                // Xóa variants cũ
                $product->variants()->delete();

                // Thêm variants mới
                foreach ($request->variants as $variant) {
                    $product->variants()->create([
                        'size' => $variant['size'],
                        'color' => $variant['color'],
                        'stock' => $variant['stock']
                    ]);
                }
            }

            DB::commit();

            // Lấy lại thông tin sản phẩm sau khi cập nhật
            $updatedProduct = Product::with(['variants', 'category'])->find($id);

            return response()->json([
                'message' => 'Cập nhật sản phẩm thành công',
                'data' => $updatedProduct
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product update error: ' . $e->getMessage());

            return response()->json([
                'message' => 'Có lỗi xảy ra khi cập nhật sản phẩm',
                'error' => $e->getMessage()
            ], 500);
        }
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

          // Nếu có variants
        $product->variants()->delete();

        // Xóa sản phẩm thật sự
        $product->delete();

        return response()->json(['success' => true, 'message' => 'Đã xóa sản phẩm thành công']);
    } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
