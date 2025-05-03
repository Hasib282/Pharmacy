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
        $name = "Department";
        $js = 'hr/department';
        if ($req->ajax()) {
            return view('common_modals.single_input.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('common_modals.single_input.main', compact('name', 'js'));
        }
    } // End Method



    

    /////////////////////////// --------------- Designations Table Methods start ---------- //////////////////////////
    // Show All Designations
    public function ShowDesignations(Request $req){
        $name = "Designation";
        if ($req->ajax()) {
            return view('hr.designation.ajaxBlade', compact('name'));
        }
        else{
            return view('hr.designation.main', compact('name'));
        }
    } // End Method
}
