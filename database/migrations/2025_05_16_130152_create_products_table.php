<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sku', 100)->nullable()->unique('sku');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10);
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active')->index('idx_products_status');
            $table->unsignedBigInteger('category_id')->index('idx_category_id');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('total_stock')->nullable()->default(0);
            $table->unsignedBigInteger('buyer_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
