<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'amount', 'method', 'status', 'transaction_code', 'paid_at'];

    // Quan hệ với bảng Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
