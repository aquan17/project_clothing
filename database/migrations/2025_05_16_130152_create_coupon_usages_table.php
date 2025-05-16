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
        Schema::create('coupon_usages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('coupon_id')->index('coupon_id');
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->unsignedBigInteger('order_id')->index('order_id');
            $table->decimal('discount_applied', 10);
            $table->timestamp('applied_at')->nullable()->useCurrent();
            $table->dateTime('used_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_usages');
    }
};
