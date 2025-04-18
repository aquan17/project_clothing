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
use Illuminate\Support\Str;
use Faker\Factory as Faker;
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // $danhmuc = [
        //     'Áo thun',
        //     'Áo sơ mi',
        //     'Váy',
        //     'Quần',
        //     'Quần jeans',
        //     'Áo khoác',
        //     'Đồ ngủ',
        //     'Đồ thể thao',
        //     'Đầm dạ hội',
        //     'Đồ mùa đông',
        // ];
        // foreach ($danhmuc as $dm) {
        //     Category::create([
        //         'name' => $dm,
        //         'slug' => str::slug($dm),
        //     ]);
        // }

       
        // $faker = Faker::create();
        //     $productNames = [
        //         // Áo thun & Áo kiểu
        //         'Áo thun nữ cổ tròn cotton',
        //         'Áo thun nữ oversize in họa tiết',
        //         'Áo croptop nữ tay ngắn',
        //         'Áo kiểu nữ tay bồng ren',
        //         'Áo thun nữ cổ V basic',
        //         'Áo ba lỗ nữ sát nách',
        //         'Áo polo nữ phong cách thể thao',
        //         'Áo thun nữ dài tay minimal',
            
        //         // Áo sơ mi
        //         'Áo sơ mi nữ công sở trắng',
        //         'Áo sơ mi nữ kẻ caro',
        //         'Áo sơ mi nữ lụa tay dài',
        //         'Áo sơ mi nữ cổ thắt nơ',
        //         'Áo sơ mi nữ tay lửng thanh lịch',
        //         'Áo sơ mi nữ họa tiết hoa nhí',
            
        //         // Váy
        //         'Váy maxi hoa nhí bohemian',
        //         'Váy chữ A nữ công sở',
        //         'Váy bodycon nữ ôm dáng',
        //         'Váy xếp ly nữ dài qua gối',
        //         'Váy yếm nữ denim',
        //         'Váy babydoll nữ tay phồng',
        //         'Váy suông nữ họa tiết tropical',
        //         'Váy đầm nữ cổ vuông',
            
        //         // Quần
        //         'Quần culottes nữ cạp cao',
        //         'Quần tây nữ ống suông',
        //         'Quần short nữ vải linen',
        //         'Quần palazzo nữ ống rộng',
        //         'Quần jogger nữ phong cách năng động',
        //         'Quần legging nữ tập gym',
            
        //         // Quần jeans
        //         'Quần jeans nữ cạp cao skinny',
        //         'Quần jeans nữ boyfriend rách gối',
        //         'Quần jeans nữ ống loe vintage',
        //         'Quần jeans nữ cạp lưng thun',
        //         'Quần jeans short nữ xắn gấu',
            
        //         // Áo khoác
        //         'Áo khoác blazer nữ công sở',
        //         'Áo khoác cardigan nữ mỏng nhẹ',
        //         'Áo khoác bomber nữ phong cách trẻ',
        //         'Áo khoác trench coat nữ dài',
        //         'Áo khoác hoodie nữ in logo',
            
        //         // Đồ thể thao
        //         'Áo bra thể thao nữ năng động',
        //         'Quần legging thể thao nữ co giãn',
        //         'Áo tank top nữ tập gym',
            
        //         // Đầm dạ hội & Tiệc
        //         'Đầm dạ hội nữ sequin lấp lánh',
        //         'Đầm cocktail nữ xòe đuôi cá',
        //         'Đầm dự tiệc nữ cổ chữ V',
            
        //         // Áo len & Đồ mùa đông
        //         'Áo len nữ cổ lọ dáng dài',
        //         'Áo len cardigan nữ oversized',
        //         'Áo len gile nữ phối sơ mi',
            
        //         // Jumpsuits & Rompers
        //         'Jumpsuit nữ ống rộng thanh lịch',
        //         'Romper nữ tay ngắn họa tiết',
           
        // ];
        // $images = [
        //     'product-01.jpg',
        //     'product-02.jpg',
        //     'product-03.jpg',
        //     'product-04.jpg',
        //     'product-05.jpg',
        //     'product-06.jpg',
        //     'product-07.jpg',
        //     'product-08.jpg',
        //     'product-09.jpg',
        //     'product-10.jpg',
        //     'product-11.jpg',
        //     'product-12.jpg',
        //     'product-13.jpg',
        //     'product-14.jpg',
        //     'product-15.jpg',
        //     'product-16.jpg',
        // ];
        // foreach ($productNames as $name) {
        //     Product::create([
        //         'name' => $name,
        //         'slug' => Str::slug($name),
        //         'description' => 'Sản phẩm ' . $name . ' chất lượng cao, phù hợp với phong cách hiện đại.',
        //         'price' => rand(10, 1000) + (rand(0, 99) / 100), // Giá ngẫu nhiên từ 10.00 đến 1000.99
        //         'image' => 'assets/images/' . $images[array_rand($images)],
        //        'status' => $faker->randomElement(['active', 'inactive']), 
        //         'category_id' => Category::inRandomOrder()->first()->id,
        //     ]);
        // }

        // // Seed product variants
        ProductVariant::factory(100)->create();

        // // Seed customers
        // Customer::factory(10)->create();

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
        // Coupon::factory(10)->create();

        // // Seed notifications
        // Notification::factory(30)->create();
    }
}
