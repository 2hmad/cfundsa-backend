<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'image',
        'token',
        'phone_verified',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
    ];

    public function followers()
    {
        return $this->hasMany(Followers::class, 'user_id');
    }
    public function comments()
    {
        return $this->hasMany(ArticlesComments::class, 'user_id')->with('article');
    }
}
