<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_user_id',
        'image',
        'postal',
        'address',
        'building',
        'evaluation',
        'evaluation_count',
        'before_evaluation_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'profile_user_id');
    }
}
