<?php

namespace App\Http\Controllers\Frontend\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentStatementController extends Controller
{
    ///////////////////////// --------------------------- Payment Statement Summary Report Part Start -------------------- /////////////////////////
    // Show Payment Statement Summary Report  
    public function ShowPaymentSummary(Request $req){
        $name = "Payment Statement Summary";
        $js = 'payment_statement/summary';
        if ($req->ajax()) {
            return view('reports.payment_statement.summary.ajaxBlade');
        }
        else{
            return view('reports.payment_statement.summary.main');
        }
    }



    // Search Payment Statement Summary Report
    public function SearchPaymentSummary(Request $req){
        $name = "Payment Statement Summary";
        $js = 'payment_statement/summary';
        return view('reports.payment_statement.summary.main');
    }




    
    ///////////////////////// --------------------------- Payment Statement Details Report Part Start -------------------- /////////////////////////
    // Show Payment Statement Details Report  
    public function ShowPaymentDetails(Request $req){
        $name = "Payment Statement Details";
        $js = 'payment_statement/details';
        if ($req->ajax()) {
            return view('reports.payment_statement.details.ajaxBlade');
        }
        else{
            return view('reports.payment_statement.details.main');
        }
    }



    // Search Payment Statement Details Report
    public function SearchPaymentDetails(Request $req){
        $name = "Payment Statement Details";
        $js = 'payment_statement/details';
        return view('reports.payment_statement.details.main');
    }
}
