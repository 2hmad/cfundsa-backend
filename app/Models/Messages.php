<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;
    protected $table = 'messages';
    protected $fillable = [
        'chat_id',
        'user_id',
        'message',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'updated_at'
    ];
    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }
}
