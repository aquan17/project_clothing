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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign(['user_id'], 'fk_orders_user_id')->references(['id'])->on('users')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['coupon_id'])->references(['id'])->on('coupons')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['customer_id'])->references(['id'])->on('customers')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['shipping_address_id'])->references(['id'])->on('shipping_addresses')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('fk_orders_user_id');
            $table->dropForeign('orders_coupon_id_foreign');
            $table->dropForeign('orders_customer_id_foreign');
            $table->dropForeign('orders_shipping_address_id_foreign');
        });
    }
};
