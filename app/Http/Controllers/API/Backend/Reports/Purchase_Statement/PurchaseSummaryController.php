<?php

namespace App\Http\Controllers\API\Backend\Reports\Purchase_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Transaction_Main;

class PurchaseSummaryController extends Controller
{
    // Show All Purchase Summary Statement
    public function Show(Request $req){
        $type = GetTranType($req->segment(2));

        $data = Transaction_Main::on('mysql_second')
        ->with('User')
        ->where('tran_method','Purchase')
        ->where('tran_type', $type)
        ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
        ->orderBy('id','asc')
        ->get();

        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Search Purchase Summary Statement
    public function Search(Request $req){
        $type = GetTranType($req->segment(2));

        $data = Transaction_Main::on('mysql_second')
        ->with('User')
        ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
        ->where('tran_method',$req->method)
        ->where('tran_type', $type)
        ->orderBy('tran_id','asc')
        ->get();
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Print Purchase Summary Report
    public function Print(Request $req){
        $type = GetTranType($req->segment(2));

        if ($req->query()) {
            if($req->searchOption == 1){
                $data = Transaction_Main::on('mysql_second')->with('User')
                ->where('tran_id', "like", '%'. $req->search .'%')
                ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
                ->where('tran_method',$req->method)
                ->where('tran_type', $req->type)
                ->orderBy('tran_id','asc')
                ->get();
            }
            else if($req->searchOption == 2){
                $data = Transaction_Main::on('mysql_second')->with('User')
                ->whereHas('User', function ($query) use ($req) {
                    $query->where('user_name', 'like', $req->search.'%');
                    $query->orderBy('user_name','asc');
                })
                ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
                ->where('tran_method',$req->method)
                ->where('tran_type', $req->type)
                ->get();
            }
        }
        else {
            $data = Transaction_Main::on('mysql_second')->with('User')
            ->where('tran_method','Purchase')
            ->where('tran_type', $type)
            ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
            ->orderBy('id','asc')
            ->get();
        }
        
        $report_name = 'Purchase Summary Report';
        $start_date = $req->startDate ? $req->startDate : date('d/m/Y');
        $end_date = $req->endDate ? $req->endDate : date('d/m/Y');
        $pdf = Pdf::loadView('reports.product_reports.purchase_statement.summary.print', compact('report_name', 'start_date', 'end_date', 'data'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    } // End Method
}
