<?php

namespace App\Http\Controllers\API\Backend\Users\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User_Info;
use App\Models\Employee_Education_Detail;
use App\Models\Employee_Personal_Detail;

class EducationDetailsController extends Controller
{
    // Show All Employee Education Details
    public function Show(Request $req){
        $data = User_Info::on('mysql_second')->with('Withs','Location')->where('user_role', 3)->orderBy('added_at','asc')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Employee Education Details
    public function Insert(Request $req){
        $req->validate([
            'user' => 'required|exists:mysql_second.employee__personal__details,employee_id',
            'degree.*' => 'required|string|max:255',
            'group.*' => 'nullable|in:Science,Commerce,Arts',
            'institution.*' => 'required|string|max:255',
            'result.*' => 'required|in:First Division/Class,Second Division/Class,Third Division/Class,Grade',
            'scale.*' => 'nullable|numeric',
            'cgpa.*' => 'nullable|numeric',
            'marks.*' => 'nullable|numeric',
            'batch.*' => 'numeric',
        ],
        [
            'degree.*.required' => "This field is required",
            'group.*.required' => "This field is required",
            'institution.*.required' => "This field is required",
            'result.*.required' => "This field is required",
            'scale.*.required' => "This field is required",
            'cgpa.*.required' => "This field is required",
            'marks.*.required' => "This field is required",
            'batch.*.required' => "This field is required",
        ]);



        $educationDetails = [];
        foreach ($req->degree as $key => $value) {
            $educationDetails[] = [
                'emp_id' => $req->user,
                'degree' => $req->degree[$key],
                'group' => $req->group[$key] ?? null,
                'institution' => $req->institution[$key],
                'result' => $req->result[$key],
                'scale' => $req->scale[$key] ?? null,
                'cgpa' => $req->cgpa[$key] ?? null,
                'marks' => $req->marks[$key] ?? null,
                'batch' => $req->batch[$key] ?? null,
            ];
        }
    
        $insert = Employee_Education_Detail::on('mysql_second')->create($educationDetails);

        // $data = Employee_Education_Detail::on('mysql_second')->with('Withs','Location')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Employee Education Details Added Successfully',
            // "data" => $data,
        ], 200);  
    } // End Method



    // Update Employee Education Details
    public function Update(Request $req){
        $data = Employee_Education_Detail::on('mysql_second')->findOrFail($req->id);

        $req->validate([
            'degree' => 'required|string|max:255',
            'group' => 'nullable|in:Science,Arts,Commerce',
            'institution' => 'required|string|max:255',
            'result' => 'required|in:First Division/Class,Second Division/Class,Third Division/Class,Grade',
            'scale' => 'nullable|numeric',
            'cgpa' => 'nullable|numeric',
            'marks' => 'nullable|numeric',
            'batch' => 'numeric',
        ]);

        

        $update = $data->update([
            'degree' => $req->degree,
            'group' => $req->group,
            'institution' => $req->institution,
            'result' => $req->result,
            'scale' => $req->scale,
            'cgpa' => $req->cgpa,
            'marks' => $req->marks,
            'batch' => $req->batch,
            'updated_at' => now()
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Employee Education Details Updated Successfully',
                // "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method



    // Delete Employee Education Details
    public function Delete(Request $req){
        Employee_Education_Detail::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Employee Education Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Employee Education Details Grid
    public function Grid(Request $req){
        $employeeeducation = Employee_Education_Detail::with('personalDetail')->where('emp_id', $req->id)->paginate(15);
        
        return response()->json([
            'status' => true,
            'data'=>view('hr.employee_info.education_details.grid', compact('employeeeducation'))->render(),
        ]);
    } // End Method
}
