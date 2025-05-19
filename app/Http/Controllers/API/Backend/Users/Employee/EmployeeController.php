<?php

namespace App\Http\Controllers\API\Backend\Users\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User_Info;
use App\Models\Payroll_Setup;
use App\Models\Transaction_With;
use App\Models\Employee_Personal_Detail;
use App\Models\Employee_Training_Detail;
use App\Models\Employee_Education_Detail;
use App\Models\Employee_Experience_Detail;
use App\Models\Employee_Organization_Detail;

class EmployeeController extends Controller
{
    // Show All Employee Details
    public function Show(Request $req){
        $data = User_Info::on('mysql_second')->with('Withs','Location')->where('user_role', 3)->orderBy('added_at','asc')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Delete Employee Details
    public function Delete(Request $req){
        User_Info::on('mysql_second')->where('user_role', 3)->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Employee Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Show Employee Details
    public function Details(Request $req){
        $education = $training = $experience = $organization = null;
        // Check the value of the 4th segment
        $segment = $req->segment(4);

        // Load data based on the segment value
        if ($segment === 'all' || $segment === 'education') {
            $education = Employee_Education_Detail::where('emp_id', $req->id)->orderBy('created_at', 'asc')->get();
        }
        if ($segment === 'all' || $segment === 'training') {
            $training = Employee_Training_Detail::where('emp_id', $req->id)->orderBy('created_at', 'asc')->get();
        }
        if ($segment === 'all' || $segment === 'experience') {
            $experience = Employee_Experience_Detail::where('emp_id', $req->id)->orderBy('created_at', 'asc')->get();
        }
        if ($segment === 'all' || $segment === 'organization') {
            $organization = Employee_Organization_Detail::where('emp_id', $req->id)->get();
        }

        // Fetch additional details
        $personaldetail = Employee_Personal_Detail::where('employee_id', $req->id)->get();
        $payroll = Payroll_Setup::with('Head', 'Employee')->where('emp_id', $req->id)->get();
        
        return response()->json([
            'status' => true,
            'data' => view('common_modals.employeeDetails', compact('personaldetail', 'education', 'training', 'experience', 'organization', 'payroll'))->render(),
        ]);
    } // End Method
}
