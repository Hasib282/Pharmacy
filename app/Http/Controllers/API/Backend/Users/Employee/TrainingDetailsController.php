<?php

namespace App\Http\Controllers\API\Backend\Users\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User_Info;
use App\Models\Employee_Training_Detail;
use App\Models\Employee_Personal_Detail;

class TrainingDetailsController extends Controller
{
    // Show All Employee Training Details
    public function Show(Request $req){
        $data = User_Info::on('mysql_second')->with('Withs','Location')->where('user_role', 3)->orderBy('added_at','asc')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Employee Training Details
    public function Insert(Request $req){
        $req->validate([
            'user' => 'required|exists:mysql_second.employee__personal__details,employee_id',
            'training_title.*' => 'required',
            'country.*' => 'nullable',
            'topic.*' => 'required',
            'institution_name.*' => 'required',
        ],
        [
            'training_title.*.required' => 'This field is required',
            'country.*.required' => 'This field is required',
            'topic.*.required' => 'This field is required',
            'institution_name.*.required' => 'This field is required',
        ]);

        $trainingDetails = [];
        foreach ($req->training_title as $key => $value) {
            $trainingDetails[] = [
                'emp_id' => $req->user,
                'training_title' => $req->training_title[$key],
                'country' => $req->country[$key],
                'topic' => $req->topic[$key],
                'institution_name' => $req->institution_name[$key],
                'start_date' => $req->start_date[$key],
                'end_date' => $req->end_date[$key],
            ];
        }

        $insert = Employee_Training_Detail::on('mysql_second')->Insert($trainingDetails);
        
        return response()->json([
            'status'=> true,
            'message' => 'Employee Training Details Added Successfully',
        ], 200);  
    } // End Method



    // Edit Employee Education Details
    public function Edit(Request $req){
        $data = Employee_Training_Detail::on('mysql_second')->findOrFail($req->id);
        return response()->json([
            'status'=> true,
            "data" => $data,
        ], 200);  
    }



    // Update Employee Training Details
    public function Update(Request $req){
        $data = Employee_Training_Detail::on('mysql_second')->findOrFail($req->id);
        
        $req->validate([
            'training_title' => 'required',
            'country' => 'nullable',
            'topic' => 'required',
            'institution_name' => 'required',
        ]);

        $update = $data->update([
            'training_title' => $req->training_title,
            'country' => $req->country,
            'topic' => $req->topic,
            'institution_name' => $req->institution_name,
            'start_date' => $req->start_date,
            'end_date' => $req->end_date,
            'updated_at' => now()
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Employee Training Details Updated Successfully',
            ], 200); 
        }
    } // End Method



    // Delete Employee Training Details
    public function Delete(Request $req){
        Employee_Training_Detail::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Employee Training Details Deleted Successfully',
            // "updatedData" => $updatedData,
        ], 200); 
    } // End Method



    // Show Employee Training Details Grid
    public function Grid(Request $req){
        $employeetraining = Employee_Training_Detail::with('personalDetail')->where('emp_id', $req->id)->paginate(15);
        
        return response()->json([
            'status' => true,
            'data'=>view('hr.employee_info.training_details.grid', compact('employeetraining'))->render(),
        ]);
    } // End Method
}
