<?php

namespace App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Reports\Purchase_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transaction_Detail;

class PharmacyPurchaseDetailController extends Controller
{
    // Show All Pharmacy Purchase Details Statement
    public function ShowAll(Request $req){
        $pharmacy = Transaction_Detail::on('mysql')->with('User','Head')
        ->where('tran_method', 'Purchase')
        ->where('tran_type', 6)
        ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
        ->orderBy('id', 'asc')
        ->paginate(15);

        return response()->json([
            'status'=> true,
            'data' => $pharmacy,
        ], 200);
    } // End Method



    // Search Pharmacy Purchase Details Statement
    public function Search(Request $req){
        if($req->searchOption == 1){
            $pharmacy = Transaction_Detail::on('mysql')->with('User','Head')
            ->where('tran_id', "like", '%'. $req->search .'%')
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', $req->type)
            ->orderBy('tran_id','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $pharmacy = Transaction_Detail::on('mysql')->with('User','Head')
            ->whereHas('User', function ($query) use ($req) {
                $query->where('user_name', 'like', '%'.$req->search.'%');
                $query->orderBy('user_name','asc');
            })
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', $req->type)
            ->paginate(15);
        }
        else if($req->searchOption == 3){
            $pharmacy = Transaction_Detail::on('mysql')->with('User','Head')
            ->whereHas('Head', function ($query) use ($req) {
                $query->where('tran_head_name', 'like', '%'.$req->search.'%');
                $query->orderBy('tran_head_name','asc');
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
