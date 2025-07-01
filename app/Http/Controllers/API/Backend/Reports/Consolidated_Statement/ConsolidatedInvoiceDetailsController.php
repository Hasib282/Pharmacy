<?php

namespace App\Http\Controllers\API\Backend\Reports\Consolidated_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Transaction_Detail;

class ConsolidatedInvoiceDetailsController extends Controller
{
    // Show All Consolidated Details Report
    public function Show(Request $req){
        $receive = Transaction_Detail::on('mysql_second')
        ->whereRaw("DATE(tran_date) < ?", [date('Y-m-d')])
        ->get()
        ->sum('receive');
        
        $payment = Transaction_Detail::on('mysql_second')
        ->whereRaw("DATE(tran_date) < ?", [date('Y-m-d')])
        ->get()
        ->sum('payment');

        $opening = $receive - $payment;

        $data = Transaction_Detail::on('mysql_second')
            ->with('Groupe', 'Head','User','Bank','Type')
            ->whereDate('tran_date', date('Y-m-d'))
            ->where(function ($query) {
                $query->where('receive', '>', 0)
                      ->orWhere('payment', '>', 0);
            })
            ->orderBy('tran_date', 'asc')
            ->get();
        
        return response()->json([
            'status'=> true,
            'data' => $data,
            'opening' => $opening,
        ], 200);
    } // End Method
    
    
    
    // Search All Consolidated Details Report
    public function Search(Request $req){
        $receive = Transaction_Detail::on('mysql_second')
        ->whereRaw("DATE(tran_date) < ?", [$req->startDate])
        ->get()
        ->sum('receive');
        
        $payment = Transaction_Detail::on('mysql_second')
        ->whereRaw("DATE(tran_date) < ?", [$req->startDate])
        ->get()
        ->sum('payment');

        $opening = $receive - $payment;

        $data = Transaction_Detail::on('mysql_second')
            ->with('Groupe', 'Head','User','Bank','Type')
            ->whereBetween(DB::raw('DATE(tran_date)'), [$req->startDate, $req->endDate])
            ->where(function ($query) {
                $query->where('receive', '>', 0)
                      ->orWhere('payment', '>', 0);
            })
            // ->where('tran_type', $tranType)
            ->orderBy('tran_date', 'asc')
            ->get();
        
        return response()->json([
            'status'=> true,
            'data' => $data,
            'opening' => $opening,
        ], 200);
    } // End Method
}
