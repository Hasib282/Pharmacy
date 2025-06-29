<?php

namespace App\Http\Controllers\Frontend\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConsolidatedStatementController extends Controller
{
    ///////////////////////// --------------------------- Consolidated Statement Summary Report Part Start -------------------- /////////////////////////
    // Show Consolidated Statement Summary Report  
    public function ShowConsolidatedSummary(Request $req){
        $name = "Consolidated Statement Summary";
        $js = 'consolidated_statement/summary';
        if ($req->ajax()) {
            return view('reports.consolidated_statement.summary.ajaxBlade');
        }
        else{
            return view('reports.consolidated_statement.summary.main');
        }
    }



    // Search Consolidated Statement Summary Report
    public function SearchConsolidatedSummary(Request $req){
        $name = "Consolidated Statement Summary";
        $js = 'consolidated_statement/summary';
        return view('reports.consolidated_statement.summary.main');
    }




    
    ///////////////////////// --------------------------- Consolidated Statement Details Report Part Start -------------------- /////////////////////////
    // Show Consolidated Statement Details Report  
    public function ShowConsolidatedDetails(Request $req){
        $name = "Consolidated Statement Details";
        $js = 'consolidated_statement/details';
        if ($req->ajax()) {
            return view('reports.consolidated_statement.details.ajaxBlade');
        }
        else{
            return view('reports.consolidated_statement.details.main');
        }
    }



    // Search Consolidated Statement Details Report
    public function SearchConsolidatedDetails(Request $req){
        $name = "Consolidated Statement Details";
        $js = 'consolidated_statement/details';
        return view('reports.consolidated_statement.details.main');
    }
}
