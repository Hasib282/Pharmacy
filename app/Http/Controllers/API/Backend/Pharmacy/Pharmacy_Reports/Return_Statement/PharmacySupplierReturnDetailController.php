<?php

namespace App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Reports\Return_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transaction_Detail;

class PharmacySupplierReturnDetailController extends Controller
{
    // Show All Pharmacy Supplier Return Details Statement
    public function ShowAll(Request $req){
        $pharmacy = Transaction_Detail::on('mysql_second')->with('User','Head')
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



    // Search Pharmacy Supplier Return Details Statement
    public function Search(Request $req){
        if($req->searchOption == 1){
            $pharmacy = Transaction_Detail::on('mysql_second')->with('User','Head')
            ->where('tran_id', "like", '%'. $req->search .'%')
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', $req->type)
            ->orderBy('tran_id','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $pharmacy = Transaction_Detail::on('mysql_second')->with('User','Head')
            ->whereHas('User', function ($query) use ($req) {
                $query->where('user_name', 'like', $req->search.'%');
                $query->orderBy('user_name','asc');
            })
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', $req->type)
            ->paginate(15);
        }
        else if($req->searchOption == 3){
            $heads = Transaction_Head::on('mysql')
            ->with('Groupe')
            ->whereHas('Groupe', function ($q){
                $q->where('tran_groupe_type', 6);
            })
            ->where('tran_head_name', 'like', $req->search.'%')
            ->orderBy('tran_head_name','asc')
            ->pluck('id'); // Base query

            $pharmacy = Transaction_Detail::on('mysql_second')->with('User','Head')
            ->whereIn('tran_head_id', $heads)
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
