<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TroubledCompanies extends Model
{
    use HasFactory;
    protected $table = 'troubled_companies';
    protected $fillable = [
        'platform_name',
        'company_name',
        'loan_date',
        'due_date',
        'category',
        'delay',
        'status',
        'notes',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
