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
        if ($req->ajax()) {
            return view('hr.payroll.payroll_setup.ajaxBlade');
        }
        else{
            return view('hr.payroll.payroll_setup.payrollSetup');
        }
    } // End Method 



    // Search Payroll Setup by user
    public function SearchPayrollSetup(Request $req){
        return view('hr.payroll.payroll_setup.payrollSetup');
    } // End Method

    /////////////// ----------------------- Payroll Setup Part End Here ------------------- ////////////////




    /////////////// ----------------------- Payroll Middlewire Part Start Here ------------------- ////////////////
    // Show Payroll Miiddlewire
    public function ShowPayrollMiddlewire(Request $req){
        if ($req->ajax()) {
            return view('hr.payroll.payroll_middlewire.ajaxBlade');
        }
        else{
            return view('hr.payroll.payroll_middlewire.payrollMiddlewire');
        }
    } // End Method



    // Search Payroll Middlewire by user
    public function SearchPayrollMiddlewire(Request $req){
        return view('hr.payroll.payroll_middlewire.payrollMiddlewire');
    } // End Method

    /////////////// ----------------------- Payroll Middlewire Part End Here ------------------- ////////////////





    ////////////// ------------------------ Payroll Process Part Start Here --------------------- ////////////////////////////
    // Show Payroll
    public function ShowPayroll(Request $req){
        if ($req->ajax()) {
            return view('hr.payroll.payroll_installment.ajaxBlade');
        }
        else{
            return view('hr.payroll.payroll_installment.payroll');
        }
    } // End Method 



    // Search Payroll by user
    public function SearchPayroll(Request $req){
        return view('hr.payroll.payroll_installment.payroll');
    } // End Method

    ////////////// ------------------------ Payroll Part End Here --------------------- ////////////////////////////


    // Get Payroll By User And Date
    public function GetPayrollByUserIdAndDate(Request $req){
        $currentYear = $req->year;
        $currentMonth = $req->month;
        $payrolls = Pay_Roll_Setup::with('Employee')->select(
            'emp_id',
            'head_id',
            'amount',
            \DB::raw('0 as date'),
        )
        ->where('emp_id', $req->id)
        ->union(
            Pay_Roll_Middlewire::select(
                'emp_id',
                'head_id',
                'amount',
                'date',
            )
            ->where('emp_id', $req->id)
            ->where(function ($query) use ($currentYear, $currentMonth) {
                $query->whereYear('date', $currentYear)
                    ->whereMonth('date', $currentMonth)
                    ->orWhereNull('date');
            })
        )
        ->orderBy('emp_id')
        ->get();
        
        $heads = Transaction_Head::where('groupe_id','1')->get();
        return response()->json([
            'status'=> 'success',
            'data'=> view('hr.payroll.details',compact('payrolls'))->render(),
            'payrolls'=> $payrolls,
            'heads' => $heads
        ]); 
    } // End Method
}
