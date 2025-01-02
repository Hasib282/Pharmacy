<?php

namespace App\Http\Controllers\API\Backend\Inventory\Inventory_Reports\Stock_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transaction_Head;

class InventoryStockSummaryController extends Controller
{
    // Show All Inventory Stock Summary Statement
    public function ShowAll(Request $req){
        $inventory = Transaction_Head::on('mysql')->with("Unit","Form","Manufecturer","Category",'Groupe')
        ->whereHas('Groupe', function ($query){
            $query->where('tran_groupe_type', 5);
        })
        ->orderBy('tran_head_name','asc')
        ->paginate(15);

        return response()->json([
            'status'=> true,
            'data' => $inventory,
        ], 200);
    } // End Method



    // Search Inventory Stock Summary Statement
    public function Search(Request $req){
        if($req->searchOption == 1){
            $inventory = Transaction_Head::on('mysql')->with("Unit","Form","Manufecturer","Category",'Groupe')
            ->whereHas('Groupe', function ($query){
                $query->where('tran_groupe_type', 5);
            })
            ->where('tran_head_name', 'like', $req->search.'%')
            ->orderBy('tran_head_name','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $inventory = Transaction_Head::on('mysql')->with("Unit","Form","Manufecturer","Category",'Groupe')
            ->whereHas('Groupe', function ($query) use ($req){
                $query->where('tran_groupe_type', 5);
                $query->where('tran_groupe_name', 'like', $req->search . '%');
                $query->orderBy('tran_groupe_name','asc');
            })
            ->paginate(15);
        }
        else if($req->searchOption == 3){
            $inventory = Transaction_Head::on('mysql')->with("Unit","Form","Manufecturer","Category",'Groupe')
            ->whereHas('Groupe', function ($query){
                $query->where('tran_groupe_type', 5);
            })
            ->whereHas('Category', function ($query) use ($req) {
                $query->where('category_name', 'like', $req->search . '%');
                $query->orderBy('category_name','asc');
            })
            ->paginate(15);
        }
        else if($req->searchOption == 4){
            $inventory = Transaction_Head::on('mysql')->with("Unit","Form","Manufecturer","Category",'Groupe')
            ->whereHas('Groupe', function ($query){
                $query->where('tran_groupe_type', 5);
            })
            ->whereHas('Manufecturer', function ($query) use ($req) {
                $query->where('manufacturer_name', 'like', $req->search . '%');
                $query->orderBy('manufacturer_name','asc');
            })
            ->paginate(15);
        }
        else if($req->searchOption == 5){
            $inventory = Transaction_Head::on('mysql')->with("Unit","Form","Manufecturer","Category",'Groupe')
            ->whereHas('Groupe', function ($query){
                $query->where('tran_groupe_type', 5);
            })
            ->whereHas('Form', function ($query) use ($req) {
                $query->where('form_name', 'like', $req->search . '%');
                $query->orderBy('form_name','asc');
            })
            ->paginate(15);
        }
        
        return response()->json([
            'status' => true,
            'data' => $inventory,
        ], 200);
    } // End Method
}
