<?php

namespace App\Http\Controllers\Frontend\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HrReportController extends Controller
{
    ///////////////////////// --------------------------- Salary Summary Report Part Start -------------------- /////////////////////////
    // Show Salary Summary Report
    public function SalarySummaryReport(Request $req){
        $name = "Salary Summary";
        if ($req->ajax()) {
            return view('reports.salary_statement.summary.ajaxBlade', compact('name'));
        }
        else{
            return view('reports.salary_statement.summary.main', compact('name'));
        }
    } // End Method



    // Search Salary Summary Report by user
    public function SearchSalarySummaryReport(Request $req){
        $name = "Salary Summary";
        return view('reports.salary_statement.summary.main', compact('name'));
    } // End Method



    

    ///////////////////////// --------------------------- Salary Details Report Part -------------------- /////////////////////////
    // Show Salary Details Report
    public function SalaryDetailsReport(Request $req){
        $name = "Salary Details Report";
        if ($req->ajax()) {
            return view('reports.salary_statement.details.ajaxBlade', compact('name'));
        }
        else{
            return view('reports.salary_statement.details.main', compact('name'));
        }
    } // End Method



    // Search Salary Details Report by user
    public function SearchSalaryDetailsReport(Request $req){
        $name = "Salary Details Report";
        return view('reports.salary_statement.details.main', compact('name'));
    } // End Method

}
