<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statements extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'category',
        'year',
        'first_quart',
        'second_quart',
        'third_quart',
        'fourth_quart',
        'annual',
        'director_report',
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
