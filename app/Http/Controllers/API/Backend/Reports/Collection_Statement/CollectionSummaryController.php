<?php

namespace App\Http\Controllers\API\Backend\Reports\Collection_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Transaction_Detail;
use App\Models\Transaction_Head;

class CollectionSummaryController extends Controller
{
     // Show All Collection Details Statement
    public function Show(Request $req){
        $data = Transaction_Detail::on('mysql_second')
        ->with('User','Bank')
        // ->select('User.user_name', DB::raw('SUM(receive) as total_receive'))
        ->join('user__infos', 'transaction__details.tran_user', '=', 'user__infos.id')
        ->select('user__infos.user_name', DB::raw('SUM(transaction__details.receive) as total_receive'))
        ->where('receive','>',0)
        ->whereDate("tran_date", date('Y-m-d'))
        ->groupBy('user__infos.user_name')
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
        ->with('User','Bank')
        // ->select('user.user_name', DB::raw('SUM(receive) as total_receive'))
        // ->where('tran_type', $type)

        ->join('user__infos', 'transaction__details.tran_user', '=', 'user__infos.id')
        ->where('receive','>',0)
        ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
        ->select('user__infos.user_name', DB::raw('SUM(transaction__details.receive) as total_receive'))
        ->groupBy('user__infos.user_name')
        ->orderBy('tran_date', 'asc')
        ->get();
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method
}
