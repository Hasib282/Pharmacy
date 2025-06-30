<?php

namespace App\Http\Controllers\API\Backend\Reports\Collection_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Transaction_Main;
use App\Models\Transaction_Head;

class CollectionSummaryController extends Controller
{
     // Show All Collection Details Statement
    public function Show(Request $req){
        // $bankDb = config('database.connections.mysql.database');

        // $sql = "
        //     SELECT 
        //         CASE 
        //             WHEN tm.tran_bank IS NOT NULL THEN bank.name 
        //             ELSE user.user_name 
        //         END AS name,
        //         SUM(tm.receive) AS total_receive
        //     FROM transaction__mains tm
        //     LEFT JOIN user__infos user ON user.id = tm.tran_user
        //     LEFT JOIN `$bankDb`.banks bank ON bank.id = tm.tran_bank
        //     WHERE DATE(tm.tran_date) = ?
        //     AND tm.receive > 0
        //     GROUP BY name
        //     ORDER BY name ASC
        // ";

        // $data = DB::connection('mysql_second')->select($sql, [now()->toDateString()]);

        $data = Transaction_Main::on('mysql_second')
        ->with('User','Bank')
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

        $data = Transaction_Main::on('mysql_second')
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
