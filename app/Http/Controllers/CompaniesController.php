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
    public function getCompany($id)
    {
        return Companies::where('id', $id)->first();
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
            'share_manager_name' => $request->manager_name,
            'share_manager_phone' => $request->manager_phone,
            'share_price' => $request->share_price,
            'company_evaluation' => $request->company_valuation,
            'details' => $request->details,
        ]);
    }
    public function updateCompany(Request $request, $id)
    {
        $company = Companies::where('id', $id)->first();
        $company->update([
            'company_name' => $request->company_name,
            'commercial_register' => $request->commercial_register,
            'website' => $request->website,
            'sector' => $request->sector,
            'share_manager_name' => $request->manager_name,
            'share_manager_phone' => $request->manager_phone,
            'share_price' => $request->share_price,
            'company_evaluation' => $request->company_valuation,
            'details' => $request->details,
        ]);
    }
    public function deleteCompany($id)
    {
        Companies::where('id', $id)->delete();
    }
}
