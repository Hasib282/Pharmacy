<?php

namespace App\Http\Controllers\API\Backend\Users\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User_Info;
use App\Models\Employee_Experience_Detail;

class ExperienceDetailsController extends Controller
{
    // Show All Employee Experience Details
    public function Show(Request $req){
        $data = User_Info::on('mysql_second')->with('Withs','Location')->where('user_role', 3)->orderBy('added_at','asc')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Employee Experience Details
    public function Insert(Request $req){
        $req->validate([
            'user' => 'required|exists:mysql_second.employee__personal__details,employee_id',
            'company_name.*' => 'required',
            'designation.*' => 'required',
            'department.*' => 'required',
            'company_location.*' => 'required',
            'start_date.*' => 'nullable',
            'end_date.*' => 'nullable|after:start_date.*',
            
        ],
        [
            'company_name.*.required' => 'This field is required',
            'designation.*.required' => 'This field is required',
            'department.*.required' => 'This field is required',
            'company_location.*.required' => 'This field is required',
            'start_date.*.required' => 'This field is required',
            'end_date.*.required' => 'This field is required',
        ]);


        $experienceDetails = [];
        foreach ($req->company_name as $key => $value) {
            $experienceDetails[] = [
                'emp_id' =>  $req->user,
                "company_name" => $req->company_name[$key],
                "designation" =>  $req->designation[$key],
                "department" => $req->department[$key],
                "company_location" => $req->company_location[$key],
                "start_date" => $req->start_date[$key] ?? null,
                "end_date" => $req->end_date[$key] ?? null,
            ];
        }

        $insert = Employee_Experience_Detail::on('mysql_second')->Insert($experienceDetails);

        return response()->json([
            'status'=> true,
            'message' => 'Employee Experience Details Added Successfully',
        ], 200);  
    } // End Method



    // Edit Employee Education Details
    public function Edit(Request $req){
        $data = Employee_Experience_Detail::on('mysql_second')->findOrFail($req->id);
        return response()->json([
            'status'=> true,
            "data" => $data,
        ], 200);  
    }



    // Update Employee Experience Details
    public function Update(Request $req){
        $data = Employee_Experience_Detail::on('mysql_second')->findOrFail($req->id);

        $req->validate([
            'company_name' => 'required',
            'designation' => 'required',
            'department' => 'required',
            'company_location' => 'required',
            'start_date' => 'nullable',
            'end_date' => 'nullable|after:start_date',
        ]);

        $update = $data->update([
            "company_name" => $req->company_name,
            "designation" =>  $req->designation,
            "department" => $req->department,
            "company_location" => $req->company_location,
            "start_date" => $req->start_date,
            "end_date" => $req->end_date,
            'updated_at' => now()
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Employee Experience Details Updated Successfully',
                // "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method



    // Delete Employee Experience Details
    public function Delete(Request $req){
        Employee_Experience_Detail::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Employee Experience Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Delete Companies Status
    public function DeleteStatus(Request $req){
        $data = Company_Details::on('mysql')->findOrFail($req->id);
        $data->update(['status' => $data->status == 0 ? 1 : 0]);
        
        $updatedData = Company_Details::on('mysql')->with('Type')->findOrFail($req->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Company Details Deleted Successfully',
            'updatedData' => $updatedData
        ], 200);
    } // End Method
    


    // Show Employee Experience Grid
    public function Grid(Request $req){
        $employeeexperience = Employee_Experience_Detail::with('personalDetail')->where('emp_id', $req->id)->paginate(15);
        
        return response()->json([
            'status' => true,
            'data'=>view('hr.employee_info.experience_details.grid', compact('employeeexperience'))->render(),
        ]);
    } // End Method
}
