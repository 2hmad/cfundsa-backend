<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticlesComments extends Model
{
    use HasFactory;
    public $table = "article_comments";
    protected $fillable = [
        'id',
        'article_id',
        'user_id',
        'content',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id', 'id');
    }
    public function article()
    {
        return $this->belongsTo(Articles::class, 'article_id', 'id');
    }
}
