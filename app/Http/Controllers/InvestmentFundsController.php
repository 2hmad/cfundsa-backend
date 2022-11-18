<?php

namespace App\Http\Controllers;

use App\Models\InvestmentFunds;
use Illuminate\Http\Request;

class InvestmentFundsController extends Controller
{
    public function getInvestmentFunds(Request $request)
    {
        return InvestmentFunds::orderBy('id', 'DESC')->get();
    }
    public function createInvestmentFunds(Request $request)
    {
        InvestmentFunds::create([
            'fund' => $request->fund,
            'platform' => $request->platform,
            'type' => $request->type,
            'offer_date' => $request->date,
            'value' => $request->value,
            'platform_share' => $request->platformShare,
            'fund_duration' => $request->fundDuration,
            'total_return' => $request->totalReturn,
            'fund_manager' => $request->fundManager,
            'developer' => $request->developer,
            'location' => $request->location,
            'details' => $request->details,
        ]);
    }
    public function deleteInvestmentFunds($id)
    {
        InvestmentFunds::where('id', $id)->delete();
    }
}
