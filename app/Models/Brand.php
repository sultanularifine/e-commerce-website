<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'logo',
        'description',
        'status',
    ];

    protected static function booted()
    {
        static::creating(function ($brand) {
            $brand->slug = $brand->slug ?: Str::slug($brand->name);
        });
    }

    // Relationship
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
