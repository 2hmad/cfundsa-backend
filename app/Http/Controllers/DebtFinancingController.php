<?php

namespace App\Http\Controllers;

use App\Models\DebtPlatforms;
use App\Models\DebtStatistics;
use App\Models\TroubledCompanies;
use Illuminate\Http\Request;

class DebtFinancingController extends Controller
{
    public function getPlatforms()
    {
        return DebtPlatforms::orderBy('id', 'DESC')->get();
    }
    public function getCompanies()
    {
        return TroubledCompanies::orderBy('id', 'DESC')->get();
    }
    public function getStatistics()
    {
        return DebtStatistics::orderBy('id', 'DESC')->first();
    }
}
