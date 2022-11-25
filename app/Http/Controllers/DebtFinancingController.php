<?php

namespace App\Http\Controllers;

use App\Models\DebtPlatforms;
use App\Models\DebtStatistics;
use App\Models\TroubledCompanies;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DebtFinancingController extends Controller
{
    public function getPlatforms()
    {
        return DebtPlatforms::orderBy('id', 'DESC')->get();
    }
    public function createPlatforms(Request $request)
    {
        return DebtPlatforms::create([
            'number' => $request->number,
            'platform_name' => $request->platform_name,
            'status' => $request->type,
            'location' => $request->location,
        ]);
    }
    public function deletePlatforms($id)
    {
        return DebtPlatforms::where('id', $id)->delete();
    }
    public function getCompanies()
    {
        return TroubledCompanies::orderBy('id', 'DESC')->get();
    }
    public function createCompanies(Request $request)
    {
        return TroubledCompanies::create([
            'platform_name' => $request->platform_name,
            'company_name' => $request->company_name,
            'loan_date' => $request->loan_date,
            'due_date' => $request->due_date,
            'category' => $request->category,
            'delay' => $request->delay,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);
    }
    public function deleteCompanies($id)
    {
        return TroubledCompanies::where('id', $id)->delete();
    }
    public function getStatistics()
    {
        return DebtStatistics::orderBy('id', 'DESC')->first();
    }
    public function createStatistics(Request $request)
    {
        $image = $request->file('image');
        $image_name = time() . '.' . $image->getClientOriginalExtension();
        $image->move(storage_path('/app/public/debt-statistics'), $image_name);
        return DebtStatistics::create([
            'title' => $request->title,
            'publish_date' => Carbon::now(),
            'content' => $request->content,
            'image' => 'storage/debt-statistics/' . $image_name,
        ]);
    }
    public function deleteStatistics($id)
    {
        return DebtStatistics::where('id', $id)->delete();
    }
}
