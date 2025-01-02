<?php

namespace App\Http\Controllers\API\Backend\Reports\Balance_Sheet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transaction_Main;

class BalanceSheetDetailsController extends Controller
{
    // Show All Salary Details Report
    public function ShowAll(Request $req){
        $receive = Transaction_Main::on('mysql_second')->whereRaw("DATE(tran_date) < ?", [date('Y-m-d')])->sum('receive');
        $payment = Transaction_Main::on('mysql_second')->whereRaw("DATE(tran_date) < ?", [date('Y-m-d')])->sum('payment');
        $opening = $receive - $payment;

        $transactions = Transaction_Main::on('mysql')->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])->orderBy('tran_date','asc')->paginate(15);
        
        return response()->json([
            'status'=> true,
            'data' => $transactions,
            'opening' => $opening,
        ], 200);
    } // End Method



    // // Search Salary Details Report
    // public function Search(Request $req){
    //     $currentYear = $req->year;
    //     $currentMonth = $req->month;
    //     $salary = Transaction_Detail::with('User','Head')
    //     ->whereHas('User', function ($query) use ($req) {
    //         $query->where('user_name', 'like', '%'.$req->search.'%');
    //         $query->orWhere('user_id', 'like', '%'.$req->search.'%');
    //     })
    //     ->where('tran_type', 3)
    //     ->where('tran_method','Payment')
    //     ->whereYear('tran_date', $currentYear)
    //     ->whereMonth('tran_date', $currentMonth)
    //     ->orderBy('id','asc')
    //     ->paginate(15);
        
    //     return response()->json([
    //         'status' => true,
    //         'data' => $salary,
    //     ], 200);
    // } // End Method
}
