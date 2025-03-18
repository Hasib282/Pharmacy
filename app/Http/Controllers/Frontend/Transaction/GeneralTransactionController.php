<?php

namespace App\Http\Controllers\Frontend\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GeneralTransactionController extends Controller
{
    // Show All Transaction Receive Details
    public function ShowTransactionReceive(Request $req){
        $name = "Transaction Receive";
        $js = "general/transaction_receive";
        if ($req->ajax()) {
            return view('transaction.general.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('transaction.general.main', compact('name', 'js'));
        }
    } // End Method



    // Show All Transaction Payment Details
    public function ShowTransactionPayment(Request $req){
        $name = "Transaction Payment";
        $js = "general/transaction_payment";
        if ($req->ajax()) {
            return view('transaction.general.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('transaction.general.main', compact('name', 'js'));
        }
    } // End Method



    // Search Transaction
    public function SearchTransaction(Request $req){
        $requestPath = $req->path();
        if (strpos($requestPath, 'receive') !== false) {
            $name = "Transaction Payment";
            $js = "general/transaction_payment";
            return view('transaction.general.main', compact('name', 'js'));
        }
        else if(strpos($requestPath, 'payment') !== false){
            $name = "Transaction Receive";
            $js = "general/transaction_receive";
            return view('transaction.general.main', compact('name', 'js'));
        }
    } // End Method
}
