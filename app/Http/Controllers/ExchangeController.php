<?php

namespace App\Http\Controllers;

use App\Models\ExchangeAds;
use App\Models\ExchangeOffers;
use App\Models\Notifications;
use App\Models\Users;
use Illuminate\Http\Request;

class ExchangeController extends Controller
{
    public function addAd(Request $request)
    {
        $user = Users::where('token', $request->header('Authorization'))->first();
        $check = ExchangeAds::where([
            ['user_id', $user->id],
            ['company_id', $request->company_id],
            ['type', $request->type],
            ['shares_qty', $request->shares_qty],
            ['price_availability', $request->price_availability]
        ])->first();
        if ($check == null) {
            $add = ExchangeAds::create([
                'user_id' => $user->id,
                'company_id' => $request->company_id,
                'ad_id' => str_pad(ExchangeAds::count() + 1, 7, '0', STR_PAD_LEFT),
                'type' => $request->type,
                'shares_qty' => $request->shares_qty,
                'price_availability' => $request->price_availability,
                'price' => $request->price,
                'notes' => $request->notes,
                'published_at' => date('Y-m-d H:i:s'),
                'status' => 'available',
            ]);
            Notifications::create([
                'user_id' => $user->id,
                'message' => 'تم انشاء اعلانك الخاص رقم ' . $add->ad_id,
                'read' => false
            ]);
            return $add;
        } else {
            return response()->json(['alert' => 'هذا الاعلان موجود مسبقا'], 400);
        }
    }
    public function editExchangeAd(Request $request, $id)
    {
        $ad = ExchangeAds::where('id', $id)->first();
        $user = Users::where('token', $ad->user_id)->first();
        ExchangeAds::where('id', $id)->update([
            'company_id' => $request->company_id,
            'type' => $request->type,
            'shares_qty' => $request->shares_qty,
            'price_availability' => $request->price_availability,
            'price' => $request->price,
            'notes' => $request->notes,
        ]);
        Notifications::create([
            'user_id' => $user->id,
            'message' => 'تم تعديل اعلانك الخاص رقم ' . $ad->ad_id . ' من قبل الادارة',
            'read' => false
        ]);
    }
    public function deleteExchangeAd($id)
    {
        $ad = ExchangeAds::where('id', $id)->first();
        Notifications::create([
            'user_id' => $ad->user_id,
            'message' => 'تم حذف اعلانك الخاص رقم ' . $ad->ad_id . ' من قبل الادارة',
            'read' => false
        ]);
        $offers = ExchangeOffers::where('ad_id', $id)->get();
        foreach ($offers as $offer) {
            ExchangeOffers::where('id', $offer->id)->delete();
        }
        ExchangeAds::where('id', $id)->delete();
    }
    public function getAdsByUser(Request $request)
    {
        $user = Users::where('token', $request->header('Authorization'))->first();
        $ads = ExchangeAds::orderBy('id', 'DESC')->where('user_id', $user->id)->with(['offers', 'company'])->get();
        $offers = ExchangeOffers::where('user_id', $user->id)->with('ad')->get();
        $available_ads = [];
        $completed_ads = [];
        foreach ($ads as $ad) {
            if ($ad->status == 'available') {
                array_push($available_ads, $ad);
            } else if ($ad->status == 'completed') {
                array_push($completed_ads, $ad);
            }
        }
        return [
            'available_ads' => $available_ads,
            'completed_ads' => $completed_ads,
            'my_offers' => $offers,
        ];
    }
    public function getAds()
    {
        return ExchangeAds::orderBy('id', 'DESC')->with(['offers', 'company'])->get();
    }
    public function getLimitedAds()
    {
        return ExchangeAds::orderBy('id', 'DESC')->with(['offers', 'company'])->limit(5)->get();
    }
    public function getAd($id)
    {
        return ExchangeAds::where('id', $id)->with(['offers', 'company'])->first();
    }
    public function addOffer(Request $request)
    {
        $user = Users::where('token', $request->header('Authorization'))->first();
        $checkOffer = ExchangeOffers::where([
            ['user_id', $user->id],
            ['ad_id', $request->ad_id],
        ])->first();
        if ($checkOffer === null) {
            $added = ExchangeOffers::create([
                'user_id' => $user->id,
                'ad_id' => $request->ad_id,
                'shares_qty' => $request->shares_qty,
                'price' => $request->price,
            ]);
            $ad = ExchangeAds::where('id', $request->ad_id)->first();
            Notifications::create([
                'user_id' => $ad->user_id,
                'message' => 'تم اضافة عرض جديد علي اعلانك رقم ' . $ad->ad_id,
                'read' => false
            ]);
            return response()->json([
                'offer' => $added->with('user')->first(),
                'alert' => 'تم اضافة عرضك بنجاح',
            ], 200);
        } else {
            return response()->json(['alert' => 'عرضك موجود مسبقاً ، يرجي الغاؤه اولا قبل اضافة عرض من جديد'], 400);
        }
    }
    public function cancelOffer(Request $request)
    {
        // check if user is the owner of the offer
        $user = Users::where('token', $request->header('Authorization'))->first();
        $offer = ExchangeOffers::where('id', $request->offer_id)->first();
        $ad = ExchangeAds::where('id', $request->ad_id)->first();
        if ($offer->user_id === $user->id || $ad->user_id === $user->id) {
            $offer->delete();
            return response()->json(['alert' => 'تم الغاء العرض بنجاح'], 200);
        } else {
            return response()->json(['alert' => 'لا يمكنك الغاء عرض ليس لك'], 400);
        }
    }
}
