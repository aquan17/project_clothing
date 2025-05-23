<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['customer_id', 'product_id', 'content'];

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
