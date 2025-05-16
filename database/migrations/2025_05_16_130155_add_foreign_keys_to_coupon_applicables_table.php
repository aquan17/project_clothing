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
        Schema::table('coupon_applicables', function (Blueprint $table) {
            $table->foreign(['coupon_id'], 'coupon_applicables_ibfk_1')->references(['id'])->on('coupons')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupon_applicables', function (Blueprint $table) {
            $table->dropForeign('coupon_applicables_ibfk_1');
        });
    }
};
