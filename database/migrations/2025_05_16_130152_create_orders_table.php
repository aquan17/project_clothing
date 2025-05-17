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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_code');
            $table->unsignedBigInteger('customer_id')->index('orders_customer_id_foreign');
            $table->bigInteger('notifiable_id')->nullable();
            $table->string('notifiable_type')->nullable();
            $table->unsignedBigInteger('shipping_address_id')->nullable()->index('orders_shipping_address_id_foreign');
            $table->decimal('total_price', 10);
            $table->decimal('voucher_discount', 10)->default(0);
            $table->unsignedBigInteger('coupon_id')->nullable()->index('orders_coupon_id_foreign');
            $table->decimal('shipping_fee', 10)->default(0);
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled','cart'])->default('pending')->index('idx_orders_status');
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->default('unpaid')->index('idx_payment_status');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_id')->nullable()->index('fk_orders_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
