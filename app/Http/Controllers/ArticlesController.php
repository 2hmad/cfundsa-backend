<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use App\Models\ArticlesComments;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function thumbs()
    {
        $articles = Articles::limit(4)->inRandomOrder()->where('article_type', 'article')->with('comments')->get();
        // map on articles and exclude content
        $articles = $articles->map(function ($article) {
            $article->content = null;
            return $article;
        });
        return $articles;
    }
    public function getAllArticles()
    {
        $articles = Articles::orderBy('id', 'DESC')->get();
        return $articles;
    }
    public function getArticles()
    {
        $articles = Articles::orderBy('id', 'DESC')->where('article_type', 'article')->paginate(10);
        $articles->getCollection()->transform(function ($article) {
            $article->content = substr($article->content, 0, 200) . '...';
            return $article;
        });
        $news = Articles::orderBy('id', 'DESC')->where('article_type', 'news')->with('comments')->paginate(6);
        $news->getCollection()->transform(function ($news) {
            $news->content = substr($news->content, 0, 200) . '...';
            return $news;
        });
        // extract articles and appointments from article_type
        return [
            'articles' => $articles,
            'news' => $news,
        ];
    }
    public function getArticle($id)
    {
        $article = Articles::where('id', $id)->with('comments')->first();
        $article->views = $article->views + 1;
        $article->save();
        return $article;
    }
    public function getMostArticles()
    {
        $mostViews = Articles::orderBy('views', 'DESC')->limit(6)->get();
        $mostComments = Articles::orderBy('comments', 'DESC')->limit(6)->get();
        $mostViews = $mostViews->map(function ($article) {
            return [
                'title' => $article->title,
                'id' => $article->id,
                'views' => $article->views,
                'comments' => $article->comments,
            ];
        });
        $mostComments = $mostComments->map(function ($article) {
            return [
                'title' => $article->title,
                'id' => $article->id,
                'comments' => $article->comments,
            ];
        });
        return [
            'mostViews' => $mostViews,
            'mostComments' => $mostComments,
        ];
    }
    public function addComment(Request $request)
    {
        $user = Users::where('token', $request->header('Authorization'))->first();
        $add_comment = ArticlesComments::create([
            'article_id' => $request->article_id,
            'user_id' => $user->id,
            'content' => $request->content,
        ]);
        // return $add_comment with user
        $add_comment->user = $user;
        // increase article comment
        $article = Articles::where('id', $request->article_id)->first();
        $article->comments = $article->comments + 1;
        $article->save();
        return $add_comment;
    }
    public function createArticle(Request $request)
    {
        $checkArticle = Articles::where([
            ['title', $request->title],
            ['article_type', $request->category],
        ])->first();
        if ($checkArticle !== null) {
            return response()->json([
                'alert' => 'المقال موجود مسبقاً',
            ], 400);
        }
        $image = $request->file('image');
        $image_name = time() . '.' . $image->getClientOriginalExtension();
        $image->move(storage_path('/app/public/articles'), $image_name);
        $article = Articles::create([
            'title' => $request->title,
            'type' => $request->type,
            'publish_date' => Carbon::now(),
            'content' => $request->content,
            'tags' => $request->tags,
            'views' => 0,
            'comments' => 0,
            'image' => 'storage/articles/' . $image_name,
            'article_type' => $request->category,
        ]);
        return $article;
    }
    public function deleteArticle($id)
    {
        $article = Articles::where('id', $id)->first();
        $image = $article->image;
        $image = str_replace('storage/articles/', '', $image);
        unlink(storage_path('/app/public/articles/' . $image));
        $article->delete();
    }
}
