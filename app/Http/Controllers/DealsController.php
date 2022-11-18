<?php

namespace App\Http\Controllers;

use App\Models\CanceledDeals;
use App\Models\Deals;
use App\Models\DealsComplaints;
use App\Models\ExchangeAds;
use App\Models\ExchangeOffers;
use App\Models\OpenedChats;
use App\Models\Users;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DealsController extends Controller
{
    public function summary(Request $request)
    {
        $pdf = Pdf::loadView('deal-summary', $request->all());
        return $pdf->download('invoice.pdf');
    }
    public function getDeal(Request $request)
    {
        $user = Users::where('token', $request->header('Authorization'))->first();
        $chat = OpenedChats::where('chat_id', $request->chat_id)->with(['owner', 'user', 'ad', 'messages'])->first();
        if ($chat) {
            $ad = ExchangeAds::where('id', $chat->ad_id)->with(['user', 'company'])->first();
            $offer = ExchangeOffers::where([
                ['ad_id', $chat->ad_id],
                ['user_id', $chat->user_id],
            ])->with('user')->first();
            return [
                'ad' => $ad,
                'chat' => $chat,
                'offer' => $offer
            ];
        }
    }
    public function completeDeal(Request $request)
    {
        $check_deal = Deals::where('chat_id', $request->chat_id)->first();
        $ad = ExchangeAds::where('id', $request->ad_id)->first();
        if ($check_deal !== null && $ad->status !== 'available') {
            return response()->json([
                'alert' => 'الصفقة تمت من قبل'
            ], 400);
        } else {
            $deal = Deals::create([
                'ad_id' => $request->ad_id,
                'chat_id' => $request->chat_id,
                'seller_name' => $request->seller_name,
                'seller_phone' => $request->seller_phone,
                'buyer_name' => $request->buyer_name,
                'buyer_phone' => $request->buyer_phone,
                'company_id' => $request->company_id,
                'shares_qty' => $request->shares_qty,
                'price' => $request->share_price,
                'status' => 'completed',
            ]);
            $ad->status = 'completed';
            $ad->save();
            return Deals::where('id', $deal->id)->with('company')->first();
        }
    }
    public function revertDeal(Request $request)
    {
        $deal = Deals::where('chat_id', $request->chat_id)->first();
        $ad = ExchangeAds::where('id', $deal->ad_id)->first();
        $ad->status = 'available';
        $ad->save();
        CanceledDeals::where('deal_id', $deal->id)->delete();
        $deal->delete();
    }
    public function completedDeal(Request $request)
    {
        $deal = Deals::where('chat_id', $request->chat_id)->with('company')->first();
        if ($deal !== null) {
            return $deal;
        } else {
            return response()->json([
                'alert' => 'الصفقة غير موجودة'
            ], 400);
        }
    }
    public function cancelDeal(Request $request)
    {
        $deal = Deals::where('id', $request->deal_id)->first();
        CanceledDeals::create([
            'deal_id' => $request->deal_id,
            'reason' => $request->reason,
        ]);
        Deals::where('id', $request->deal_id)->update([
            'status' => 'canceled',
        ]);
        ExchangeAds::where('id', $deal->ad_id)->update([
            'status' => 'available',
        ]);
        return response()->json([
            'alert' => 'تم تحديد الصفقة علي انها لم تتم'
        ], 200);
    }
    public function recordComplaint(Request $request)
    {
        DealsComplaints::create([
            'deal_id' => $request->deal_id,
            'content' => $request->content,
        ]);
        return response()->json([
            'alert' => 'تم تسجيل الشكوى بنجاح'
        ], 200);
    }
}
