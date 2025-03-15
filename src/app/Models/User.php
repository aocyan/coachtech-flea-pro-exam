<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class, 'profile_user_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class,'product_user_id','purchaser_user_id');
    }

    public function comments() {
        return $this->hasMany(Comment::class,'user_comment_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
