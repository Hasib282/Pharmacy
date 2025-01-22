<?php

namespace App\Http\Controllers\Frontend\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transaction_Main;

class BalanceSheetController extends Controller
{
    ///////////////////////// --------------------------- Balance Sheet Summary Report Part Start -------------------- /////////////////////////
    // Show Balance Sheet Summary Report  
    public function BalanceSheetSummaryReport(Request $req){
        $name = "Positive Adjustment";
        $js = 'pharmacy/adjustment/positive_adjustment';
        if ($req->ajax()) {
            return view('reports.balance_sheet.summary.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.balance_sheet.summary.main', compact('name', 'js'));
        }
    } //End Method
    
    


    
    ///////////////////////// --------------------------- Balance Sheet Details Report Part Start -------------------- /////////////////////////
    // Show Balance Sheet Details Report 
    public function BalanceSheetDetailsReport(Request $req){
        $name = "Positive Adjustment";
        $js = 'pharmacy/adjustment/positive_adjustment';
        if ($req->ajax()) {
            return view('reports.balance_sheet.details.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.balance_sheet.details.main', compact('name', 'js'));
        }
    } //End Method
}
