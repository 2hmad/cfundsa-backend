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
        'investor_category',
        'ipos_platform',
        'size',
        'funding_amount',
        'share_price',
        'first_round_investors',
        'second_round_investors',
        'offering_price',
        'offering_ratio',
        'first_round_offering',
        'second_round_offering',
        'ipos_status',
        'ipos_manager',
        'details',
        'created_at',
        'updated_at',
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
