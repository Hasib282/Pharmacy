<?php

namespace App\Http\Controllers\Frontend\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Transaction_Main;
use App\Models\Party_Payment_Receive;

class PartyStatementController extends Controller
{
    ///////////////////////// --------------------------- Party Summary Report Part Start -------------------- /////////////////////////
    // Show Party Summary Report  
    public function PartySummaryReport(Request $req){
        $name = "Positive Adjustment";
        $js = 'pharmacy/adjustment/positive_adjustment';
        if ($req->ajax()) {
            return view('reports.party_statement.party_summary.ajaxBlade');
        }
        else{
            return view('reports.party_statement.party_summary.main');
        }
    }



    // Search Party Summary Report
    public function SearchPartySummaryReport(Request $req){
        $name = "Positive Adjustment";
        $js = 'pharmacy/adjustment/positive_adjustment';
        return view('reports.party_statement.party_summary.main');
    }




    
    ///////////////////////// --------------------------- Party Details Report Part Start -------------------- /////////////////////////
    // Show Party Details Report  
    public function PartyDetailsReport(Request $req){
        $name = "Positive Adjustment";
        $js = 'pharmacy/adjustment/positive_adjustment';
        if ($req->ajax()) {
            return view('reports.party_statement.party_details.ajaxBlade');
        }
        else{
            return view('reports.party_statement.party_details.main');
        }
    }



    // Search Party Details Report
    public function SearchPartyDetailsReport(Request $req){
        $name = "Positive Adjustment";
        $js = 'pharmacy/adjustment/positive_adjustment';
        return view('reports.party_statement.party_details.main');
    }
}
