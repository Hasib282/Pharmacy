<?php

namespace App\Http\Controllers\Frontend\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HrReportController extends Controller
{
    ///////////////////////// --------------------------- Salary Summary Report Part Start -------------------- /////////////////////////
    // Show Salary Summary Report
    public function SalarySummaryReport(Request $req){
        if ($req->ajax()) {
            return view('reports.salary_statement.summary.ajaxBlade');
        }
        else{
            return view('reports.salary_statement.summary.main');
        }
    } // End Method



    // Search Salary Summary Report by user
    public function SearchSalarySummaryReport(Request $req){
        return view('reports.salary_statement.summary.main');
    } // End Method



    

    ///////////////////////// --------------------------- Salary Details Report Part -------------------- /////////////////////////
    // Show Salary Details Report
    public function SalaryDetailsReport(Request $req){
        if ($req->ajax()) {
            return view('reports.salary_statement.details.ajaxBlade');
        }
        else{
            return view('reports.salary_statement.details.main');
        }
    } // End Method



    // Search Salary Details Report by user
    public function SearchSalaryDetailsReport(Request $req){
        return view('reports.salary_statement.details.main');
    } // End Method

}
