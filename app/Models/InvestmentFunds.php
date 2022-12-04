<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestmentFunds extends Model
{
    use HasFactory;
    protected $fillable = [
        'fund_number',
        'fund',
        'platform',
        'type',
        'offer_date',
        'value',
        'platform_share',
        'fund_duration',
        'total_return',
        'fund_manager',
        'developer',
        'location',
        'details',
    ];

    public function projects()
    {
        return $this->hasMany(Projects::class, 'fund_id');
    }
}
