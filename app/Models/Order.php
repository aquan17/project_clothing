<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'total_price', 'status', 'payment_method', 'payment_status'];

    // Quan hệ với bảng Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Quan hệ với bảng OrderItem
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Quan hệ với bảng Payment
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}

