<?php

namespace App\Http\Controllers\API\Backend\Reports\Payment_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Transaction_Detail;

class PaymentInvoiceDetailsController extends Controller
{
    // Show All Payment Details Report
    public function Show(Request $req){
        $data = Transaction_Detail::on('mysql_second')
            ->with('Groupe', 'Head','User','Bank','Type')
            ->whereDate('tran_date', date('Y-m-d'))
            ->where('payment', '>', 0)
            ->orderBy('tran_date', 'asc')
            ->get();
        
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method
    
    
    
    // Search All Payment Details Report
    public function Search(Request $req){
        $data = Transaction_Detail::on('mysql_second')
            ->with('Groupe', 'Head','User','Bank','Type')
            ->whereBetween(DB::raw('DATE(tran_date)'), [$req->startDate, $req->endDate])
            ->where('payment', '>', 0)
            // ->where('tran_type', $tranType)
            ->orderBy('tran_date', 'asc')
            ->get();
        
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method
}
