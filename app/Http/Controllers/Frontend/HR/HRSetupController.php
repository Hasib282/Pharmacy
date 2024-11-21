<?php

namespace App\Http\Controllers\Frontend\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Department_Info;
use App\Models\Designation;

class HRSetupController extends Controller
{
    /////////////////////////// --------------- Department Table Methods start---------- //////////////////////////
    // Show All Departments
    public function ShowDepartments(Request $req){
        if ($req->ajax()) {
            return view('hr.hr_setup.department.ajaxBlade');
        }
        else{
            return view('hr.hr_setup.department.departments');
        }
    } // End Method



    // Departments Search
    public function SearchDepartments(Request $req){
        return view('hr.hr_setup.department.departments');
    } // End Method

    /////////////////////////// --------------- Department Table Methods End---------- //////////////////////////



    /////////////////////////// --------------- Designations Table Methods start ---------- //////////////////////////
    // Show All Designations
    public function ShowDesignations(Request $req){
        if ($req->ajax()) {
            return view('hr.hr_setup.designation.ajaxBlade');
        }
        else{
            return view('hr.hr_setup.designation.designations');
        }
    } // End Method



    // Designation Search
    public function SearchDesignations(Request $req){
        return view('hr.hr_setup.designation.designations');
    } // End Method

    /////////////////////////// --------------- Designations Table Methods End ---------- //////////////////////////
}
