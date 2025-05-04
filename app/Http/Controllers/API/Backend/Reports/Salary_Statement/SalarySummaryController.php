<?php

namespace App\Http\Controllers\API\Backend\Reports\Salary_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

use App\Models\Transaction_Main;

class SalarySummaryController extends Controller
{
    // Show All Salary Summary Report
    public function Show(Request $req){
        $salary = Transaction_Main::on('mysql_second')->with('User')
        ->where('tran_method','Payment')
        ->where('tran_type', 3)
        ->orderBy('id','asc')
        ->get();

        return response()->json([
            'status'=> true,
            'data' => $salary,
        ], 200);
    } // End Method



    // Search Salary Summary Report
    public function Search(Request $req){
        $start = Carbon::parse($req->startDate)->startOfMonth()->toDateString(); // 2025-01-01
        $end = Carbon::parse($req->endDate)->endOfMonth()->toDateString();
        
        $data = Transaction_Main::on('mysql_second')
        ->with('User')
        ->where('tran_type', 3)
        ->where('tran_method','Payment')
        ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$start, $end])
        ->orderBy('id','asc')
        ->get();
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Print Salary Summary Report
    public function Print(Request $req){
        if ($req->query()) {
            $currentYear = $req->year;
            $currentMonth = $req->month;
            $data = Transaction_Main::on('mysql_second')->with('User')
            ->whereHas('User', function ($query) use ($req) {
                $query->where('user_name', 'like', '%'.$req->search.'%');
                $query->orWhere('user_id', 'like', '%'.$req->search.'%');
            })
            ->where('tran_type', 3)
            ->where('tran_method','Payment')
            ->whereYear('tran_date', $currentYear)
            ->whereMonth('tran_date', $currentMonth)
            ->orderBy('id','asc')
            ->get();
        } else {
            $data = Transaction_Main::on('mysql_second')->with('User')
            ->where('tran_method','Payment')
            ->where('tran_type', 3)
            ->orderBy('id','asc')
            ->paginate(15);
        }

        $report_name = 'Salary Summary Report';
        $start_date = $req->startDate ? $req->startDate : date('d/m/Y');
        $end_date = $req->endDate ? $req->endDate : date('d/m/Y');
        $pdf = Pdf::loadView('reports.salary_statement.summary.print', compact('report_name', 'start_date', 'end_date', 'data'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    } // End Method
}
