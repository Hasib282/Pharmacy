<?php

namespace App\Http\Controllers\API\Backend\Users\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Department;

class DepartmentController extends Controller
{
    // Show All Departments
    public function ShowAll(Request $req){
        $department = Department::on('mysql_second')->orderBy('added_at','asc')->paginate(15);
        return response()->json([
            'status'=> true,
            'data' => $department,
        ], 200);
    } // End Method



    // Insert Departments
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required|unique:mysql_second.departments,name'
        ]);

        Department::on('mysql_second')->insert([
            "name" => $req->name,
        ]);
        
        return response()->json([
            'status'=> true,
            'message' => 'Department Added Successfully'
        ], 200);  
    } // End Method



    // Edit Departments
    public function Edit(Request $req){
        $department = Department::on('mysql_second')->findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'department'=> $department,
        ], 200);
    } // End Method



    // Update Departments
    public function Update(Request $req){
        $department = Department::on('mysql_second')->findOrFail($req->id);

        $req->validate([
            "name" => ['required',Rule::unique('mysql_second.departments', 'name')->ignore($department->id)],
        ]);

        $update = Department::on('mysql_second')->findOrFail($req->id)->update([
            "name" => $req->name,
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
        Department::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Department Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Departments
    public function Search(Request $req){
        $department = Department::on('mysql_second')
        ->where('name', 'like', $req->search.'%')
        ->orderBy('name','asc')
        ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $department,
        ], 200);
    } // End Method


    // Get Departments
    public function Get(Request $req){
        $departments = Department::on('mysql_second')
        ->where('name', 'like', $req->department.'%')
        ->orderBy('name','asc')
        ->take(10)
        ->get();


        if($departments->count() > 0){
            $list = "";
            foreach($departments as $index => $department) {
                $list .= '<li tabindex="'.($index + 1).'" data-id="'.$department->id.'">'.$department->name.'</li>';
            }
        }
        else{
            $list = '<li>No Data Found</li>';
        }

        return $list;
    } // End Method
}