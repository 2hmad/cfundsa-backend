<?php

namespace App\Http\Controllers;

use App\Models\Podcasts;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PodcastsController extends Controller
{
    public function getPodcasts()
    {
        $podcasts = Podcasts::orderBy('id', 'DESC')->paginate(10);
        $podcasts->getCollection()->transform(function ($podcast) {
            $podcast->content = substr($podcast->content, 0, 200) . '...';
            return $podcast;
        });
        return $podcasts;
    }
    public function getAllPodcasts()
    {
        $podcasts = Podcasts::orderBy('id', 'DESC')->get();
        return $podcasts;
    }
    public function getPodcast($id)
    {
        $podcasts = Podcasts::where('id', $id)->first();
        $newest = Podcasts::orderBy('id', 'DESC')->limit(3)->get();
        // return short content in newest
        $newest->transform(function ($podcast) {
            $podcast->content = substr($podcast->content, 0, 200) . '...';
            return $podcast;
        });
        return [
            'podcast' => $podcasts,
            'newest' => $newest,
        ];
    }
    public function createPodcasts(Request $request)
    {
        $image = $request->file('thumbnail');
        $image_name = time() . '.' . $image->getClientOriginalExtension();
        $image->move(storage_path('/app/public/podcasts'), $image_name);
        Podcasts::create([
            'title' => $request->title,
            'publish_date' => Carbon::now(),
            'content' => $request->content,
            'tags' => $request->tags,
            'views' => 0,
            'video_url' => $request->video,
            'thumbnail' => "storage/podcasts/" . $image_name,
        ]);
    }
    public function deletePodcast($id)
    {
        Podcasts::where('id', $id)->delete();
    }
}
