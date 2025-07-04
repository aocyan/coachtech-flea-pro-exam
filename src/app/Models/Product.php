<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_user_id',
        'purchaser_user_id',
        'transaction_user_id',
        'seller_user_id',
        'name',
        'brand',
        'color',
        'price',
        'image',
        'sold_at',
        'condition',
        'description',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'product_user_id','id');
    }

    public function comments() 
    {
        return $this->hasMany(Comment::class,'product_comment_id');
    }

    public function deliver()
    {
        return $this->hasOne(Deliver::class, 'product_delivery_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'product_transaction_id');
    }
}
