<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_delivery_id',
        'product_name',
        'user_name',
        'postal',
        'address',
        'building',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_delivery_id');
    }
}
