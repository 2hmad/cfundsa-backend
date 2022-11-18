<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\Statements;
use Illuminate\Http\Request;

class StatementsController extends Controller
{
    public function getStatements($year)
    {
        $statements = Statements::where('year', $year)->with('company')->get();
        return $statements;
    }
    public function getAllStatements()
    {
        $statements = Statements::orderBy('id', 'DESC')->with('company')->get();
        return $statements;
    }
    public function createStatement(Request $request)
    {
        $company = Companies::where('id', $request->company_id)->first();
        $pdf = $request->file('file');
        $pdfName = $company->company_name . '-' . $request->year . '-' . $request->type . '.' . $pdf->getClientOriginalExtension();
        $pdf->move(storage_path('/app/public/statements'), $pdfName);
        $statement = Statements::where([
            ['company_id', $request->company_id],
            ['year', $request->year],
        ])->first();
        if ($statement) {
            $type = $request->type;
            $statement->$type = $pdfName;
            $statement->save();
        } else {
            $statement = Statements::create([
                'company_id' => $request->company_id,
                'category' => $company->sector,
                'year' => $request->year,
                $request->type => $pdfName,
            ]);
        }
    }
    public function deleteStatement($id)
    {
        Statements::where('id', $id)->delete();
    }
}
