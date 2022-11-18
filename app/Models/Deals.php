<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deals extends Model
{
    use HasFactory;
    protected $fillable = [
        'ad_id',
        'chat_id',
        'seller_name',
        'seller_phone',
        'buyer_name',
        'buyer_phone',
        'company_id',
        'shares_qty',
        'price',
        'status',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }
}
