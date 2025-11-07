<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'stock',
        'in_stock',
        'category_id',
        'brand_id',
        'thumbnail',
        'gallery',
        'meta_title',
        'meta_description',
        'is_featured',
        'status',
    ];
     protected $casts = [
         'gallery' => 'array', // <-- important
        'is_featured' => 'boolean',
        'in_stock' => 'boolean',
        'status' => 'boolean',
    ];

    // Automatically generate slug
    protected static function booted()
    {
        static::creating(function ($product) {
            $product->slug = $product->slug ?: Str::slug($product->name);
        });
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // Accessors
    public function getFinalPriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }
    public function images()
{
    return $this->hasMany(ProductImage::class);
}
}
