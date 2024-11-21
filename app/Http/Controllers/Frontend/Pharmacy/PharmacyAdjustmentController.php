<?php

namespace App\Http\Controllers\Frontend\Pharmacy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PharmacyAdjustmentController extends Controller
{
    /////////////////////////// --------------- Positive Adjustment Methods start ---------- //////////////////////////
    // Show Positive Adjustment
    public function ShowPositiveAdjustment(Request $req){
        $name = "Positive Adjustment";
        $js = 'pharmacy/adjustment/positive_adjustment';
        if ($req->ajax()) {
            return view('transaction.adjustment.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('transaction.adjustment.adjustments', compact('name', 'js'));
        }
    } // End Method




    // Search Positive Adjustment 
    public function SearchPositiveAdjustment(Request $req){
        $name = "Positive Adjustment";
        $js = 'pharmacy/adjustment/positive_adjustment';
        return view('transaction.adjustment.adjustments', compact('name', 'js'));
    } // End Method

    
    
    /////////////////////////// --------------- Negative Adjustment Methods start ---------- //////////////////////////
    // Show Negative Adjustment
    public function ShowNegativeAdjustment(Request $req){
        $name = "Negative Adjustment";
        $js = 'pharmacy/adjustment/negative_adjustment';
        if ($req->ajax()) {
            return view('transaction.adjustment.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('transaction.adjustment.adjustments', compact('name', 'js'));
        }
    } // End Method

    
    
    // Search Negative Adjustment 
    public function SearchNegativeAdjustment(Request $req){
        $name = "Negative Adjustment";
        $js = 'pharmacy/adjustment/negative_adjustment';
        return view('transaction.adjustment.adjustments', compact('name', 'js'));
    } // End Method
}