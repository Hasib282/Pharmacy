<?php

namespace App\Http\Controllers\Frontend\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HotelTransactionController extends Controller
{
    /////////////////////////// --------------- Hotel Services Methods Start Here ---------- //////////////////////////
    // Show Hotel Services
    public function ShowServices(Request $req){
        $name = "Hotel Services";
        $js = 'hotel/transaction/services';
        if ($req->ajax()) {
            return view('transaction.hotel.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('transaction.hotel.main', compact('name', 'js'));
        }
    } // End Method
    
    
    
    // Search Hotel Services
    public function SearchServices(Request $req){
        $name = "Hotel Services";
        $js = 'hotel/transaction/services';

        return view('transaction.hotel.main', compact('name', 'js'));        
    } // End Method
    
    
    
    
    
    /////////////////////////// --------------- Hotel Deposits Methods Start Here ---------- //////////////////////////
    // Show Hotel Deposits
    public function ShowDeposits(Request $req){
        $name = "Hotel Deposits";
        $js = 'hotel/transaction/services';
        if ($req->ajax()) {
            return view('transaction.hotel.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('transaction.hotel.main', compact('name', 'js'));
        }
    } // End Method
    
    
    
    // Search Hotel Deposits
    public function SearchDeposits(Request $req){
        $name = "Hotel Deposits";
        $js = 'hotel/transaction/services';

        return view('transaction.hotel.main', compact('name', 'js'));        
    } // End Method
    
    
    
    
    
    /////////////////////////// --------------- Hotel Refunds Methods Start Here ---------- //////////////////////////
    // Show Hotel Refunds
    public function ShowRefunds(Request $req){
        $name = "Hotel Refunds";
        $js = 'hotel/transaction/services';
        if ($req->ajax()) {
            return view('transaction.hotel.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('transaction.hotel.main', compact('name', 'js'));
        }
    } // End Method
    
    
    
    // Search Hotel Refunds
    public function SearchRefunds(Request $req){
        $name = "Hotel Refunds";
        $js = 'hotel/transaction/services';

        return view('transaction.hotel.main', compact('name', 'js'));        
    } // End Method
    
}
