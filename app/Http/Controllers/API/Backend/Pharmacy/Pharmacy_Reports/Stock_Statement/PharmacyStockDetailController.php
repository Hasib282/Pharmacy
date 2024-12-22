<?php

namespace App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Reports\Stock_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transaction_Detail;

class PharmacyStockDetailController extends Controller
{
    // Show All Pharmacy Stock Details Statement
    public function ShowAll(Request $req){
        $pharmacy = Transaction_Detail::on('mysql_second')->with(['Unit','Head','Head.Manufecturer', "Head.Category", "Head.Form"])
        ->whereIn('tran_method', ['Purchase', 'Positive'])
        ->where('tran_type', 6)
        ->where('quantity', '>', 0)
        ->orderBy('id', 'asc')
        ->paginate(15);

        return response()->json([
            'status'=> true,
            'data' => $pharmacy,
        ], 200);
    } // End Method



    // Search Pharmacy Stock Details Statement
    public function Search(Request $req){
        if($req->searchOption == 1){
            $pharmacy = Transaction_Detail::on('mysql_second')->with(['Unit','Head','Head.Manufecturer', "Head.Category", "Head.Form"])
            ->whereHas('Head', function ($query) use ($req) {
                $query->where('tran_head_name', 'like', '%' . $req->search . '%');
                $query->orderBy('tran_head_name','asc');
            })
            ->whereIn('tran_method', ['Purchase', 'Positive'])
            ->where('tran_type', 6)
            ->where('quantity', '>', 0)
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $pharmacy = Transaction_Detail::on('mysql_second')->with(['Unit','Head','Head.Manufecturer', "Head.Category", "Head.Form"])
            ->whereHas('Head.Category', function ($query) use ($req) {
                $query->where('category_name', 'like', '%' . $req->search . '%');
                $query->orderBy('category_name','asc');
            })
            ->whereIn('tran_method', ['Purchase', 'Positive'])
            ->where('tran_type', 6)
            ->where('quantity', '>', 0)
            ->paginate(15);
        }
        else if($req->searchOption == 3){
            $pharmacy = Transaction_Detail::on('mysql_second')->with(['Unit','Head','Head.Manufecturer', "Head.Category", "Head.Form"])
            ->whereHas('Head.Manufecturer', function ($query) use ($req) {
                $query->where('manufacturer_name', 'like', '%' . $req->search . '%');
                $query->orderBy('manufacturer_name','asc');
            })
            ->whereIn('tran_method', ['Purchase', 'Positive'])
            ->where('tran_type', 6)
            ->where('quantity', '>', 0)
            ->paginate(15);
        }
        else if($req->searchOption == 4){
            $pharmacy = Transaction_Detail::on('mysql_second')->with(['Unit','Head','Head.Manufecturer', "Head.Category", "Head.Form"])
            ->whereHas('Head.Form', function ($query) use ($req) {
                $query->where('form_name', 'like', '%' . $req->search . '%');
                $query->orderBy('form_name','asc');
            })
            ->whereIn('tran_method', ['Purchase', 'Positive'])
            ->where('tran_type', 6)
            ->where('quantity', '>', 0)
            ->paginate(15);
        }
        else if($req->searchOption == 5){
            $pharmacy = Transaction_Detail::on('mysql_second')->with(['Unit','Head','Head.Manufecturer', "Head.Category", "Head.Form"])
            ->where('expiry_date', '<=', $req->search)
            ->whereIn('tran_method', ['Purchase', 'Positive'])
            ->where('tran_type', 6)
            ->where('quantity', '>', 0)
            ->paginate(15);
        }
        
        return response()->json([
            'status' => true,
            'data' => $pharmacy,
        ], 200);
    } // End Method
}
