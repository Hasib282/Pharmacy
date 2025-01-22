<?php

namespace App\Http\Controllers\Frontend\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Attendence; 
use App\Models\User_Info; 
use App\Models\Transaction_With; 
use App\Models\Transaction_Head; 
use App\Models\Transaction_Main; 
use App\Models\Transaction_Detail; 
use App\Models\Pay_Roll_Setup; 
use App\Models\Pay_Roll_Middlewire; 
use App\Models\Pay_Roll_Setup_Additional; 


class PayRollController extends Controller
{
    /////////////// ----------------------- Payroll Setup Part Start Here ------------------- ////////////////
    // Show Payroll Setup
    public function ShowPayrollSetup(Request $req){
        $name = "Payroll Setup";
        if ($req->ajax()) {
            return view('hr.payroll.payroll_setup.ajaxBlade', compact('name'));
        }
        else{
            return view('hr.payroll.payroll_setup.main', compact('name'));
        }
    } // End Method 



    // Search Payroll Setup by user
    public function SearchPayrollSetup(Request $req){
        $name = "Payroll Setup";
        return view('hr.payroll.payroll_setup.main', compact('name'));
    } // End Method

    /////////////// ----------------------- Payroll Setup Part End Here ------------------- ////////////////




    /////////////// ----------------------- Payroll Middlewire Part Start Here ------------------- ////////////////
    // Show Payroll Miiddlewire
    public function ShowPayrollMiddlewire(Request $req){
        $name = "Payroll Middlewire";
        if ($req->ajax()) {
            return view('hr.payroll.payroll_middlewire.ajaxBlade', compact('name'));
        }
        else{
            return view('hr.payroll.payroll_middlewire.main', compact('name'));
        }
    } // End Method



    // Search Payroll Middlewire by user
    public function SearchPayrollMiddlewire(Request $req){
        $name = "Payroll Middlewire";
        return view('hr.payroll.payroll_middlewire.main', compact('name'));
    } // End Method

    /////////////// ----------------------- Payroll Middlewire Part End Here ------------------- ////////////////





    ////////////// ------------------------ Payroll Process Part Start Here --------------------- ////////////////////////////
    // Show Payroll
    public function ShowPayroll(Request $req){
        if ($req->ajax()) {
            return view('hr.payroll.payroll_installment.ajaxBlade');
        }
        else{
            return view('hr.payroll.payroll_installment.main');
        }
    } // End Method 



    // Search Payroll by user
    public function SearchPayroll(Request $req){
        return view('hr.payroll.payroll_installment.main');
    } // End Method

    ////////////// ------------------------ Payroll Part End Here --------------------- ////////////////////////////
}
