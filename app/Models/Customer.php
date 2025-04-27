<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'address','user_id'];

    // Quan hệ với bảng Order
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Quan hệ với bảng Comment
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Quan hệ với bảng Rating
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // Quan hệ với bảng Wishlist
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function shippingAddresses()
{
    return $this->hasMany(ShippingAddress::class);
}

}
