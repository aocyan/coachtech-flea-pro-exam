<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_comment_id',
        'user_comment_id',
        'comment',
    ];

    public function product() 
    {
        return $this->belongsTo(Product::class,'product_comment_id');
    }

    public function user() 
    {
        return $this->belongsTo(User::class,'user_comment_id');
    }
}
