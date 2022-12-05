<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use App\Models\Companies;
use App\Models\IPOS;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function getLimitedCompanies()
    {
        return Companies::orderBy('id', 'DESC')->limit(5)->get();
    }
    public function getCompanies()
    {
        return Companies::orderBy('id', 'DESC')->get();
    }
    public function getCompany($id)
    {
        $company = Companies::where('id', $id)->with(['projects', 'appointments'])->first();
        $articles = Articles::where('companies', '!=', null)->get();
        $articles = $articles->filter(function ($article) use ($company) {
            return in_array($company->id, $article->companies);
        });
        $company->articles = $articles;
        $ipos = IPOS::where('company_id', $id)->orderBy('id', 'DESC')->first();
        $company->ipos = $ipos;
        return $company;
    }
    public function createCompany(Request $request)
    {
        $checkCompany = Companies::where('company_name', $request->company_name)->first();
        if ($checkCompany) {
            return response()->json([
                'alert' => 'الشركة موجودة بالفعل',
            ], 400);
        }
        $image = $request->file('logo');
        $image_name =  $request->company_name . '.' . $image->getClientOriginalExtension();
        $image->move(storage_path('/app/public/companies'), $image_name);
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
            'logo' => "storage/companies/" . $image_name,
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
