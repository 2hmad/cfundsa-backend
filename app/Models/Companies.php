<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_number',
        'company_name',
        'commercial_register',
        'website',
        'sector',
        'share_manager_name',
        'share_manager_phone',
        'share_price',
        'company_evaluation',
        'details',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
