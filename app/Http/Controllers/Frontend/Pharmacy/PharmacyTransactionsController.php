<?php

namespace App\Http\Controllers\Frontend\Pharmacy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PharmacyTransactionsController extends Controller
{
    /////////////////////////// --------------- Pharmacy Purchase Methods start ---------- //////////////////////////
    // Show All Purchase Details
    public function ShowPharmacyPurchase(Request $req){
        $name = "Pharmacy Purchase";
        $js = 'pharmacy/pharmacy_transaction/phar_purchase';
        if ($req->ajax()) {
            return view('transaction.purchase.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('transaction.purchase.purchase', compact('name', 'js'));
        }
    } // End Method



    // Search Pharmacy Purchase
    public function SearchPharmacyPurchase(Request $req){
        $name = "Pharmacy Purchase";
        $js = 'pharmacy/pharmacy_transaction/phar_purchase';
        return view('transaction.purchase.purchase', compact('name', 'js'));
    } // End Method
    




    /////////////////////////// --------------- Pharmacy Issue Methods start ---------- //////////////////////////
    // Show All Issue Details
    public function ShowPharmacyIssue(Request $req){
        $name = "Pharmacy Issue";
        $js = 'pharmacy/pharmacy_transaction/phar_issue';
        if ($req->ajax()) {
            return view('transaction.issue.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('transaction.issue.issue', compact('name', 'js'));
        }
    } // End Method



    // Search Pharmacy Issue
    public function SearchPharmacyIssue(Request $req){
        $name = "Pharmacy Issue";
        $js = 'pharmacy/pharmacy_transaction/phar_issue';
        return view('transaction.issue.issue', compact('name', 'js'));
    } // End Method
}
