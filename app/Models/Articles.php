<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'type',
        'publish_date',
        'content',
        'tags',
        'views',
        'comments',
        'image',
        'article_type',
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

    public function comments()
    {
        // get comments for this article and user info and order by date
        return $this->hasMany(ArticlesComments::class, 'article_id', 'id')->with('user')->orderBy('created_at', 'DESC');
    }
}
