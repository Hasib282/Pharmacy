<?php

namespace App\Http\Controllers\API\Backend\Inventory\Inventory_Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Transaction_Detail;
use App\Models\Transaction_Head;

class InventoryExpiryStatementController extends Controller
{
    // Show All Inventory Expiry Statement
    public function ShowAll(Request $req){
        $inventory = Transaction_Detail::on('mysql_second')->with('Head')
        ->whereIn('tran_method', ['Purchase', 'Positive'])
        ->where('tran_type', 5)
        ->where('quantity', '>', 0)
        ->where("expiry_date", '<=', [date('Y-m-d')])
        ->orderBy('tran_id', 'asc')
        ->paginate(15);

        return response()->json([
            'status'=> true,
            'data' => $inventory,
        ], 200);
    } // End Method



    // Search Inventory Expiry Statement
    public function Search(Request $req){
        if($req->searchOption == 1){
            $heads = Transaction_Head::on('mysql')
            ->with('Groupe', 'Category', 'Manufecturer', 'Form', 'Unit', 'Store')
            ->whereHas('Groupe', function ($q){
                $q->where('tran_groupe_type', 5);
            })
            ->where('tran_head_name', 'like', $req->search.'%')
            ->orderBy('tran_head_name','asc')
            ->pluck('id'); // Base query

            $inventory = Transaction_Detail::on('mysql_second')
            ->with('Head')
            ->whereIn('tran_head_id', $heads)
            ->whereRaw("expiry_date BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->whereIn('tran_method', ['Purchase', 'Positive'])
            ->where('tran_type', 5)
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $inventory = Transaction_Detail::on('mysql_second')
            ->with('Head')
            ->where('tran_id', "like", '%'. $req->search .'%')
            ->whereRaw("expiry_date BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->whereIn('tran_method', ['Purchase', 'Positive'])
            ->where('tran_type', 5)
            ->orderBy('tran_id','asc')
            ->paginate(15);
        }
        
        return response()->json([
            'status' => true,
            'data' => $inventory,
        ], 200);
    } // End Method



    // Print Inventory Expiry Report
    public function Print(Request $req){
        if ($req->query()) {
            if($req->searchOption == 1){
                $heads = Transaction_Head::on('mysql')
                ->with('Groupe', 'Category', 'Manufecturer', 'Form', 'Unit', 'Store')
                ->whereHas('Groupe', function ($q){
                    $q->where('tran_groupe_type', 5);
                })
                ->where('tran_head_name', 'like', $req->search.'%')
                ->orderBy('tran_head_name','asc')
                ->pluck('id'); // Base query
    
                $data = Transaction_Detail::on('mysql_second')
                ->with('Head')
                ->whereIn('tran_head_id', $heads)
                ->whereRaw("expiry_date BETWEEN ? AND ?", [$req->startDate, $req->endDate])
                ->whereIn('tran_method', ['Purchase', 'Positive'])
                ->where('tran_type', 5)
                ->get();
            }
            else if($req->searchOption == 2){
                $data = Transaction_Detail::on('mysql_second')
                ->with('Head')
                ->where('tran_id', "like", '%'. $req->search .'%')
                ->whereRaw("expiry_date BETWEEN ? AND ?", [$req->startDate, $req->endDate])
                ->whereIn('tran_method', ['Purchase', 'Positive'])
                ->where('tran_type', 5)
                ->orderBy('tran_id','asc')
                ->get();
            }
        }
        else {
            $data = Transaction_Detail::on('mysql_second')->with('Head')
            ->whereIn('tran_method', ['Purchase', 'Positive'])
            ->where('tran_type', 5)
            ->where('quantity', '>', 0)
            ->where("expiry_date", '<=', [date('Y-m-d')])
            ->orderBy('tran_id', 'asc')
            ->get();
        }
        
        $report_name = 'Inventory Expiry Report';
        $start_date = $req->startDate ? $req->startDate : date('d/m/Y');
        $end_date = $req->endDate ? $req->endDate : date('d/m/Y');
        $pdf = Pdf::loadView('reports.product_reports.expiry_statement.print', compact('report_name', 'start_date', 'end_date', 'data'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    } // End Method
}
