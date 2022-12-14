<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaitingDates extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'appointment',
        'appointment_type',
        'location',
        'date',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function company()
    {
        return $this->belongsTo(Companies::class);
    }
}
