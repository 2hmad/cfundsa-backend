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
        'type_color',
        'publish_date',
        'content',
        'companies',
        "fund_ids",
        'tags',
        'views',
        'comments',
        'pin',
        'image',
        'article_type',
        'published',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'tags' => 'array',
        'companies' => 'array',
        'fund_ids' => 'array',
    ];

    public function comments()
    {
        return $this->hasMany(ArticlesComments::class, 'article_id', 'id')->with('user')->orderBy('created_at', 'DESC');
    }
}
