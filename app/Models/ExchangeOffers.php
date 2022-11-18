<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeOffers extends Model
{
    use HasFactory;
    protected $table = 'exchange_offers';
    protected $fillable = [
        'user_id',
        'ad_id',
        'shares_qty',
        'price',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }
}
