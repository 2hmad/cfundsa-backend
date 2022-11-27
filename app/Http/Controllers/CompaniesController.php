<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function getLimitedCompanies()
    {
        return Companies::orderBy('id', 'DESC')->limit(4)->get();
    }
    public function getCompanies()
    {
        return Companies::orderBy('id', 'DESC')->get();
    }
    public function createCompany(Request $request)
    {
        $checkCompany = Companies::where('company_name', $request->company_name)->first();
        if ($checkCompany) {
            return response()->json([
                'alert' => 'الشركة موجودة بالفعل',
            ], 400);
        }
        Companies::create([
            'company_number' => str_pad(Companies::count() + 1, 6, '0', STR_PAD_LEFT),
            'company_name' => $request->company_name,
            'commercial_register' => $request->commercial_register,
            'website' => $request->website,
            'sector' => $request->sector,
            'share_manager_name' => $request->share_manager_name,
            'share_manager_phone' => $request->share_manager_phone,
            // 'investor_category' => $request->investor_category,
            // 'ipos_platform' => $request->platform,
            // 'funding_amount' => $request->funding_amount,
            'share_price' => $request->share_price,
            'company_evaluation' => $request->company_valuation,
            // 'first_round_investors' => $request->investors_number_round1,
            // 'second_round_investors' => $request->investors_number_round2,
            // 'first_round_offering' => $request->launch_date_round1,
            // 'second_round_offering' => $request->launch_date_round2,
            // 'ipos_status' => $request->ipos_status,
            'details' => $request->details,
        ]);
    }
    public function deleteCompany($id)
    {
        Companies::where('id', $id)->delete();
    }
}
