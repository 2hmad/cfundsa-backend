<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneVerification extends Model
{
    use HasFactory;
    protected $table = 'phone_verification';
    protected $fillable = [
        'user_id',
        'code',
        'expire'
    ];
}
