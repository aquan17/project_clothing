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
        Schema::table('coupon_usages', function (Blueprint $table) {
            $table->foreign(['coupon_id'], 'coupon_usages_ibfk_1')->references(['id'])->on('coupons')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['user_id'], 'coupon_usages_ibfk_2')->references(['id'])->on('users')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['order_id'], 'coupon_usages_ibfk_3')->references(['id'])->on('orders')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupon_usages', function (Blueprint $table) {
            $table->dropForeign('coupon_usages_ibfk_1');
            $table->dropForeign('coupon_usages_ibfk_2');
            $table->dropForeign('coupon_usages_ibfk_3');
        });
    }
};
