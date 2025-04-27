<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'name',
        'phone',
        'country',
        'province',
        'district',
        'ward',
        'notes',
    ];

    /**
     * ShippingAddress thuộc về Customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
