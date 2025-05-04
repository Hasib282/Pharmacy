<?php

namespace App\Http\Controllers\API\Backend\Reports\Stock_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Transaction_Head;

class StockSummaryController extends Controller
{
    // Show All Stock Summary Statement
    public function Show(Request $req){
        $type = GetTranType($req->segment(2));

        $data = Transaction_Head::on('mysql')
        ->with("Unit","Form","Manufecturer","Category",'Groupe')
        ->whereHas('Groupe', function ($query) use ($type){
            $query->where('tran_groupe_type', $type);
        })
        ->orderBy('tran_head_name','asc')
        ->get();

        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Search Stock Summary Statement
    public function Search(Request $req){
        $type = GetTranType($req->segment(2));

        $data = Transaction_Head::on('mysql')
        ->with("Unit","Form","Manufecturer","Category",'Groupe')
        ->whereHas('Groupe', function ($query) use ($type){
            $query->where('tran_groupe_type', $type);
        })
        ->orderBy('tran_head_name','asc')
        ->get();
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Print Stock Summary Report
    public function Print(Request $req){
        $type = GetTranType($req->segment(2));

        if ($req->query()) {
            if($req->searchOption == 1){
                $data = Transaction_Head::on('mysql')->with("Unit","Form","Manufecturer","Category",'Groupe')
                ->whereHas('Groupe', function ($query) use ($type){
                    $query->where('tran_groupe_type', $type);
                })
                ->where('tran_head_name', 'like', $req->search.'%')
                ->orderBy('tran_head_name','asc')
                ->get();
            }
            else if($req->searchOption == 2){
                $data = Transaction_Head::on('mysql')->with("Unit","Form","Manufecturer","Category",'Groupe')
                ->whereHas('Groupe', function ($query) use ($req, $type){
                    $query->where('tran_groupe_type', $type);
                    $query->where('tran_groupe_name', 'like', $req->search . '%');
                    $query->orderBy('tran_groupe_name','asc');
                })
                ->get();
            }
            else if($req->searchOption == 3){
                $data = Transaction_Head::on('mysql')->with("Unit","Form","Manufecturer","Category",'Groupe')
                ->whereHas('Groupe', function ($query) use ($type){
                    $query->where('tran_groupe_type', $type);
                })
                ->whereHas('Category', function ($query) use ($req) {
                    $query->where('category_name', 'like', $req->search . '%');
                    $query->orderBy('category_name','asc');
                })
                ->get();
            }
            else if($req->searchOption == 4){
                $data = Transaction_Head::on('mysql')->with("Unit","Form","Manufecturer","Category",'Groupe')
                ->whereHas('Groupe', function ($query) use ($type){
                    $query->where('tran_groupe_type', $type);
                })
                ->whereHas('Manufecturer', function ($query) use ($req) {
                    $query->where('manufacturer_name', 'like', $req->search . '%');
                    $query->orderBy('manufacturer_name','asc');
                })
                ->get();
            }
            else if($req->searchOption == 5){
                $data = Transaction_Head::on('mysql')->with("Unit","Form","Manufecturer","Category",'Groupe')
                ->whereHas('Groupe', function ($query) use ($type){
                    $query->where('tran_groupe_type', $type);
                })
                ->whereHas('Form', function ($query) use ($req) {
                    $query->where('form_name', 'like', $req->search . '%');
                    $query->orderBy('form_name','asc');
                })
                ->get();
            }
        }
        else {
            $data = Transaction_Head::on('mysql')->with("Unit","Form","Manufecturer","Category",'Groupe')
            ->whereHas('Groupe', function ($query) use ($type){
                $query->where('tran_groupe_type', $type);
            })
            ->orderBy('tran_head_name','asc')
            ->get();
        }
        
        $report_name = 'Stock Summary Report';
        $start_date = $req->startDate ? $req->startDate : date('d/m/Y');
        $end_date = $req->endDate ? $req->endDate : date('d/m/Y');
        $pdf = Pdf::loadView('reports.product_reports.stock_statement.summary.print', compact('report_name', 'start_date', 'end_date', 'data'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    } // End Method
}
