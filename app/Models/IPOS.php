<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IPOS extends Model
{
    use HasFactory;
    public $table = 'ipos';
    protected $fillable = [
        'company_id',
        'first_round_company_evaluation',
        'second_round_company_evaluation',
        'investor_category',
        'ipos_platform',
        'first_round_funding_amount',
        'second_round_funding_amount',
        'first_round_share_price',
        'second_round_share_price',
        'first_round_investors',
        'second_round_investors',
        'first_round_offering',
        'second_round_offering',
        'offering_ratio',
        'ipos_status',
        'ipos_manager',
        'news_link',
        'details',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function company()
    {
        return $this->belongsTo(Companies::class);
    }
}
