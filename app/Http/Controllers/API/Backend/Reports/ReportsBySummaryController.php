<?php

namespace App\Http\Controllers\API\Backend\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Transaction_Head;
use App\Models\Transaction_Detail;
use App\Models\Transaction_Groupe;


class ReportsBySummaryController extends Controller
{
    // Show All Salary Details Report
    public function ShowAll(Request $req){
        $groupes = Transaction_Groupe::orderBy('tran_groupe_name')->get();
        $head_groupe = [];
        foreach ($groupes as $key => $groupe) {
            $head_groupe[$key] = Transaction_Head::where('groupe_id',$groupe->id)->orderBy('tran_head_name')->get();
        }
    
        $transactions = collect(); // Initialize an empty collection to store transactions
    
        foreach ($head_groupe as $heads) {
            foreach ($heads as $head) {
                $transaction = Transaction_Detail::with('Groupe','Head')
                ->select(
                    'tran_type',
                    'tran_groupe_id',
                    'tran_head_id',
                    DB::raw('SUM(quantity) as total_quantity'),
                    DB::raw('SUM(tot_amount) as total_tot_amount'),
                )
                ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
                ->where('tran_head_id', $head->id)
                ->groupBy('tran_type','tran_groupe_id','tran_head_id')
                ->orderBy('tran_id','asc')
                ->get();
                
                $transactions = $transactions->merge($transaction); // Merge the current transactions with the collection
            }
        }
        
        return response()->json([
            'status'=> true,
            'data' => $transactions,
        ], 200);
    } // End Method



    // Search Salary Details Report
    public function Search(Request $req){
        $groupes = Transaction_Groupe::orderBy('tran_groupe_name')->get();
        $head_groupe = [];
        foreach ($groupes as $key => $groupe) {
            $head_groupe[$key] = Transaction_Head::where('groupe_id',$groupe->id)->orderBy('tran_head_name')->get();
        }
    
        $transactions = collect(); // Initialize an empty collection to store transactions
    
        foreach ($head_groupe as $heads) {
            foreach ($heads as $head) {
                $transaction = Transaction_Detail::with('Groupe','Head')
                ->select(
                    'tran_type',
                    'tran_groupe_id',
                    'tran_head_id',
                    DB::raw('SUM(quantity) as total_quantity'),
                    DB::raw('SUM(tot_amount) as total_tot_amount'),
                )
                ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
                ->where('tran_head_id', $head->id)
                ->groupBy('tran_type','tran_groupe_id','tran_head_id')
                ->orderBy('tran_id','asc')
                ->get();
                
                $transactions = $transactions->merge($transaction); // Merge the current transactions with the collection
            }
        }
        
        return response()->json([
            'status' => true,
            'data' => $transactions,
        ], 200);
    } // End Method
}
