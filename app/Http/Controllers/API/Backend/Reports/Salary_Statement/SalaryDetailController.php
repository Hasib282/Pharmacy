<?php

namespace App\Http\Controllers\API\Backend\Reports\Salary_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Transaction_Detail;

class SalaryDetailController extends Controller
{
    // Show All Salary Details Report
    public function ShowAll(Request $req){
        $salary = Transaction_Detail::on('mysql_second')->with('User','Head')
        ->where('tran_method','Payment')
        ->where('tran_type', 3)
        ->orderBy('id','asc')
        ->paginate(15);
        
        return response()->json([
            'status'=> true,
            'data' => $salary,
        ], 200);
    } // End Method



    // Search Salary Details Report
    public function Search(Request $req){
        $currentYear = $req->year;
        $currentMonth = $req->month;
        $salary = Transaction_Detail::on('mysql_second')->with('User','Head')
        ->whereHas('User', function ($query) use ($req) {
            $query->where('user_name', 'like', '%'.$req->search.'%');
            $query->orWhere('user_id', 'like', '%'.$req->search.'%');
        })
        ->where('tran_type', 3)
        ->where('tran_method','Payment')
        ->whereYear('tran_date', $currentYear)
        ->whereMonth('tran_date', $currentMonth)
        ->orderBy('id','asc')
        ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $salary,
        ], 200);
    } // End Method



    // Print Salary Details Report
    public function Print(Request $req){
        if ($req->query()) {
            $currentYear = $req->year;
            $currentMonth = $req->month;
            $data = Transaction_Detail::on('mysql_second')->with('User','Head')
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
            $data = Transaction_Detail::on('mysql_second')
            ->with('User','Head')
            ->where('tran_method','Payment')
            ->where('tran_type', 3)
            ->orderBy('id','asc')
            ->get();
        }


        $report_name = 'Salary Details Report';
        $start_date = $req->startDate ? $req->startDate : date('d/m/Y');
        $end_date = $req->endDate ? $req->endDate : date('d/m/Y');
        $pdf = Pdf::loadView('reports.salary_statement.details.print', compact('report_name', 'start_date', 'end_date', 'data'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    } // End Method
}
