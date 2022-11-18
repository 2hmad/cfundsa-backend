<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Podcasts extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'publish_date',
        'content',
        'tags',
        'views',
        'video_url',
        'thumbnail',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'tags' => 'array',
    ];
}
