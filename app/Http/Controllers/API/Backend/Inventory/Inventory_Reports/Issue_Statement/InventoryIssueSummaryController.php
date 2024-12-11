<?php

namespace App\Http\Controllers\API\Backend\Inventory\Inventory_Reports\Issue_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transaction_Main;

class InventoryIssueSummaryController extends Controller
{
    // Show All Inventory Issue Summary Statement
    public function ShowAll(Request $req){
        $inventory = Transaction_Main::on('mysql')->with('User')
        ->where('tran_method','Issue')
        ->where('tran_type', 5)
        ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
        ->orderBy('id','asc')
        ->paginate(15);

        return response()->json([
            'status'=> true,
            'data' => $inventory,
        ], 200);
    } // End Method



    // Search Inventory Issue Summary Statement
    public function Search(Request $req){
        if($req->searchOption == 1){
            $inventory = Transaction_Main::on('mysql')->with('User')
            ->where('tran_id', "like", '%'. $req->search .'%')
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', $req->type)
            ->orderBy('tran_id','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $inventory = Transaction_Main::on('mysql')->with('User')
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
            'data' => $inventory,
        ], 200);
    } // End Method
}
