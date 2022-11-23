<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function getLimitedProjects()
    {
        return Projects::orderBy('id', 'desc')->with('company')->limit(6)->get();
    }
    public function getProjects()
    {
        return Projects::orderBy('id', 'desc')->with('company')->get();
    }
    public function createProjects(Request $request)
    {
        Projects::create([
            'project' => $request->project,
            'company_id' => $request->company_id,
            'date' => $request->date,
            'status' => $request->status,
        ]);
    }
    public function deleteProjects($id)
    {
        Projects::find($id)->delete();
    }
}
