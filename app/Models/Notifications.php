<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $fillable = [
        'user_id',
        'message',
        'read',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        'updated_at',
    ];
}
