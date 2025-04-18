<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'product_id', 'rating'];

    // Quan hệ với bảng Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Quan hệ với bảng Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
