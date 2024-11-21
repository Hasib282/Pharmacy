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
            return view('hr.reports.salary_summary_report.ajaxBlade');
        }
        else{
            return view('hr.reports.salary_summary_report.salarySummaryReports');
        }
    } // End Method



    // Search Salary Summary Report by user
    public function SearchSalarySummaryReport(Request $req){
        return view('hr.reports.salary_summary_report.salarySummaryReports');
    } // End Method



    

    ///////////////////////// --------------------------- Salary Details Report Part -------------------- /////////////////////////
    // Show Salary Details Report
    public function SalaryDetailsReport(Request $req){
        if ($req->ajax()) {
            return view('hr.reports.salary_details_report.ajaxBlade');
        }
        else{
            return view('hr.reports.salary_details_report.salaryDetailsReports');
        }
    } // End Method



    // Search Salary Details Report by user
    public function SearchSalaryDetailsReport(Request $req){
        return view('hr.reports.salary_details_report.salaryDetailsReports');
    } // End Method

}
