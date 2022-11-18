<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeAds extends Model
{
    use HasFactory;
    protected $table = 'exchange_ads';
    protected $fillable = [
        'user_id',
        'company_id',
        'ad_id',
        'type',
        'shares_qty',
        'price_availability',
        'price',
        'notes',
        'published_at',
        'status',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        'updated_at',
    ];
    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }
    public function offers()
    {
        return $this->hasMany(ExchangeOffers::class, 'ad_id', 'id')->with('user');
    }
    public function company()
    {
        return $this->hasOne(Companies::class, 'id', 'company_id');
    }
}
