<?php

namespace App\Http\Controllers\API\Backend\Reports\Collection_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transaction_Detail;

class CollectionDetailsController extends Controller
{
    // Show All Collection Details Statement
    public function Show(Request $req){
        $data = Transaction_Detail::on('mysql_second')
        ->with('User','Head','Groupe','Bank','Type')
        ->where('receive','>',0)
        ->whereDate("tran_date", date('Y-m-d'))
        ->orderBy('tran_date', 'asc')
        ->get();

        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method


    // Search Collection Details Statement
    public function Search(Request $req){
        $data = Transaction_Detail::on('mysql_second')
        ->with('User','Head','Groupe','Bank','Type')
        // ->where('tran_type',$req->status)
        ->where('receive','>',0)
        ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
        ->orderBy('tran_date','asc')
        ->get();
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method
}
