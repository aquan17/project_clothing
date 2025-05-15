<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         // Danh sách 10 màu cố định
        $colors = ['Red', 'Blue', 'Black', 'White', 'Gray', 'Pink', 'Green', 'Yellow', 'Navy', 'Beige'];

        return [
            'product_id' => Product::inRandomOrder()->first()->id,
            'size' => 'S', // Giá trị mặc định, chỉ dùng khi tạo biến thể đơn lẻ
            'color' => $this->faker->randomElement($colors),
            'stock' => $this->faker->numberBetween(0, 100),
            'price' => 0.00, // Giá mặc định
        ];
    }

    /**
     * Tạo 16 biến thể (4 kích thước cố định x 4 màu ngẫu nhiên) cho một sản phẩm cụ thể.
     *
     * @param int $productId
     * @return array
     */
    public function forProduct(int $productId): array
    {
        $colors = ['Red', 'Blue', 'Black', 'White', 'Gray', 'Pink', 'Green', 'Yellow', 'Navy', 'Beige'];
        $sizes = ['S', 'M', 'L', 'XL'];

        // Chọn ngẫu nhiên 4 màu từ danh sách
        $selectedColors = $this->faker->randomElements($colors, 4);

        $variants = [];
        // Tạo 16 biến thể: 4 kích thước cố định x 4 màu ngẫu nhiên
        foreach ($sizes as $size) {
            foreach ($selectedColors as $color) {
                $variants[] = [
                    'product_id' => $productId,
                    'size' => $size,
                    'color' => $color,
                    'stock' => $this->faker->numberBetween(0, 100),
                    'price' => 0.00, // Giá mặc định
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        return $variants;
    }
}
