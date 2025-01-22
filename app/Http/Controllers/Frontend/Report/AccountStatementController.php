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
        $name = "Account Summary Statement";
        $js = 'report/account_statement/summary';
        if ($req->ajax()) {
            return view('reports.account_statement.summary.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.account_statement.summary.main', compact('name', 'js'));
        }
    } // End Method


    
    // Search Accounts Summary Statement
    public function SearchAccountSummaryStatement(Request $req) {
        $name = "Account Summary Statement";
        $js = 'report/account_statement/summary';
        return view('reports.account_statement.summary.main', compact('name', 'js'));
    } // End Method



    
    
    ///////////////////////// --------------------------- Accounts Summary Groupe Statement Part Start -------------------- /////////////////////////
    // Show Accounts Summary Groupe Statement
    public function ShowAccountSummaryGroupeStatement(Request $req) {
        $name = "Account Summary By Groupe Statement";
        $js = 'report/account_statement/summary_groupe';
        if ($req->ajax()) {
            return view('reports.account_statement.summary_groupe.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.account_statement.summary_groupe.main', compact('name', 'js'));
        }
    } // End Method



    // Search Accounts Summary Groupe Statement
    public function SearchAccountSummaryGroupeStatement(Request $req) {
        $name = "Account Summary By Groupe Statement";
        $js = 'report/account_statement/summary_groupe';
        return view('reports.account_statement.summary_groupe.main', compact('name', 'js'));
    } // End Method





    ///////////////////////// --------------------------- Accounts Details Statement Part Start -------------------- /////////////////////////
    // Show Accounts Details Statement
    public function ShowAccountDetailsStatement(Request $req){
        $name = "Account Details Statement";
        $js = 'report/account_statement/details';
        if ($req->ajax()) {
            return view('reports.account_statement.details.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.account_statement.details.main', compact('name', 'js'));
        }
    } //End Method



    // Search Accounts Details Statement
    public function SearchAccountDetailsStatement(Request $req) {
        $name = "Account Details Statement";
        $js = 'report/account_statement/details';
        return view('reports.account_statement.details.main', compact('name', 'js'));
    } // End Method
}
