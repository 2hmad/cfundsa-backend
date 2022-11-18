<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function getProjects()
    {
        return Projects::orderBy('id', 'desc')->with('company')->get();
    }
}
