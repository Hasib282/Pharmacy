<?php

namespace App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Reports\Return_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transaction_Main;

class PharmacySupplierReturnSummaryController extends Controller
{
    // Show All Pharmacy Supplier Return Summary Statement
    public function ShowAll(Request $req){
        $pharmacy = Transaction_Main::on('mysql_second')->with('User')
        ->where('tran_method', 'Supplier Return')
        ->where('tran_type', 6)
        ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
        ->orderBy('id', 'asc')
        ->paginate(15);

        return response()->json([
            'status'=> true,
            'data' => $pharmacy,
        ], 200);
    } // End Method



    // Search Pharmacy Supplier Return Summary Statement
    public function Search(Request $req){
        if($req->searchOption == 1){
            $pharmacy = Transaction_Main::on('mysql_second')->with('User')
            ->where('tran_id', "like", '%'. $req->search .'%')
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', $req->type)
            ->orderBy('tran_id','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $pharmacy = Transaction_Main::on('mysql_second')->with('User')
            ->whereHas('User', function ($query) use ($req) {
                $query->where('user_name', 'like', '%'.$req->search.'%');
                $query->orderBy('user_name','asc');
            })
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', $req->type)
            ->paginate(15);
        }
        
        return response()->json([
            'status' => true,
            'data' => $pharmacy,
        ], 200);
    } // End Method
}
