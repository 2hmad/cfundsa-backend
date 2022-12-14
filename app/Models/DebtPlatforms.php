<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebtPlatforms extends Model
{
    use HasFactory;
    protected $table = 'debt_platforms';
    protected $fillable = [
        'number',
        'platform_name',
        'status',
        'location',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
