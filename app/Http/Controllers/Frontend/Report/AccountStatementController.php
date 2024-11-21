<?php

namespace App\Http\Controllers\Frontend\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Transaction_Detail;
use App\Models\Transaction_Main;
use App\Models\Transaction_Main_Head;

class AccountStatementController extends Controller
{
    ///////////////////////// --------------------------- Accounts Summary Statement Part Start -------------------- /////////////////////////
    // Show Accounts Summary Statement
    public function ShowAccountSummaryStatement(Request $req) {
        $name = "Positive Adjustment";
        $js = 'pharmacy/adjustment/positive_adjustment';
        if ($req->ajax()) {
            return view('reports.account_statement.summary.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.account_statement.summary.accountSummary', compact('name', 'js'));
        }
    } // End Method


    
    // Search Accounts Summary Statement
    public function SearchAccountSummaryStatement(Request $req) {
        $name = "Positive Adjustment";
        $js = 'pharmacy/adjustment/positive_adjustment';
        return view('reports.account_statement.summary.accountSummary', compact('name', 'js'));
    } // End Method



    
    
    ///////////////////////// --------------------------- Accounts Summary Groupe Statement Part Start -------------------- /////////////////////////
    // Show Accounts Summary Groupe Statement
    public function ShowAccountSummaryGroupeStatement(Request $req) {
        $name = "Positive Adjustment";
        $js = 'pharmacy/adjustment/positive_adjustment';
        if ($req->ajax()) {
            return view('reports.account_statement.summary_groupe.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.account_statement.summary_groupe.accountSummaryGroupe', compact('name', 'js'));
        }
    } // End Method



    // Search Accounts Summary Groupe Statement
    public function SearchAccountSummaryGroupeStatement(Request $req) {
        $name = "Positive Adjustment";
        $js = 'pharmacy/adjustment/positive_adjustment';
        return view('reports.account_statement.summary_groupe.accountSummaryGroupe', compact('name', 'js'));
    } // End Method





    ///////////////////////// --------------------------- Accounts Details Statement Part Start -------------------- /////////////////////////
    // Show Accounts Details Statement
    public function ShowAccountDetailsStatement(Request $req){
        $name = "Positive Adjustment";
        $js = 'pharmacy/adjustment/positive_adjustment';
        if ($req->ajax()) {
            return view('reports.account_statement.details.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.account_statement.details.accountDetails', compact('name', 'js'));
        }
    } //End Method



    // Search Accounts Details Statement
    public function SearchAccountDetailsStatement(Request $req) {
        $name = "Positive Adjustment";
        $js = 'pharmacy/adjustment/positive_adjustment';
        return view('reports.account_statement.details.accountDetails', compact('name', 'js'));
    } // End Method
}
