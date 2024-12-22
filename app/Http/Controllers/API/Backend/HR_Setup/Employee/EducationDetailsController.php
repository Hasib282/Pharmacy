<?php

namespace App\Http\Controllers\API\Backend\HR_Setup\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User_Info;
use App\Models\Transaction_With;
use App\Models\Employee_Education_Detail;
use App\Models\Employee_Personal_Detail;

class EducationDetailsController extends Controller
{
    // Show All Employee Education Details
    public function ShowAll(Request $req){
        $employee = User_Info::on('mysql_second')->with('Withs','Location')->where('user_role', 3)->orderBy('added_at','asc')->paginate(15);
        $tranwith = Transaction_With::on('mysql_second')->where('user_role', 3)->get();
        return response()->json([
            'status'=> true,
            'data' => $employee,
            'tranwith' => $tranwith,
        ], 200);
    } // End Method



    // Insert Employee Education Details
    public function Insert(Request $req){
        $req->validate([
            'user' => 'required',
            'level_of_education' => 'required|string|max:255',
            'degree_title' => 'required|string|max:255',
            'group' => 'nullable|in:Science,Commerce,Arts',
            'institution_name' => 'required|string|max:255',
            'result' => 'required|in:First Division/Class,Second Division/Class,Third Division/Class,Grade',
            'scale' => 'nullable|numeric',
            'cgpa' => 'nullable|numeric',
            'marks' => 'nullable|numeric',
            'batch' => 'nullable|numeric',
            'passing_year' => 'required|numeric',
        ]);
    
        // Create a new Education instance and save the data
        Employee_Education_Detail::on('mysql_second')->insert([
            'emp_id' => $req->user,
            'level_of_education' => $req->level_of_education,
            'degree_title' => $req->degree_title,
            'group' => $req->group,
            'institution_name' => $req->institution_name,
            'result' => $req->result,
            'scale' => $req->scale,
            'cgpa' => $req->cgpa,
            'marks' => $req->marks,
            'batch' => $req->batch,
            'passing_year' => $req->passing_year,
        ]);
        
        return response()->json([
            'status'=> true,
            'message' => 'Employee Education Details Added Successfully'
        ], 200);  
    } // End Method



    // Edit Employee Education Details
    public function Edit(Request $req){
        $employee = Employee_Education_Detail::on('mysql_second')->where('id', $req->id)->first();
        $tranwith = Transaction_With::on('mysql_second')->where('user_role', 3)->get();
        return response()->json([
            'status'=> true,
            'employee'=>$employee,
            'tranwith'=>$tranwith,
        ], 200);
    } // End Method



    // Update Employee Education Details
    public function Update(Request $req){
        $req->validate([
            'level_of_education' => 'required|string|max:255',
            'degree_title' => 'required|string|max:255',
            'group' => 'nullable|in:Science,Arts,Commerce',
            'institution_name' => 'required|string|max:255',
            'result' => 'required|in:First Division/Class,Second Division/Class,Third Division/Class,Grade',
            'scale' => 'nullable|numeric',
            'cgpa' => 'nullable|numeric',
            'marks' => 'nullable|numeric',
            'batch' => 'nullable|numeric',
            'passing_year' => 'required|numeric',
        ]);

        $employee = Employee_Education_Detail::on('mysql_second')->findOrFail($req->id);
        

        $update = Employee_Education_Detail::on('mysql_second')->findOrFail($req->id)->update([
            'level_of_education' => $req->level_of_education,
            'degree_title' => $req->degree_title,
            'group' => $req->group,
            'institution_name' => $req->institution_name,
            'result' => $req->result,
            'scale' => $req->scale,
            'cgpa' => $req->cgpa,
            'marks' => $req->marks,
            'batch' => $req->batch,
            'passing_year' => $req->passing_year,
            'updated_at' => now()
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Employee Education Details Updated Successfully',
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



    // Search Employee Education Details
    public function Search(Request $req){
        $query = User_Info::on('mysql_second')->with('Withs','Location')->where('user_role', 3); // Base query

        if ($req->filled('search') && $req->searchOption) {
            switch ($req->searchOption) {
                case 1: // Search By Employee Name Or Id
                    $query->where('user_name', 'like', '%' . $req->search . '%')
                        ->orWhere('id', 'like', '%' . $req->search . '%')
                        ->orderBy('user_name');
                    break;

                case 2: // Search By Email
                    $query->where('user_email', 'like', '%' . $req->search . '%')
                        ->orderBy('user_email');
                    break;

                case 3: // Search By Phone
                    $query->where('user_phone', 'like', '%' . $req->search . '%')
                        ->orderBy('user_phone');
                    break;

                case 4: // Search By Location
                    $query->whereHas('Location', function ($q) use ($req) {
                            $q->where('upazila', 'like', '%' . $req->search . '%');
                            $q->orderBy('upazila');
                        });
                    break;

                case 5: // Search By Address
                    $query->where('address', 'like', '%' . $req->search . '%')
                        ->orderBy('address');
                    break;

                case 6: // Search By Date Of Birth
                    $query->where('dob', 'like', '%' . $req->search . '%')
                        ->orderBy('dob');
                    break;

                case 7: // case 7
                    $query->where('nid', 'like', '%' . $req->search . '%')
                        ->orderBy('nid');
                    break;

                case 8: // Search By Employee Type
                    $query->whereHas('Withs', function ($q) use ($req) {
                            $q->where('tran_with_name', 'like', '%' . $req->search . '%');
                            $q->orderBy('tran_with_name');
                        });
                    break;
            }
        }

        $employee = $query->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $employee,
        ], 200);
    } // End Method



    // Show Employee Education Details
    public function Details(Request $req){
        $employeeeducation = Employee_Education_Detail::with('personalDetail')->where('emp_id', $req->id)->get();
        $personaldetail = Employee_Personal_Detail::where('employee_id', $req->id)->get();

        return response()->json([
            'status' => true,
            'data'=>view('hr.employee_info.education_details.details', compact('employeeeducation', 'personaldetail'))->render(),
        ]);
    } // End Method



    // Employee Education Details Grid
    public function Grid(Request $req){
        $employeeeducation = Employee_Education_Detail::with('personalDetail')->where('emp_id', $req->id)->paginate(15);
        
        return response()->json([
            'status' => true,
            'data'=>view('hr.employee_info.education_details.detailsEducation', compact('employeeeducation'))->render(),
        ]);
    } // End Method
}
