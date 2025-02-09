<?php

namespace App\Http\Controllers\API\Backend\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Transaction_Detail;
use App\Models\Transaction_Head;

class ExpiryStatementController extends Controller
{
    // Show All Expiry Statement
    public function ShowAll(Request $req){
        $type = GetTranType($req->segment(2));

        $data = Transaction_Detail::on('mysql_second')->with('Head')
        ->whereIn('tran_method', ['Purchase', 'Positive'])
        ->where('tran_type', $type)
        ->where('quantity', '>', 0)
        ->where("expiry_date", '<=', [date('Y-m-d')])
        ->orderBy('tran_id', 'asc')
        ->paginate(15);

        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Search Expiry Statement
    public function Search(Request $req){
        $type = GetTranType($req->segment(2));

        if($req->searchOption == 1){
            $heads = Transaction_Head::on('mysql')
            ->with('Groupe', 'Category', 'Manufecturer', 'Form', 'Unit', 'Store')
            ->whereHas('Groupe', function ($q) use ($type) {
                $q->where('tran_groupe_type', $type);
            })
            ->where('tran_head_name', 'like', $req->search.'%')
            ->orderBy('tran_head_name','asc')
            ->pluck('id'); // Base query

            $data = Transaction_Detail::on('mysql_second')
            ->with('Head')
            ->whereIn('tran_head_id', $heads)
            ->where("expiry_date", '<=', $req->startDate)
            ->whereIn('tran_method', ['Purchase', 'Positive'])
            ->where('tran_type', $type)
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $data = Transaction_Detail::on('mysql_second')
            ->with('Head')
            ->where('tran_id', "like", '%'. $req->search .'%')
            ->where("expiry_date", '<=', $req->startDate)
            ->whereIn('tran_method', ['Purchase', 'Positive'])
            ->where('tran_type', $type)
            ->orderBy('tran_id','asc')
            ->paginate(15);
        }
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Print Expiry Report
    public function Print(Request $req){
        $type = GetTranType($req->segment(2));

        if ($req->query()) {
            if($req->searchOption == 1){
                $heads = Transaction_Head::on('mysql')
                ->with('Groupe', 'Category', 'Manufecturer', 'Form', 'Unit', 'Store')
                ->whereHas('Groupe', function ($q) use ($type) {
                    $q->where('tran_groupe_type', $type);
                })
                ->where('tran_head_name', 'like', $req->search.'%')
                ->orderBy('tran_head_name','asc')
                ->pluck('id'); // Base query
    
                $data = Transaction_Detail::on('mysql_second')
                ->with('Head')
                ->whereIn('tran_head_id', $heads)
                ->where("expiry_date", '<=', $req->startDate)
                ->whereIn('tran_method', ['Purchase', 'Positive'])
                ->where('tran_type', $type)
                ->get();
            }
            else if($req->searchOption == 2){
                $data = Transaction_Detail::on('mysql_second')
                ->with('Head')
                ->where('tran_id', "like", '%'. $req->search .'%')
                ->where("expiry_date", '<=', $req->startDate)
                ->whereIn('tran_method', ['Purchase', 'Positive'])
                ->where('tran_type', $type)
                ->orderBy('tran_id','asc')
                ->get();
            }
        }
        else {
            $data = Transaction_Detail::on('mysql_second')->with('Head')
            ->whereIn('tran_method', ['Purchase', 'Positive'])
            ->where('tran_type', $type)
            ->where('quantity', '>', 0)
            ->where("expiry_date", '<=', [date('Y-m-d')])
            ->orderBy('tran_id', 'asc')
            ->get();
        }
        
        $report_name = 'Pharmacy Expiry Report';
        $start_date = $req->startDate ? $req->startDate : date('d/m/Y');
        $end_date = $req->endDate ? $req->endDate : date('d/m/Y');
        $pdf = Pdf::loadView('reports.product_reports.expiry_statement.print', compact('report_name', 'start_date', 'end_date', 'data'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    } // End Method
}
