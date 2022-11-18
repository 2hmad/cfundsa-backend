<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_name',
        'commercial_register',
        'website',
        'share_manager_name',
        'share_manager_phone',
        'sector',
        'investor_category',
        'ipos_platform',
        'funding_amount',
        'share_price',
        'company_evaluation',
        'first_round_investors',
        'second_round_investors',
        'first_round_offering',
        'second_round_offering',
        'ipos_status',
        'details',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
