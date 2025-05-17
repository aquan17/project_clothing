<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Cập nhật lại toàn bộ ENUM để thêm 'cart'
        DB::statement("
            ALTER TABLE orders 
            MODIFY status 
            ENUM('cart', 'pending', 'processing', 'completed', 'cancelled') 
            NOT NULL
        ");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Nếu rollback thì loại bỏ 'cart' (nếu cần)
        DB::statement("
            ALTER TABLE orders 
            MODIFY status 
            ENUM('pending', 'processing', 'completed', 'cancelled') 
            NOT NULL
        ");
        });
    }
};
