<?php

namespace App\Http\Controllers\API\Backend\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Transaction_Main;

class ReportsByGroupController extends Controller
{
    // Show All Salary Details Report
    public function ShowAll(Request $req){
        $transactions = Transaction_Main::with('User','Bank')
        ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
        ->orderBy('tran_date','asc')
        ->paginate(15);
        
        return response()->json([
            'status'=> true,
            'data' => $transactions,
        ], 200);
    } // End Method



    // Search Salary Details Report
    public function Search(Request $req){
        $transactions = Transaction_Main::with('User','Bank')
        ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
        ->orderBy('tran_date','asc')
        ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $transactions,
        ], 200);
    } // End Method



    // Print Reports By Groupe
    public function Print(Request $req){
        if ($req->query()) {
            $data = Transaction_Main::with('User','Bank')
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->orderBy('tran_date','asc')
            ->get();
        }
        else {
            $data = Transaction_Main::with('User','Bank')
            ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
            ->orderBy('tran_date','asc')
            ->get();
        }
        
        $report_name = 'Reports By Groupe';
        $start_date = $req->startDate ? $req->startDate : date('d/m/Y');
        $end_date = $req->endDate ? $req->endDate : date('d/m/Y');
        $pdf = Pdf::loadView('reports.report_by_groupe.print', compact('report_name', 'start_date', 'end_date', 'data'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    } // End Method
}
