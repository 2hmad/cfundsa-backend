<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\WaitingDates;
use Illuminate\Http\Request;

class WaitingDatesController extends Controller
{
    public function getWaitingDates()
    {
        return Appointments::orderBy('id', 'DESC')->with('company')->limit(10)->get();
    }
}
