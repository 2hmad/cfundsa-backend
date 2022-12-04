<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use App\Models\InvestmentFunds;
use Illuminate\Http\Request;

class InvestmentFundsController extends Controller
{
    public function getInvestmentFunds()
    {
        return InvestmentFunds::orderBy('id', 'DESC')->get();
    }
    public function getInvestmentFund($id)
    {
        $fund = InvestmentFunds::where('id', $id)->with(['projects'])->first();
        $articles = Articles::where('fund_ids', '!=', null)->get();
        $articles = $articles->filter(function ($article) use ($fund) {
            return in_array($fund->id, $article->fund_ids);
        });
        $fund->articles = $articles;
        return $fund;
    }
    public function createInvestmentFunds(Request $request)
    {
        InvestmentFunds::create([
            'fund_number' => str_pad(InvestmentFunds::count() + 1, 6, '0', STR_PAD_LEFT),
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
