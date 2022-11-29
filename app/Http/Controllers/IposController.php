<?php

namespace App\Http\Controllers;

use App\Models\IPOS;
use Illuminate\Http\Request;

class IposController extends Controller
{
    public function getLimitedIpos()
    {
        return IPOS::orderBy('id', 'DESC')->with('company')->limit(5)->get();
    }
    public function getIpos()
    {
        return IPOS::orderBy('id', 'DESC')->with('company')->get();
    }
    public function getIposByID($id)
    {
        return IPOS::where('id', $id)->with('company')->first();
    }
    public function createIpos(Request $request)
    {
        IPOS::create([
            'company_id' => $request->company_id,
            'first_round_company_evaluation' => $request->first_round_company_evaluation,
            'second_round_company_evaluation' => $request->second_round_company_evaluation,
            'investor_category' => $request->investor_category,
            'ipos_platform' => $request->platform,
            'first_round_funding_amount' => $request->first_round_funding_amount,
            'second_round_funding_amount' => $request->second_round_funding_amount,
            'first_round_share_price' => $request->first_round_share_price,
            'second_round_share_price' => $request->second_round_share_price,
            'first_round_investors' => $request->first_round_investors,
            'second_round_investors' => $request->second_round_investors,
            'first_round_offering' => $request->first_round_date,
            'second_round_offering' => $request->second_round_date,
            'offering_ratio' => $request->offer_percentage,
            'ipos_status' => $request->status,
            'ipos_manager' => $request->manager,
            "news_link" => $request->news_link,
            'details' => $request->details,
        ]);
    }
    public function updateIpos(Request $request, $id)
    {
        IPOS::where('id', $id)->update([
            'first_round_company_evaluation' => $request->first_round_company_evaluation,
            'second_round_company_evaluation' => $request->second_round_company_evaluation,
            'investor_category' => $request->investor_category,
            'ipos_platform' => $request->platform,
            'first_round_funding_amount' => $request->first_round_funding_amount,
            'second_round_funding_amount' => $request->second_round_funding_amount,
            'first_round_share_price' => $request->first_round_share_price,
            'second_round_share_price' => $request->second_round_share_price,
            'first_round_investors' => $request->first_round_investors,
            'second_round_investors' => $request->second_round_investors,
            'first_round_offering' => $request->first_round_date,
            'second_round_offering' => $request->second_round_date,
            'offering_ratio' => $request->offer_percentage,
            'ipos_status' => $request->status,
            'ipos_manager' => $request->manager,
            "news_link" => $request->news_link,
            'details' => $request->details,
        ]);
    }
    public function deleteIpos($id)
    {
        IPOS::where('id', $id)->delete();
    }
}
