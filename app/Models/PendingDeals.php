<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingDeals extends Model
{
    use HasFactory;
    protected $table = 'pending_deals';
    protected $fillable = [
        'chat_id',
        'approved_by_owner',
        'approved_by_user',
    ];
}
