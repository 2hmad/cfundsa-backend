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
    public function createIpos(Request $request)
    {
        IPOS::create([
            'company_id' => $request->company_id,
            'investor_category' => $request->investor_category,
            'ipos_platform' => $request->platform,
            'funding_amount' => $request->funding_amount,
            'size' => $request->size,
            'share_price' => $request->share_price,
            'first_round_investors' => $request->first_round_investors,
            'second_round_investors' => $request->second_round_investors,
            'offering_price' => $request->offer_price,
            'offering_ratio' => $request->offer_percentage,
            'first_round_offering' => $request->first_round_date,
            'second_round_offering' => $request->second_round_date,
            'ipos_status' => $request->status,
            'ipos_manager' => $request->manager,
            'details' => $request->details,
        ]);
    }
    public function deleteIpos($id)
    {
        IPOS::where('id', $id)->delete();
    }
}
