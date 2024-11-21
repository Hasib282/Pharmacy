<?php

namespace App\Http\Controllers\API\Backend\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}
