<?php

namespace App\Http\Controllers\API\Backend\Inventory\Inventory_Reports\Stock_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Transaction_Detail;
use App\Models\Transaction_Head;

class InventoryStockDetailController extends Controller
{
    // Show All Inventory Stock Details Statement
    public function ShowAll(Request $req){
        $inventory = Transaction_Detail::on('mysql_second')->with(['Unit','Head','Head.Manufecturer', "Head.Category", "Head.Form"])
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
        $query = Transaction_Head::on('mysql')
        ->with('Groupe', 'Category', 'Manufecturer', 'Form', 'Unit', 'Store')
        ->whereHas('Groupe', function ($q){
            $q->where('tran_groupe_type', 5);
        }); // Base query

        if($req->searchOption == 1){
            $query->where('tran_head_name', 'like', $req->search.'%')
            ->orderBy('tran_head_name','asc');
        }
        else if($req->searchOption == 2){
            $query->whereHas('Category', function ($q) use ($req) {
                $q->where('category_name', 'like', $req->search . '%');
                $q->orderBy('category_name','asc');
            });
        }
        else if($req->searchOption == 3){
            $query->whereHas('Manufecturer', function ($q) use ($req) {
                $q->where('manufacturer_name', 'like', $req->search . '%');
                $q->orderBy('manufacturer_name','asc');
            });
        }
        else if($req->searchOption == 4){
            $query->whereHas('Form', function ($q) use ($req) {
                $q->where('form_name', 'like', $req->search . '%');
                $q->orderBy('form_name','asc');
            });
        }
        else if($req->searchOption == 6){
            $query->whereHas('Store', function ($q) use ($req) {
                $q->where('store_name', 'like', $req->search . '%');
                $q->orderBy('store_name','asc');
            });
        }

        $heads = $query->pluck('id');

        if($req->searchOption == 1){
            $inventory = Transaction_Detail::on('mysql_second')->with(['Unit','Head','Head.Manufecturer', "Head.Category", "Head.Form"])
            ->whereIn('tran_head_id', $heads)
            ->whereIn('tran_method', ['Purchase', 'Positive'])
            ->where('tran_type', 5)
            ->where('quantity', '>', 0)
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $inventory = Transaction_Detail::on('mysql_second')->with(['Unit','Head','Head.Manufecturer', "Head.Category", "Head.Form"])
            ->whereIn('tran_head_id', $heads)
            ->whereIn('tran_method', ['Purchase', 'Positive'])
            ->where('tran_type', 5)
            ->where('quantity', '>', 0)
            ->paginate(15);
        }
        else if($req->searchOption == 3){
            $inventory = Transaction_Detail::on('mysql_second')->with(['Unit','Head','Head.Manufecturer', "Head.Category", "Head.Form"])
            ->whereIn('tran_head_id', $heads)
            ->whereIn('tran_method', ['Purchase', 'Positive'])
            ->where('tran_type', 5)
            ->where('quantity', '>', 0)
            ->paginate(15);
        }
        else if($req->searchOption == 4){
            $inventory = Transaction_Detail::on('mysql_second')->with(['Unit','Head','Head.Manufecturer', "Head.Category", "Head.Form"])
            ->whereIn('tran_head_id', $heads)
            ->whereIn('tran_method', ['Purchase', 'Positive'])
            ->where('tran_type', 5)
            ->where('quantity', '>', 0)
            ->paginate(15);
        }
        else if($req->searchOption == 5){
            $inventory = Transaction_Detail::on('mysql_second')->with(['Unit','Head','Head.Manufecturer', "Head.Category", "Head.Form"])
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



    // Print Inventory Stock Details Report
    public function Print(Request $req){
        if ($req->query()) {
            $query = Transaction_Head::on('mysql')
            ->with('Groupe', 'Category', 'Manufecturer', 'Form', 'Unit', 'Store')
            ->whereHas('Groupe', function ($q){
                $q->where('tran_groupe_type', 5);
            }); // Base query

            if($req->searchOption == 1){
                $query->where('tran_head_name', 'like', $req->search.'%')
                ->orderBy('tran_head_name','asc');
            }
            else if($req->searchOption == 2){
                $query->whereHas('Category', function ($q) use ($req) {
                    $q->where('category_name', 'like', $req->search . '%');
                    $q->orderBy('category_name','asc');
                });
            }
            else if($req->searchOption == 3){
                $query->whereHas('Manufecturer', function ($q) use ($req) {
                    $q->where('manufacturer_name', 'like', $req->search . '%');
                    $q->orderBy('manufacturer_name','asc');
                });
            }
            else if($req->searchOption == 4){
                $query->whereHas('Form', function ($q) use ($req) {
                    $q->where('form_name', 'like', $req->search . '%');
                    $q->orderBy('form_name','asc');
                });
            }
            else if($req->searchOption == 6){
                $query->whereHas('Store', function ($q) use ($req) {
                    $q->where('store_name', 'like', $req->search . '%');
                    $q->orderBy('store_name','asc');
                });
            }

            $heads = $query->pluck('id');

            if($req->searchOption == 1){
                $data = Transaction_Detail::on('mysql_second')->with(['Unit','Head','Head.Manufecturer', "Head.Category", "Head.Form"])
                ->whereIn('tran_head_id', $heads)
                ->whereIn('tran_method', ['Purchase', 'Positive'])
                ->where('tran_type', 5)
                ->where('quantity', '>', 0)
                ->get();
            }
            else if($req->searchOption == 2){
                $data = Transaction_Detail::on('mysql_second')->with(['Unit','Head','Head.Manufecturer', "Head.Category", "Head.Form"])
                ->whereIn('tran_head_id', $heads)
                ->whereIn('tran_method', ['Purchase', 'Positive'])
                ->where('tran_type', 5)
                ->where('quantity', '>', 0)
                ->get();
            }
            else if($req->searchOption == 3){
                $data = Transaction_Detail::on('mysql_second')->with(['Unit','Head','Head.Manufecturer', "Head.Category", "Head.Form"])
                ->whereIn('tran_head_id', $heads)
                ->whereIn('tran_method', ['Purchase', 'Positive'])
                ->where('tran_type', 5)
                ->where('quantity', '>', 0)
                ->get();
            }
            else if($req->searchOption == 4){
                $data = Transaction_Detail::on('mysql_second')->with(['Unit','Head','Head.Manufecturer', "Head.Category", "Head.Form"])
                ->whereIn('tran_head_id', $heads)
                ->whereIn('tran_method', ['Purchase', 'Positive'])
                ->where('tran_type', 5)
                ->where('quantity', '>', 0)
                ->get();
            }
            else if($req->searchOption == 5){
                $data = Transaction_Detail::on('mysql_second')->with(['Unit','Head','Head.Manufecturer', "Head.Category", "Head.Form"])
                ->where('expiry_date', '<=', $req->search)
                ->whereIn('tran_method', ['Purchase', 'Positive'])
                ->where('tran_type', 5)
                ->where('quantity', '>', 0)
                ->get();
            }
        }
        else {
            $data = Transaction_Detail::on('mysql_second')->with(['Unit','Head','Head.Manufecturer', "Head.Category", "Head.Form"])
            ->whereIn('tran_method', ['Purchase', 'Positive'])
            ->where('tran_type', 5)
            ->where('quantity', '>', 0)
            ->orderBy('id', 'asc')
            ->get();
        }
        
        $report_name = 'Inventory Stock Details Report';
        $start_date = $req->startDate ? $req->startDate : date('d/m/Y');
        $end_date = $req->endDate ? $req->endDate : date('d/m/Y');
        $pdf = Pdf::loadView('reports.product_reports.stock_statement.details.print', compact('report_name', 'start_date', 'end_date', 'data'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    } // End Method
}
