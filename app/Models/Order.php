<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
 protected $fillable = [
        'name', 'phone', 'email', 'address', 'upazila', 'district', 'division',
        'items', 'subtotal', 'shipping', 'total', 'payment_method', 'status'
    ];
    protected $casts = [
        'items' => 'array',
    ];
}
