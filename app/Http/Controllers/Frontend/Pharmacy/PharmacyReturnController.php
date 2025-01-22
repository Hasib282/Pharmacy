<?php

namespace App\Http\Controllers\Frontend\Pharmacy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PharmacyReturnController extends Controller
{
    /////////////////////////// --------------- Client Return Methods start ---------- //////////////////////////
    // Show All ClientReturn Details
    public function ShowClientReturn(Request $req){
        $name = "Client Return";
        $js = 'pharmacy/pharmacy_transaction/client_return';
        if ($req->ajax()) {
            return view('transaction.return.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('transaction.return.main', compact('name', 'js'));
        }
    } // End Method



    // Search Client Return
    public function SearchClientReturn(Request $req){
        $name = "Client Return";
        $js = 'pharmacy/pharmacy_transaction/client_return';
        return view('transaction.return.main', compact('name', 'js'));
    } // End Method


    


    /////////////////////////// --------------- Supplier Return Methods start ---------- //////////////////////////
    // Show All SupplierReturn Details
    public function ShowSupplierReturn(Request $req){
        $name = "Supplier Return";
        $js = 'pharmacy/pharmacy_transaction/supplier_return';
        if ($req->ajax()) {
            return view('transaction.return.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('transaction.return.main', compact('name', 'js'));
        }
    } // End Method

    
    
    // Search Supplier Return
    public function SearchSupplierReturn(Request $req){
        $name = "Supplier Return";
        $js = 'pharmacy/pharmacy_transaction/supplier_return';
        return view('transaction.return.main', compact('name', 'js'));
    } // End Method
}
