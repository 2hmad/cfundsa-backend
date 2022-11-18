<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admins extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'image',
        'token',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
    ];
}
