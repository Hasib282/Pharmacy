<?php

namespace App\Http\Controllers\Frontend\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HotelTransactionController extends Controller
{
 


     public function ShowServices(Request $req){
            $name = "Hotel Services";
            $js = 'hotel/transaction/services';
            if ($req->ajax()) {
                return view('transaction.hotel.ajaxBlade', compact('name', 'js'));
            }
            else{
                return view('transaction.hotel.main', compact('name', 'js'));
            }
        }// End Method

        public function SearchServices(Request $req){
            $name = "Hotel Services";
            $js = 'hotel/transaction/services';
           
            
            return view('transaction.hotel.main', compact('name', 'js'));
            
        }// End Method
    
}
