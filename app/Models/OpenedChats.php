<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenedChats extends Model
{
    use HasFactory;
    protected $table = 'opened_chats';
    protected $fillable = [
        'owner_id',
        'user_id',
        'ad_id',
        'chat_id',
    ];
    public function owner()
    {
        return $this->belongsTo(Users::class, 'owner_id');
    }
    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }
    public function ad()
    {
        return $this->belongsTo(ExchangeAds::class, 'ad_id');
    }
    public function messages()
    {
        return $this->hasMany(Messages::class, 'chat_id', 'chat_id')->with('user');
    }
}
