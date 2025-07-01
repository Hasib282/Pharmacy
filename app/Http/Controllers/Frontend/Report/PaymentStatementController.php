<?php

namespace App\Http\Controllers\Frontend\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentStatementController extends Controller
{
    ///////////////////////// --------------------------- Payment Statement Summary Report Part Start -------------------- /////////////////////////
    // Show Payment Statement Summary Report  
    public function PaymentSummary(Request $req){
        $name = "Payment Statement Summary";
        $js = 'payment_statement/summary';
        if ($req->ajax()) {
            return view('reports.payment_statement.summary.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.payment_statement.summary.main', compact('name', 'js'));
        }
    }



    // Search Payment Statement Summary Report
    public function SearchPaymentSummary(Request $req){
        $name = "Payment Statement Summary";
        $js = 'payment_statement/summary';
        return view('reports.payment_statement.summary.main', compact('name', 'js'));
    }




    
    ///////////////////////// --------------------------- Payment Statement Details Report Part Start -------------------- /////////////////////////
    // Show Payment Statement Details Report  
    public function PaymentDetails(Request $req){
        $name = "Payment Statement Details";
        $js = 'payment_statement/details';
        if ($req->ajax()) {
            return view('reports.payment_statement.details.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.payment_statement.details.main', compact('name', 'js'));
        }
    }



    // Search Payment Statement Details Report
    public function SearchPaymentDetails(Request $req){
        $name = "Payment Statement Details";
        $js = 'payment_statement/details';
        return view('reports.payment_statement.details.main', compact('name', 'js'));
    }
    
    
    
    
    ///////////////////////// --------------------------- Payment Invoice Statement Summary Report Part Start -------------------- /////////////////////////
    // Show Payment Invoice Statement Summary Report  
    public function PaymentInvoiceSummary(Request $req){
        $name = "Payment Invoice Statement Summary";
        $js = 'payment_statement/invoice_summary';
        if ($req->ajax()) {
            return view('reports.payment_statement.summary.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.payment_statement.summary.main', compact('name', 'js'));
        }
    }



    // Search Payment Invoice Statement Summary Report
    public function SearchPaymentInvoiceSummary(Request $req){
        $name = "Payment Invoice Statement Summary";
        $js = 'payment_statement/invoice_summary';
        return view('reports.payment_statement.summary.main', compact('name', 'js'));
    }




    
    ///////////////////////// --------------------------- Payment Invoice Statement Details Report Part Start -------------------- /////////////////////////
    // Show Payment Invoice Statement Details Report  
    public function PaymentInvoiceDetails(Request $req){
        $name = "Payment Invoice Statement Details";
        $js = 'payment_statement/invoice_details';
        if ($req->ajax()) {
            return view('reports.payment_statement.details.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.payment_statement.details.main', compact('name', 'js'));
        }
    }



    // Search Payment Invoice Statement Details Report
    public function SearchPaymentInvoiceDetails(Request $req){
        $name = "Payment Invoice Statement Details";
        $js = 'payment_statement/invoice_details';
        return view('reports.payment_statement.details.main', compact('name', 'js'));
    }
}
