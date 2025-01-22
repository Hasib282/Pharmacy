<?php

namespace App\Http\Controllers\Frontend\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User_Info;
use App\Models\Attendence;
use App\Models\Pay_Roll_Setup;

use App\Models\Transaction_With;
use App\Models\Employee_Personal_Detail;
use App\Models\Employee_Training_Detail;
use App\Models\Employee_Education_Detail;
use App\Models\Employee_Experience_Detail;
use App\Models\Employee_Organization_Detail;

class EmployeeInfoController extends Controller
{
    /////////////////////////// --------------- All Employees Details Table Methods Starts---------- //////////////////////////
    // Show All Employees
    public function ShowEmployees(Request $req){
        $name = "Employee Details";
        if ($req->ajax()) {
            return view('hr.employee_info.employees.ajaxBlade', compact('name'));
        }
        else{
            return view('hr.employee_info.employees.main', compact('name'));
        }
    } // End Method



    // Search Employees
    public function SearchEmployees(Request $req){
        $name = "Employee Details";
        return view('hr.employee_info.employees.main', compact('name'));
    } // End Method

    /////////////////////////// --------------- All Employees Details Table Methods End---------- //////////////////////////





    /////////////////////////// --------------- Employee Personal Details Table Methods Start---------- //////////////////////////
    // Show All Employee
    public function PersonalDetails(Request $req){
        $name = "Personal Details";
        if ($req->ajax()) {
            return view('hr.employee_info.personal_details.ajaxBlade', compact('name'));
        }
        else{
            return view('hr.employee_info.personal_details.main', compact('name'));
        }
    } // End Method


    // Search Employee Personal Details
    public function SearchPersonalDetails(Request $req){
        $name = "Personal Details";
        return view('hr.employee_info.personal_details.main', compact('name'));
    } // End Method

    /////////////////////////// --------------- Employee Personal Details Table Methods End---------- //////////////////////////




    /////////////////////////// --------------- Employee Education Details Table Methods Start---------- //////////////////////////
    // Show All Employees
    public function EducationDetails(Request $req){
        $name = "Personal Details";
        if ($req->ajax()) {
            return view('hr.employee_info.education_details.ajaxBlade', compact('name'));
        }
        else{
            return view('hr.employee_info.education_details.main', compact('name'));
        }
    } // End Method



    // Search Employee Education Details by Name
    public function SearchEducationDetails(Request $req){
        $name = "Personal Details";
        return view('hr.employee_info.education_details.main', compact('name'));
    } // End Method

    /////////////////////////// --------------- Employee Education Details Table Methods End---------- //////////////////////////



    /////////////////////////// --------------- Employee Training Details Table Methods Start---------- //////////////////////////
    // Show All Employee
    public function TrainingDetails(Request $req){
        $name = "Training Details";
        if ($req->ajax()) {
            return view('hr.employee_info.training_details.ajaxBlade', compact('name'));
        }
        else{
            return view('hr.employee_info.training_details.main', compact('name'));
        }
    } // End Method



    // Search Employee by Name
    public function SearchTrainingDetails(Request $req){
        $name = "Training Details";
        return view('hr.employee_info.training_details.main', compact('name'));
    } // End Method

    /////////////////////////// --------------- Employee Training Details Table Methods End---------- //////////////////////////



    /////////////////////////// --------------- Employee Experience Details Table Methods Start---------- //////////////////////////
    // Show All Employees
    public function ExperienceDetails(Request $req){
        $name = "Experience Details";
        if ($req->ajax()) {
            return view('hr.employee_info.experience_details.ajaxBlade', compact('name'));
        }
        else{
            return view('hr.employee_info.experience_details.main', compact('name'));
        }
    } // End Method



    // Search Employee by Name
    public function SearchExperienceDetails(Request $req){
        $name = "Experience Details";
        return view('hr.employee_info.experience_details.main', compact('name'));
    } // End Method

    /////////////////////////// --------------- Employee Experience Details Table Methods End---------- //////////////////////////
    
    
    
    /////////////////////////// --------------- Employee Organization Details Table Methods Start---------- //////////////////////////
    // Show All Employee Details
    public function OrganizationDetails(Request $req){
        $name = "Organization Details";
        if ($req->ajax()) {
            return view('hr.employee_info.organization_details.ajaxBlade', compact('name'));
        }
        else{
            return view('hr.employee_info.organization_details.main', compact('name'));
        }
    } // End Method



    // Search Employee by Name
    public function SearchOrganizationDetails(Request $req){
        $name = "Organization Details";
        return view('hr.employee_info.organization_details.main', compact('name'));
    } // End Method

    /////////////////////////// --------------- Employee Organization Details Table Methods Start---------- //////////////////////////
    
    
    
    
    
    /////////////////////////// --------------- Employee Organization Details Table Methods Start---------- //////////////////////////
    // Show All Employee Details
    public function ShowEmployeeAttendence(Request $req){
        $name = "Attendence";
        if ($req->ajax()) {
            return view('hr.attendence.ajaxBlade', compact('name'));
        }
        else{
            return view('hr.attendence.main', compact('name'));
        }
    } // End Method



    // Search Employee by Name
    public function SearchEmployeeAttendence(Request $req){
        $name = "Attendence";
        return view('hr.attendence.main', compact('name'));
    } // End Method

    /////////////////////////// --------------- Employee Organization Details Table Methods Start---------- //////////////////////////
}
