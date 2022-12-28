<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealsComplaints extends Model
{
    use HasFactory;
    protected $table = 'deals_complaints';
    protected $fillable = [
        'deal_id',
        'content',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function deal()
    {
        return $this->belongsToMany(Deals::class, 'id', 'deal_id');
    }
}
