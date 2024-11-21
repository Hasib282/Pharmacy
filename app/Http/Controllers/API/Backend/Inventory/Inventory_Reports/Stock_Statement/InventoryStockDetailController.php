<?php

namespace App\Http\Controllers\API\Backend\Inventory\Inventory_Reports\Stock_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transaction_Detail;

class InventoryStockDetailController extends Controller
{
    // Show All Inventory Stock Details Statement
    public function ShowAll(Request $req){
        $inventory = Transaction_Detail::with(['Unit','Head','Head.Manufecturer', "Head.Category", "Head.Form"])
        ->whereIn('tran_method', ['Purchase', 'Positive'])
        ->where('tran_type', 5)
        ->where('quantity', '>', 0)
        ->orderBy('id', 'asc')
        ->paginate(15);

        return response()->json([
            'status'=> true,
            'data' => $inventory,
        ], 200);
    } // End Method



    // Search Inventory Stock Details Statement
    public function Search(Request $req){
        if($req->searchOption == 1){
            $inventory = Transaction_Detail::with(['Unit','Head','Head.Manufecturer', "Head.Category", "Head.Form"])
            ->whereHas('Head', function ($query) use ($req) {
                $query->where('tran_head_name', 'like', '%' . $req->search . '%');
                $query->orderBy('tran_head_name','asc');
            })
            ->whereIn('tran_method', ['Purchase', 'Positive'])
            ->where('tran_type', 5)
            ->where('quantity', '>', 0)
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $inventory = Transaction_Detail::with(['Unit','Head','Head.Manufecturer', "Head.Category", "Head.Form"])
            ->whereHas('Head.Category', function ($query) use ($req) {
                $query->where('category_name', 'like', '%' . $req->search . '%');
                $query->orderBy('category_name','asc');
            })
            ->whereIn('tran_method', ['Purchase', 'Positive'])
            ->where('tran_type', 5)
            ->where('quantity', '>', 0)
            ->paginate(15);
        }
        else if($req->searchOption == 3){
            $inventory = Transaction_Detail::with(['Unit','Head','Head.Manufecturer', "Head.Category", "Head.Form"])
            ->whereHas('Head.Manufecturer', function ($query) use ($req) {
                $query->where('manufacturer_name', 'like', '%' . $req->search . '%');
                $query->orderBy('manufacturer_name','asc');
            })
            ->whereIn('tran_method', ['Purchase', 'Positive'])
            ->where('tran_type', 5)
            ->where('quantity', '>', 0)
            ->paginate(15);
        }
        else if($req->searchOption == 4){
            $inventory = Transaction_Detail::with(['Unit','Head','Head.Manufecturer', "Head.Category", "Head.Form"])
            ->whereHas('Head.Form', function ($query) use ($req) {
                $query->where('form_name', 'like', '%' . $req->search . '%');
                $query->orderBy('form_name','asc');
            })
            ->whereIn('tran_method', ['Purchase', 'Positive'])
            ->where('tran_type', 5)
            ->where('quantity', '>', 0)
            ->paginate(15);
        }
        else if($req->searchOption == 5){
            $inventory = Transaction_Detail::with(['Unit','Head','Head.Manufecturer', "Head.Category", "Head.Form"])
            ->where('expiry_date', '<=', $req->search)
            ->whereIn('tran_method', ['Purchase', 'Positive'])
            ->where('tran_type', 5)
            ->where('quantity', '>', 0)
            ->paginate(15);
        }
        
        return response()->json([
            'status' => true,
            'data' => $inventory,
        ], 200);
    } // End Method
}
