<?php

namespace App\Http\Controllers\API\Backend\HR_Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Department_Info;

class DepartmentController extends Controller
{
    // Show All Departments
    public function ShowAll(Request $req){
        $department = Department_Info::on('mysql')->orderBy('added_at','asc')->paginate(15);
        return response()->json([
            'status'=> true,
            'data' => $department,
        ], 200);
    } // End Method



    // Insert Departments
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required|unique:mysql.department__infos,dept_name'
        ]);

        Department_Info::on('mysql')->insert([
            "dept_name" => $req->name,
        ]);
        
        return response()->json([
            'status'=> true,
            'message' => 'Department Added Successfully'
        ], 200);  
    } // End Method



    // Edit Departments
    public function Edit(Request $req){
        $department = Department_Info::on('mysql')->findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'department'=> $department,
        ], 200);
    } // End Method



    // Update Departments
    public function Update(Request $req){
        $department = Department_Info::on('mysql')->findOrFail($req->id);

        $req->validate([
            "name" => ['required',Rule::unique('mysql.department__infos', 'dept_name')->ignore($department->id)],
        ]);

        $update = Department_Info::on('mysql')->findOrFail($req->id)->update([
            "dept_name" => $req->name,
            "updated_at" => now()
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Department Updated Successfully',
            ], 200); 
        }
    } // End Method



    // Delete Departments
    public function Delete(Request $req){
        Department_Info::on('mysql')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Department Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Departments
    public function Search(Request $req){
        $department = Department_Info::on('mysql')->where('dept_name', 'like', '%'.$req->search.'%')
        ->orderBy('dept_name','asc')
        ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $department,
        ], 200);
    } // End Method


    // Get Departments
    public function Get(Request $req){
        $departments = Department_Info::on('mysql')->where('dept_name', 'like', '%'.$req->department.'%')
        ->orderBy('dept_name','asc')
        ->take(10)
        ->get();


        if($departments->count() > 0){
            $list = "";
            foreach($departments as $index => $department) {
                $list .= '<li tabindex="'.($index + 1).'" data-id="'.$department->id.'">'.$department->dept_name.'</li>';
            }
        }
        else{
            $list = '<li>No Data Found</li>';
        }

        return $list;
    } // End Method
}