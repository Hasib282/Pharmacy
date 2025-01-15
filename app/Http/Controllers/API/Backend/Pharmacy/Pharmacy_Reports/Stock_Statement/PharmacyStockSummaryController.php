<?php

namespace App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Reports\Stock_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Transaction_Head;

class PharmacyStockSummaryController extends Controller
{
    // Show All Pharmacy Stock Summary Statement
    public function ShowAll(Request $req){
        $pharmacy = Transaction_Head::on('mysql')->with("Unit","Form","Manufecturer","Category",'Groupe')
        ->whereHas('Groupe', function ($query){
            $query->where('tran_groupe_type', 6);
        })
        ->orderBy('tran_head_name','asc')
        ->paginate(15);

        return response()->json([
            'status'=> true,
            'data' => $pharmacy,
        ], 200);
    } // End Method



    // Search Pharmacy Stock Summary Statement
    public function Search(Request $req){
        if($req->searchOption == 1){
            $pharmacy = Transaction_Head::on('mysql')->with("Unit","Form","Manufecturer","Category",'Groupe')
            ->whereHas('Groupe', function ($query){
                $query->where('tran_groupe_type', 6);
            })
            ->where('tran_head_name', 'like', $req->search.'%')
            ->orderBy('tran_head_name','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $pharmacy = Transaction_Head::on('mysql')->with("Unit","Form","Manufecturer","Category",'Groupe')
            ->whereHas('Groupe', function ($query) use ($req){
                $query->where('tran_groupe_type', 6);
                $query->where('tran_groupe_name', 'like', $req->search . '%');
                $query->orderBy('tran_groupe_name','asc');
            })
            ->paginate(15);
        }
        else if($req->searchOption == 3){
            $pharmacy = Transaction_Head::on('mysql')->with("Unit","Form","Manufecturer","Category",'Groupe')
            ->whereHas('Groupe', function ($query){
                $query->where('tran_groupe_type', 6);
            })
            ->whereHas('Category', function ($query) use ($req) {
                $query->where('category_name', 'like', $req->search . '%');
                $query->orderBy('category_name','asc');
            })
            ->paginate(15);
        }
        else if($req->searchOption == 4){
            $pharmacy = Transaction_Head::on('mysql')->with("Unit","Form","Manufecturer","Category",'Groupe')
            ->whereHas('Groupe', function ($query){
                $query->where('tran_groupe_type', 6);
            })
            ->whereHas('Manufecturer', function ($query) use ($req) {
                $query->where('manufacturer_name', 'like', $req->search . '%');
                $query->orderBy('manufacturer_name','asc');
            })
            ->paginate(15);
        }
        else if($req->searchOption == 5){
            $pharmacy = Transaction_Head::on('mysql')->with("Unit","Form","Manufecturer","Category",'Groupe')
            ->whereHas('Groupe', function ($query){
                $query->where('tran_groupe_type', 6);
            })
            ->whereHas('Form', function ($query) use ($req) {
                $query->where('form_name', 'like', $req->search . '%');
                $query->orderBy('form_name','asc');
            })
            ->paginate(15);
        }
        
        return response()->json([
            'status' => true,
            'data' => $pharmacy,
        ], 200);
    } // End Method



    // Print Pharmacy Stock Summary Report
    public function Print(Request $req){
        if ($req->query()) {
            if($req->searchOption == 1){
                $data = Transaction_Head::on('mysql')->with("Unit","Form","Manufecturer","Category",'Groupe')
                ->whereHas('Groupe', function ($query){
                    $query->where('tran_groupe_type', 6);
                })
                ->where('tran_head_name', 'like', $req->search.'%')
                ->orderBy('tran_head_name','asc')
                ->get();
            }
            else if($req->searchOption == 2){
                $data = Transaction_Head::on('mysql')->with("Unit","Form","Manufecturer","Category",'Groupe')
                ->whereHas('Groupe', function ($query) use ($req){
                    $query->where('tran_groupe_type', 6);
                    $query->where('tran_groupe_name', 'like', $req->search . '%');
                    $query->orderBy('tran_groupe_name','asc');
                })
                ->get();
            }
            else if($req->searchOption == 3){
                $data = Transaction_Head::on('mysql')->with("Unit","Form","Manufecturer","Category",'Groupe')
                ->whereHas('Groupe', function ($query){
                    $query->where('tran_groupe_type', 6);
                })
                ->whereHas('Category', function ($query) use ($req) {
                    $query->where('category_name', 'like', $req->search . '%');
                    $query->orderBy('category_name','asc');
                })
                ->get();
            }
            else if($req->searchOption == 4){
                $data = Transaction_Head::on('mysql')->with("Unit","Form","Manufecturer","Category",'Groupe')
                ->whereHas('Groupe', function ($query){
                    $query->where('tran_groupe_type', 6);
                })
                ->whereHas('Manufecturer', function ($query) use ($req) {
                    $query->where('manufacturer_name', 'like', $req->search . '%');
                    $query->orderBy('manufacturer_name','asc');
                })
                ->get();
            }
            else if($req->searchOption == 5){
                $data = Transaction_Head::on('mysql')->with("Unit","Form","Manufecturer","Category",'Groupe')
                ->whereHas('Groupe', function ($query){
                    $query->where('tran_groupe_type', 6);
                })
                ->whereHas('Form', function ($query) use ($req) {
                    $query->where('form_name', 'like', $req->search . '%');
                    $query->orderBy('form_name','asc');
                })
                ->get();
            }
        }
        else {
            $data = Transaction_Head::on('mysql')->with("Unit","Form","Manufecturer","Category",'Groupe')
            ->whereHas('Groupe', function ($query){
                $query->where('tran_groupe_type', 6);
            })
            ->orderBy('tran_head_name','asc')
            ->get();
        }
        
        $report_name = 'Pharmacy Stock Summary Report';
        $start_date = $req->startDate ? $req->startDate : date('d/m/Y');
        $end_date = $req->endDate ? $req->endDate : date('d/m/Y');
        $pdf = Pdf::loadView('reports.product_reports.stock_statement.summary.print', compact('report_name', 'start_date', 'end_date', 'data'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    } // End Method
}
