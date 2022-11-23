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
    public function getWaitingDatesByDate($date)
    {
        if ($date == 'today') {
            return Appointments::where('date', date('Y-m-d'))->with('company')->get();
        } else if ($date == 'week') {
            // get appointments for this week from today to 7 days later
            $start = date('Y-m-d');
            $end = date('Y-m-d', strtotime('-7 days'));
            return Appointments::whereBetween('date', [$start, $end])->with('company')->get();
        } else if ($date == 'month') {
            return Appointments::whereMonth('date', date('m'))->with('company')->get();
        }
    }
}
