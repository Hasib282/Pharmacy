<?php

namespace App\Http\Controllers\API\Backend\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Transaction_Detail;
use App\Models\Transaction_Head;

class ProfitabilityStatementController extends Controller
{
    // Show All Profitability Statement
    public function Show(Request $req){
        $type = GetTranType($req->segment(2));

        $data = Transaction_Detail::on('mysql_second')->With('User','Head')
        ->where('tran_method', 'Issue')
        ->where('tran_type', $type)
        ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
        ->orderBy('id', 'asc')
        ->paginate(15);

        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Search Profitability Statement
    public function Search(Request $req){
        $type = GetTranType($req->segment(2));

        if($req->searchOption == 1){
            $data = Transaction_Detail::on('mysql_second')->With('User','Head')
            ->where('tran_id', "like", '%'. $req->search .'%')
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', $req->type)
            ->orderBy('tran_id','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $heads = Transaction_Head::on('mysql')
            ->with('Groupe', 'Category', 'Manufecturer', 'Form', 'Unit', 'Store')
            ->whereHas('Groupe', function ($q) use ($type){
                $q->where('tran_groupe_type', $type);
            })
            ->where('tran_head_name', 'like', $req->search.'%')
            ->orderBy('tran_head_name','asc')
            ->pluck('id'); // Base query

            $data = Transaction_Detail::on('mysql_second')->With('User','Head')
            // ->whereHas('Head', function ($query) use ($req) {
            //     $query->where('tran_head_name', 'like', '%' . $req->search . '%');
            //     $query->orderBy('tran_head_name','asc');
            // })
            ->whereIn('tran_head_id', $heads)
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', $req->type)
            ->paginate(15);
        }
        else if($req->searchOption == 3){
            $data = Transaction_Detail::on('mysql_second')->With('User','Head')
            ->whereHas('User', function ($query) use ($req) {
                $query->where('user_name', 'like', '%' . $req->search . '%');
                $query->orderBy('user_name','asc');
            })
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', $req->type)
            ->paginate(15);
        }
        else if($req->searchOption == 4){
            $data = Transaction_Detail::on('mysql_second')->With('User','Head')
            ->where('batch_id', "like", '%'. $req->search .'%')
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', $req->type)
            ->orderBy('tran_id','asc')
            ->paginate(15);
        }
        
        
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Print Profitability Report
    public function Print(Request $req){
        $type = GetTranType($req->segment(2));

        if ($req->query()) {
            if($req->searchOption == 1){
                $data = Transaction_Detail::on('mysql_second')->With('User','Head')
                ->where('tran_id', "like", '%'. $req->search .'%')
                ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
                ->where('tran_method',$req->method)
                ->where('tran_type', $req->type)
                ->orderBy('tran_id','asc')
                ->get();
            }
            else if($req->searchOption == 2){
                $heads = Transaction_Head::on('mysql')
                ->with('Groupe', 'Category', 'Manufecturer', 'Form', 'Unit', 'Store')
                ->whereHas('Groupe', function ($q) use ($type){
                    $q->where('tran_groupe_type', $type);
                })
                ->where('tran_head_name', 'like', $req->search.'%')
                ->orderBy('tran_head_name','asc')
                ->pluck('id'); // Base query
    
                $data = Transaction_Detail::on('mysql_second')->With('User','Head')
                // ->whereHas('Head', function ($query) use ($req) {
                //     $query->where('tran_head_name', 'like', '%' . $req->search . '%');
                //     $query->orderBy('tran_head_name','asc');
                // })
                ->whereIn('tran_head_id', $heads)
                ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
                ->where('tran_method',$req->method)
                ->where('tran_type', $req->type)
                ->get();
            }
            else if($req->searchOption == 3){
                $data = Transaction_Detail::on('mysql_second')->With('User','Head')
                ->whereHas('User', function ($query) use ($req) {
                    $query->where('user_name', 'like', '%' . $req->search . '%');
                    $query->orderBy('user_name','asc');
                })
                ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
                ->where('tran_method',$req->method)
                ->where('tran_type', $req->type)
                ->get();
            }
            else if($req->searchOption == 4){
                $data = Transaction_Detail::on('mysql_second')->With('User','Head')
                ->where('batch_id', "like", '%'. $req->search .'%')
                ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
                ->where('tran_method',$req->method)
                ->where('tran_type', $req->type)
                ->orderBy('tran_id','asc')
                ->get();
            }
        }
        else {
            $data = Transaction_Detail::on('mysql_second')->With('User','Head')
            ->where('tran_method', 'Issue')
            ->where('tran_type', $type)
            ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
            ->orderBy('id', 'asc')
            ->get();
        }
        
        $report_name = 'Profitability Report';
        $start_date = $req->startDate ? $req->startDate : date('d/m/Y');
        $end_date = $req->endDate ? $req->endDate : date('d/m/Y');
        $pdf = Pdf::loadView('reports.product_reports.profitability_statement.print', compact('report_name', 'start_date', 'end_date', 'data'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    } // End Method
}
