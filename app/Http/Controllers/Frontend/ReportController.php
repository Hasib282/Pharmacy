<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Pay_Roll_Setup; 
use App\Models\Pay_Roll_Middlewire; 
use App\Models\Transaction_Head;
use App\Models\Transaction_With; 
use App\Models\Transaction_Main;
use App\Models\Transaction_Detail;
use App\Models\Transaction_Groupe;
use App\Models\Party_Payment_Receive;
use App\Models\Transaction_Main_head;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    ///////////////////////// --------------------------- Report By Groupe Part Start -------------------- /////////////////////////
    // Show Report By groupe 
    public function ReportByGroupe(Request $req){
        if ($req->ajax()) {
            return view('reports.report_by_groupe.ajaxBlade');
        }
        else{
            return view('reports.report_by_groupe.report_by_groupe');
        }
    }



    // Search Report By groupe 
    public function SearchReportByGroupeDate(Request $req){
        return view('reports.report_by_groupe.report_by_groupe');
    } 





    ///////////////////////// --------------------------- Summary Report Part Start -------------------- /////////////////////////
    // Show Summary Report
    public function SummaryReport(Request $req){
        if ($req->ajax()) {
            return view('reports.summary_report.ajaxBlade');
        }
        else{
            return view('reports.summary_report.summary_report');
        }
    }



    // Search Summary Report
    public function SearchSummaryReport(Request $req){
        return view('reports.summary_report.summary_report');
    }


    


    ///////////////////////// --------------------------- Common Methods Start -------------------- /////////////////////////
    // Report Invoice Details
    public function ReportInvoiceDetails(Request $req)
    {
        $transDetailsInvoice = Transaction_Detail::where('tran_id', $req->id)->get();
        $transSum = Transaction_Detail::where('tran_id', $req->id)->sum('tot_amount');
        $transactionMain = Transaction_Main::where('tran_id', $req->id)->first();

        return response()->json([
            'status'=>'success',
            'data'=> view('reports.report_by_groupe.details', compact('transactionMain', 'transDetailsInvoice', 'transSum'))->render(),
        ]);
    } // End Method
}
