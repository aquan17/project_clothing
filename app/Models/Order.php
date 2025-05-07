<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use HasFactory,Notifiable;

    protected $fillable = ['order_code','customer_id', 'total_price', 'status', 'payment_method', 'payment_status','notes',
    'coupon_id','shipping_address_id','shipping_fee','voucher_discount','user_id','notifiable_id'];

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
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
    public function shippingAddress()
    {
        return $this->belongsTo(ShippingAddress::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

}

