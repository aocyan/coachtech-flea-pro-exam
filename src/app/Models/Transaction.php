<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_transaction_id',
        'product_transaction_id',
        'comment',
        'image',
        'seller_comment_count',
        'transaction_comment_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_transaction_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_transaction_id');
    }
}
