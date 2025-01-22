<?php

namespace App\Http\Controllers\Frontend\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BankTransactionController extends Controller
{
    /////////////////////////// --------------- Bank Transaction Methods Starts ---------- //////////////////////////
    // Show All Bank Withdraws
    public function ShowBankWithdraws(Request $req){
        $name = "Bank Withdraw";
        $js = "withdraw";
        if ($req->ajax()) {
            return view('transaction.bank.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('transaction.bank.main', compact('name', 'js'));
        }
    } // End Method

    
    
    // Show All Bank Deposits
    public function ShowBankDeposits(Request $req){
        $name = "Bank Deposit";
        $js = "deposit";
        if ($req->ajax()) {
            return view('transaction.bank.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('transaction.bank.main', compact('name', 'js'));
        }
    } // End Method



    // Search Bank Transaction
    public function SearchBankTransactions(Request $req){
        $requestPath = $req->path();
        if (strpos($requestPath, 'withdraw') !== false) {
            $name = "Bank Withdraw";
            $js = "withdraw";
            return view('transaction.bank.main', compact('name', 'js'));
        }
        else if(strpos($requestPath, 'deposit') !== false){
            $name = "Bank Deposit";
            $js = "deposit";
            return view('transaction.bank.main', compact('name', 'js'));
        }
    } // End Method

    /////////////////////////// --------------- Bank Transaction Methods End ---------- //////////////////////////
}
