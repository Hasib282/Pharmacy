<?php

namespace App\Http\Controllers\API\Backend\Inventory\Inventory_Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transaction_Detail;

class InventoryProfitabilityStatementController extends Controller
{
    // Show All Inventory Profitability Statement
    public function ShowAll(Request $req){
        $inventory = Transaction_Detail::With('User','Head')
        ->where('tran_method', 'Issue')
        ->where('tran_type', 5)
        ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
        ->orderBy('id', 'asc')
        ->paginate(15);

        return response()->json([
            'status'=> true,
            'data' => $inventory,
        ], 200);
    } // End Method



    // Search Inventory Profitability Statement
    public function Search(Request $req){
        if($req->searchOption == 1){
            $inventory = Transaction_Detail::With('User','Head')
            ->where('tran_id', "like", '%'. $req->search .'%')
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', $req->type)
            ->orderBy('tran_id','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $inventory = Transaction_Detail::With('User','Head')
            ->whereHas('Head', function ($query) use ($req) {
                $query->where('tran_head_name', 'like', '%' . $req->search . '%');
                $query->orderBy('tran_head_name','asc');
            })
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', $req->type)
            ->paginate(15);
        }
        else if($req->searchOption == 3){
            $inventory = Transaction_Detail::With('User','Head')
            ->whereHas('User', function ($query) use ($req) {
                $query->where('user_name', 'like', '%' . $req->search . '%');
                $query->orderBy('user_name','asc');
            })
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', $req->type)
            ->paginate(15);
        }
        else if($req->searchOption == 4){
            $inventory = Transaction_Detail::With('User','Head')
            ->where('batch_id', "like", '%'. $req->search .'%')
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', $req->type)
            ->orderBy('tran_id','asc')
            ->paginate(15);
        }
        
        
        
        return response()->json([
            'status' => true,
            'data' => $inventory,
        ], 200);
    } // End Method
}
