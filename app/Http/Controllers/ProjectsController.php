<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function getLimitedProjects()
    {
        return Projects::orderBy('id', 'desc')->with('company')->limit(5)->get();
    }
    public function getProjects()
    {
        return Projects::orderBy('id', 'desc')->with('company')->get();
    }
    public function getProject($id)
    {
        return Projects::where('id', $id)->with('company')->first();
    }
    public function createProjects(Request $request)
    {
        Projects::create([
            'project' => $request->project,
            'company_id' => $request->company_id,
            'fund_id' => $request->investment_fund,
            'date' => $request->date,
            'status' => $request->status,
        ]);
    }
    public function editProjects(Request $request, $id)
    {
        Projects::where('id', $id)->update([
            'project' => $request->project,
            'company_id' => $request->company_id,
            'fund_id' => $request->investment_fund,
            'date' => $request->date,
            'status' => $request->status,
        ]);
    }
    public function deleteProjects($id)
    {
        Projects::find($id)->delete();
    }
}
