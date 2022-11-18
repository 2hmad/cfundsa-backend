<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebtStatistics extends Model
{
    use HasFactory;
    protected $table = 'debt_statistics';
    protected $fillable = [
        'title',
        'publish_date',
        'content',
        'image',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
