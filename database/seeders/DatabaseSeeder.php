<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Comment;
use App\Models\Rating;
use App\Models\Payment;
use App\Models\Wishlist;
use App\Models\Coupon;
use App\Models\Setting;
use App\Models\Notification;
use App\Models\User;
use Database\Factories\ProductVariantFactory;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'phone' => '+84912345678',
            'email_verified_at' => now(),
            'password' => \Illuminate\Support\Facades\Hash::make('admin'),
            'role' => 'admin',
            'status' => 'active',
        ]);
        User::factory(2)->create();
        // Tạo danh mục
        $danhmuc = [
            'Áo phông',
            'Quần',
            'Áo sơ mi',
            'Áo khoác',
            'Áo croptop',
        ];

        foreach ($danhmuc as $dm) {
            Category::create([
                'name' => $dm,
                'slug' => Str::slug($dm),
            ]);
        }

        $faker = Faker::create();

        $productNames = [
            // Áo Phông
            "Áo phông GP unisex họa tiết rộng 2025",
            "Áo phông GP unisex thể thao mỏng nhẹ 2025",
            "Áo phông cotton phối màu chữ in 2025",
            "Áo phông cotton kẻ sọc phối màu rộng 2025",
            "Áo phông in hoa tulip phong cách Mỹ 2025",
            "Áo phông cotton in hoa lớn co giãn 2025",
            "Áo phông unisex kiểu quốc dân 2025",
            "Áo phông GP unisex mới phong cách hoạt hình 2025",
            "Áo phông high street hiphop unisex 2025",
            "Áo phông cỡ lớn kiểu street style 2023-2025",

            // Quần
            "Quần thể thao xám cạp cao 2025",
            "Quần thể thao trắng xám ống rộng 2025",
            "Quần vải micro ống rộng 2025",
            "Quần thể thao đơn sắc ống rộng 2025",
            "Quần thoáng mát mùa hè 2025",
            "Quần thể thao chống nắng đen 2025",
            "Quần chun cạo cao 2025",
            "Quần thun cotton in hình nơ 2025",
            "Quần loe đen nhẹ 2025",
            "Quần thể thao xám nhạt ống loe 2025",

            // Áo Sơ Mi
            "Áo sơ mi hoa văn phong cách Hong Kong 2025",
            "Áo sơ mi kẻ sọc Nhật Bản 2025",
            "Áo sơ mi hoa văn vintage Nhật 2025",
            "Áo sơ mi kẻ sọc vintage Nhật 2025",
            "Áo sơ mi sọc phối màu 2025",
            "Áo sơ mi loang màu in họa tiết 2025",
            "Áo sơ mi kim loại thiết kế độc đáo 2025",
            "Áo sơ mi in hình mùa hè 2024",
            "Áo sơ mi lụa cổ Cuba 2025",
            "Áo sơ mi trơn kiểu Nhật 2025",

            // Áo Khoác
            "Áo khoác jeans wash cũ nam 2025",
            "Áo khoác da cổ đứng phong cách 2025",
            "Áo khoác jeans xanh nhạt 2025",
            "Áo khoác jeans wash phong cách hiphop 2025",
            "Áo khoác da thêu họa tiết 2025",
            "Áo khoác phối màu vintage 2025",
            "Áo khoác jeans phối Polo giả 2 lớp 2025",

            // Áo Croptop
            "Áo croptop họa tiết chữ in 2025",
            "Áo croptop dáng ôm 2023-2025",
            "Áo croptop in sao trắng 2023-2025",
            "Áo croptop in họa tiết hở eo 2023-2025",
            "Áo croptop ôm vạt ngắn đen 2023-2025",
            "Áo croptop thiết kế nhỏ gọn 2023-2025",
            "Áo croptop in họa tiết độc đáo 2023-2025",
        ];

        $categoryMap = [
            'Áo phông' => 'ao-phong',
            'Quần' => 'quan',
            'Áo sơ mi' => 'ao-so-mi',
            'Áo khoác' => 'ao-khoac',
            'Áo croptop' => 'ao-croptop',
        ];

        $totalImages = 44;
        $imageIndex = 1;
        $skuIndex = 1;

        foreach ($productNames as $name) {
            // Xác định danh mục phù hợp dựa trên tên sản phẩm
            $categoryName = null;

            if (Str::contains($name, 'Áo phông')) $categoryName = 'Áo phông';
            elseif (Str::contains($name, 'Quần')) $categoryName = 'Quần';
            elseif (Str::contains($name, 'Áo sơ mi')) $categoryName = 'Áo sơ mi';
            elseif (Str::contains($name, 'Áo khoác')) $categoryName = 'Áo khoác';
            elseif (Str::contains($name, 'Áo croptop')) $categoryName = 'Áo croptop';

            $slug = $categoryMap[$categoryName] ?? null;
            $category = Category::where('slug', $slug)->first();

            if (!$category) continue;

            $imageName = 'img-' . str_pad($imageIndex, 2, '0', STR_PAD_LEFT) . '.jpg';

            Product::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => 'Sản phẩm ' . $name . ' chất lượng cao, phù hợp với phong cách hiện đại.',
                'price' => rand(10, 1000) + (rand(0, 99) / 100),
                'image' => $imageName,
                'sku' => 'SP' . str_pad($skuIndex, 4, '0', STR_PAD_LEFT),
                'total_stock' => rand(50, 200),
                'buyer_count' => rand(0, 100),
                'status' => $faker->randomElement(['active', 'inactive']),
                'category_id' => $category->id,
            ]);

            $imageIndex++;
            if ($imageIndex > $totalImages) {
                $imageIndex = 1;
            }
            $skuIndex++;
        }

        // // Seed product variants
        // ProductVariant::truncate();
        $products = Product::all();
        foreach ($products as $product) {
            $variants = (new ProductVariantFactory)->forProduct($product->id);
            foreach ($variants as $variant) {
                ProductVariant::create($variant);
            }
        }

        // // Seed customers
        Customer::factory(3)->create();

        // // Seed orders
        // Order::factory(20)->create();

        // // Seed order items
        // OrderItem::factory(20)->create();

        // // Seed comments
        // Comment::factory(50)->create();

        // // Seed ratings
        // Rating::factory(50)->create();

        // // Seed payments
        // Payment::factory(20)->create();

        // // Seed wishlists
        // Wishlist::factory(30)->create();

        // // Seed coupons
        Coupon::factory(10)->create();

        // // Seed notifications
        // Notification::factory(30)->create();
    }
}
