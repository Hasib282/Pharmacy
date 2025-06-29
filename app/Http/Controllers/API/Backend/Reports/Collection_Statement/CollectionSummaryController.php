<?php

namespace App\Http\Controllers\API\Backend\Reports\Collection_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transaction_Detail;
use App\Models\Transaction_Head;

class CollectionSummaryController extends Controller
{
     // Show All Collection Details Statement
    public function Show(Request $req){
        $type = GetTranType($req->segment(2));

        $data = Transaction_Detail::on('mysql_second')
        ->with('User','Head')
        ->where('tran_method', 'Issue')
        ->where('tran_type', $type)
        ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
        ->orderBy('id', 'asc')
        ->get();

        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method


        // Search Collection Details Statement
    public function Search(Request $req){
        $type = GetTranType($req->segment(2));

        $data = Transaction_Detail::on('mysql_second')
        ->with('User','Head')
        ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
        ->where('tran_method',$req->method)
        ->where('tran_type', $type)
        ->orderBy('tran_id','asc')
        ->get();
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method
}
