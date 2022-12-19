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
        $articles = Articles::where([
            ['article_type', 'article'],
            ['pin', '1'],
            ['published', 1],
        ])->with('comments')->limit(4)->get();
        // map on articles and exclude content
        $articles = $articles->map(function ($article) {
            $article->content = null;
            return $article;
        });
        return $articles;
    }
    public function getAllArticles()
    {
        $articles = Articles::where('published', 1)->orderBy('id', 'DESC')->get();
        return $articles;
    }
    public function getArticles()
    {
        $articles = Articles::orderBy('id', 'DESC')->where([
            ['article_type', 'article'],
            ['published', 1]
        ])->paginate(6);
        $articles->getCollection()->transform(function ($article) {
            $article->content = substr($article->content, 0, 200) . '...';
            return $article;
        });
        $news = Articles::orderBy('id', 'DESC')->where([
            ['article_type', 'news'],
            ['published', 1]
        ])->with('comments')->paginate(10);
        $news->getCollection()->transform(function ($news) {
            $news->content = substr($news->content, 0, 200) . '...';
            return $news;
        });
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
        $mostViews = Articles::where('published', 1)->orderBy('views', 'DESC')->limit(6)->get();
        $mostComments = Articles::where('published', 1)->orderBy('comments', 'DESC')->limit(6)->get();
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
            'type_color' => $request->type_color,
            'publish_date' => Carbon::now(),
            'content' => $request->content,
            'companies' => $request->companies,
            "fund_ids" => $request->investments_funds,
            'tags' => $request->tags,
            'views' => 0,
            'comments' => 0,
            'pin' => $request->pin,
            'image' => 'storage/articles/' . $image_name,
            'article_type' => $request->category,
            'published' => 1,
        ]);
        return $article;
    }
    public function updateArticle(Request $request, $id)
    {
        Articles::where('id', $id)->update([
            'title' => $request->title,
            'type' => $request->type,
            'type_color' => $request->type_color,
            'content' => $request->content,
            'tags' => $request->tags,
            'pin' => $request->pin,
            'article_type' => $request->category,
            'companies' => $request->companies,
            "fund_ids" => $request->investments_funds,
        ]);
    }
    public function deleteArticle($id)
    {
        $article = Articles::where('id', $id)->first();
        $image = $article->image;
        $image = str_replace('storage/articles/', '', $image);
        unlink(storage_path('/app/public/articles/' . $image));
        $article->delete();
    }
    public function draftArticle($type, $id)
    {
        if ($type == 'publish') {
            Articles::where('id', $id)->update([
                'published' => 1,
            ]);
        } else {
            Articles::where('id', $id)->update([
                'published' => 0,
            ]);
        }
    }
}
