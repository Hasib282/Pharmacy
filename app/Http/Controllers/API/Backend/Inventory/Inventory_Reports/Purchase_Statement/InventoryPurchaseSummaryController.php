<?php

namespace App\Http\Controllers\API\Backend\Inventory\Inventory_Reports\Purchase_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Transaction_Main;

class InventoryPurchaseSummaryController extends Controller
{
    // Show All Inventory Purchase Summary Statement
    public function ShowAll(Request $req){
        $inventory = Transaction_Main::on('mysql_second')->with('User')
        ->where('tran_method','Purchase')
        ->where('tran_type', 5)
        ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
        ->orderBy('id','asc')
        ->paginate(15);

        return response()->json([
            'status'=> true,
            'data' => $inventory,
        ], 200);
    } // End Method



    // Search Inventory Purchase Summary Statement
    public function Search(Request $req){
        if($req->searchOption == 1){
            $inventory = Transaction_Main::on('mysql_second')->with('User')
            ->where('tran_id', "like", '%'. $req->search .'%')
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', $req->type)
            ->orderBy('tran_id','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $inventory = Transaction_Main::on('mysql_second')->with('User')
            ->whereHas('User', function ($query) use ($req) {
                $query->where('user_name', 'like', $req->search.'%');
                $query->orderBy('user_name','asc');
            })
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', $req->type)
            ->paginate(15);
        }
        
        return response()->json([
            'status' => true,
            'data' => $inventory,
        ], 200);
    } // End Method



    // Print Inventory Purchase Summary Report
    public function Print(Request $req){
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
            ->where('tran_type', 5)
            ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
            ->orderBy('id','asc')
            ->get();
        }
        
        $report_name = 'Inventory Purchase Summary Report';
        $start_date = $req->startDate ? $req->startDate : date('d/m/Y');
        $end_date = $req->endDate ? $req->endDate : date('d/m/Y');
        $pdf = Pdf::loadView('reports.product_reports.purchase_statement.summary.print', compact('report_name', 'start_date', 'end_date', 'data'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    } // End Method
}
