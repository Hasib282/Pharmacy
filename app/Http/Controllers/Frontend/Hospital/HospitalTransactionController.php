<?php

namespace App\Http\Controllers\Frontend\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HospitalTransactionController extends Controller
{
    /////////////////////////// ---------------Admission fee Methods Start Here ---------- //////////////////////////
    // Show Admission fee
    public function ShowAdmission(Request $req){
        $name = "Admission Fee";
        $js = 'hospital/hospital_transaction/admission';
        if ($req->ajax()) {
            return view('transaction.hospital.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('transaction.hospital.main', compact('name', 'js'));
        }
    } // End Method



    // Search Admission fee
    public function SearchAdmission(Request $req){
        $name = "Admission Fee";
        $js = 'hospital/hospital_transaction/admission';
        return view('transaction.hospital.main', compact('name', 'js'));
    } // End Method
    
    
    

    
    /////////////////////////// ---------------Deposit Methods Start Here ---------- //////////////////////////
    // Show Admission fee
    public function ShowDeposit(Request $req){
        $name = "Deposit Fee";
        $js = 'hospital/hospital_transaction/deposit';
        if ($req->ajax()) {
            return view('transaction.hospital.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('transaction.hospital.main', compact('name', 'js'));
        }
    } // End Method



    // Search Admission fee
    public function SearchDeposit(Request $req){
        $name = "Deposit Fee";
        $js = 'hospital/hospital_transaction/admission';
        return view('transaction.hospital.main', compact('name', 'js'));
    } // End Method





    /////////////////////////// ---------------Deposit Refunds Methods Start Here ---------- //////////////////////////
    // Show Deposit Refunds
    public function ShowDepositRefund(Request $req){
        $name = "Deposit Refund";
        $js = 'hospital/hospital_transaction/depositrefund';
        if ($req->ajax()) {
            return view('transaction.hospital.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('transaction.hospital.main', compact('name', 'js'));
        }
    } // End Method



    // Search Deposit Refunds
    public function SearchDepositRefund(Request $req){
        $name = "Deposit Refund";
        $js = 'hospital/hospital_transaction/admission';
        return view('transaction.hospital.main', compact('name', 'js'));
    } // End Method





    /////////////////////////// ---------------service Methods Start Here ---------- //////////////////////////
    // Show Services
    public function ShowServices(Request $req){
        $name = "Service Fee";
        $js = 'hospital/hospital_transaction/services';
        if ($req->ajax()) {
            return view('transaction.hospital.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('transaction.hospital.main', compact('name', 'js'));
        }
    } // End Method



    // Search Services
    public function SearchServices(Request $req){
        $name = "Services Fee";
        $js = 'hospital/hospital_transaction/services';
        return view('transaction.hospital.main', compact('name', 'js'));
    } // End Method
}
