<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'slug', 'description', 'price', 'image', 'status', 'category_id', 'total_stock', 'sku'];

    // Quan hệ với bảng Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Quan hệ với bảng ProductVariant
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);   
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
}
