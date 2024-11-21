<?php

namespace App\Http\Controllers\API\Backend\HR_Setup\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transaction_Main;

class SalarySummaryController extends Controller
{
    // Show All Salary Summary Report
    public function ShowAll(Request $req){
        $salary = Transaction_Main::with('User')
        ->where('tran_method','Payment')
        ->where('tran_type', 3)
        ->orderBy('id','asc')
        ->paginate(15);

        return response()->json([
            'status'=> true,
            'data' => $salary,
        ], 200);
    } // End Method



    // Search Salary Summary Report
    public function Search(Request $req){
        $currentYear = $req->year;
        $currentMonth = $req->month;
        $salary = Transaction_Main::with('User')
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
}
