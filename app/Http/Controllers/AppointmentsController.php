<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use Illuminate\Http\Request;

class AppointmentsController extends Controller
{
    public function getAppointments()
    {
        return Appointments::orderBy('date', 'DESC')->with('company')->get();
    }
    public function createAppointment(Request $request)
    {
        Appointments::create([
            'company_id' => $request->company_id,
            'event' => $request->event,
            'event_type' => $request->event_type,
            'location' => $request->location,
            'date' => $request->date
        ]);
    }
    public function deleteAppointment($id)
    {
        Appointments::find($id)->delete();
    }
}
