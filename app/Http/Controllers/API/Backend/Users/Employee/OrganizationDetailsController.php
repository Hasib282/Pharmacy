<?php

namespace App\Http\Controllers\API\Backend\Users\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User_Info;
use App\Models\Employee_Organization_Detail;
use App\Models\Employee_Personal_Detail;

class OrganizationDetailsController extends Controller
{
    // Show All Employee Organization Details
    public function Show(Request $req){
        $data = User_Info::on('mysql_second')->with('Withs','Location','organizationDetail')->where('user_role', 3)->orderBy('added_at','asc')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Employee Organization Details
    public function Insert(Request $req){
        $req->validate([
            'user' => 'required|exists:mysql_second.employee__personal__details,employee_id',
            'joining_date' => 'required',
            'location' => 'required',
            'department' => 'required',
            'designation' => 'required',
        ]);

        
        $insert = Employee_Organization_Detail::on('mysql_second')->create([
            'emp_id' =>  $req->user,
            "joining_date" => $req->joining_date,
            "joining_location" =>  $req->location,
            "department" => $req->department,
            "designation" => $req->designation,
        ]);

        // $data = Employee_Organization_Detail::on('mysql_second')->with('Withs','Location')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Employee Organization Details Added Successfully',
            // "data" => $data,
        ], 200);  
    } // End Method



    // Update Employee Organization Details
    public function Update(Request $req){
        $data = Employee_Organization_Detail::on('mysql_second')->where('emp_id', $req->emp_id)->first();

        $req->validate([
            'joining_date' => 'required',
            'location' => 'required',
            'department' => 'required',
            'designation' => 'required',
        ]);
        
        $update = Employee_Organization_Detail::on('mysql_second')->findOrFail($req->id)->update([
            "joining_date" => $req->joining_date,
            "joining_location" =>  $req->location,
            "department" => $req->department,
            "designation" => $req->designation,
            'updated_at' => now()
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Employee Organization Details Updated Successfully',
                // "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method



    // Delete Employee Organization Details
    public function Delete(Request $req){
        Employee_Organization_Detail::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Employee Organization Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Show Employee Organization Details Grid
    public function Grid(Request $req){
        $employeeorganization = Employee_Organization_Detail::with('personalDetail')->where('emp_id', $req->id)->paginate(15);
        
        return response()->json([
            'status' => true,
            'data'=>view('hr.employee_info.organization_details.grid', compact('employeeorganization'))->render(),
        ]);
    } // End Method
}
