<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    public function getAds()
    {
        return Ads::all();
    }
    public function addAds(Request $request)
    {
        $check_ad = Ads::where('page_location', $request->page_location)->first();
        if ($check_ad) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(storage_path('/app/public/ads'), $image_name);
            $check_ad->update([
                'title' => $request->title,
                'image_path' => $image_name,
                'url' => $request->url,
            ]);
        } else {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(storage_path('/app/public/ads'), $image_name);
            Ads::create([
                'title' => $request->title,
                'image_path' => $image_name,
                'url' => $request->url,
                'page_location' => $request->page_location,
            ]);
        }
    }
}
