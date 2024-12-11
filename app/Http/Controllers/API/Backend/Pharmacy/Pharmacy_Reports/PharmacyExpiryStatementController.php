<?php

namespace App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transaction_Detail;

class PharmacyExpiryStatementController extends Controller
{
    // Show All Pharmacy Expiry Statement
    public function ShowAll(Request $req){
        $pharmacy = Transaction_Detail::on('mysql')->with('Head')
        ->whereIn('tran_method', ['Purchase', 'Positive'])
        ->where('tran_type', 6)
        ->where('quantity', '>', 0)
        ->where("expiry_date", '<=', [date('Y-m-d')])
        ->orderBy('tran_id', 'asc')
        ->paginate(15);

        return response()->json([
            'status'=> true,
            'data' => $pharmacy,
        ], 200);
    } // End Method



    // Search Pharmacy Expiry Statement
    public function Search(Request $req){
        if($req->searchOption == 1){
            $pharmacy = Transaction_Detail::on('mysql')->with('Head')
            ->whereHas('Head', function ($query) use ($req) {
                $query->where('tran_head_name', 'like', '%' . $req->search . '%');
                $query->orderBy('tran_head_name','asc');
            })
            ->whereRaw("expiry_date BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->whereIn('tran_method', ['Purchase', 'Positive'])
            ->where('tran_type', 6)
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $pharmacy = Transaction_Detail::on('mysql')->where('tran_id', "like", '%'. $req->search .'%')
            ->whereRaw("expiry_date BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->whereIn('tran_method', ['Purchase', 'Positive'])
            ->where('tran_type', 6)
            ->orderBy('tran_id','asc')
            ->paginate(15);
        }
        
        return response()->json([
            'status' => true,
            'data' => $pharmacy,
        ], 200);
    } // End Method
}
