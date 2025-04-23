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
        $data = Department::on('mysql_second')->orderBy('added_at','asc')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Departments
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required|unique:mysql_second.departments,name'
        ]);

        $insert = Department::on('mysql_second')->create([
            "name" => $req->name,
        ]);

        $data = Department::on('mysql_second')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Department Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method



    // Edit Departments
    public function Edit(Request $req){
        $data = Department::on('mysql_second')->findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'data'=> $data,
        ], 200);
    } // End Method



    // Update Departments
    public function Update(Request $req){
        $data = Department::on('mysql_second')->findOrFail($req->id);

        $req->validate([
            "name" => ['required',Rule::unique('mysql_second.departments', 'name')->ignore($data->id)],
        ]);

        $update = $data->update([
            "name" => $req->name,
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Department Updated Successfully',
                "updatedData" => $updatedData,
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
        $data = Department::on('mysql_second')
        ->where('name', 'like', $req->search.'%')
        ->orderBy('name','asc')
        ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method


    
    // Get Departments
    public function Get(Request $req){
        $data = Department::on('mysql_second')
        ->where('name', 'like', $req->department.'%')
        ->orderBy('name','asc')
        ->take(10)
        ->get();

        $list = "<ul>";
            if($data->count() > 0){
                foreach($data as $index => $item) {
                    $list .= '<li tabindex="'.($index + 1).'" data-id="'.$item->id.'">'.$item->name.'</li>';
                }
            }
            else{
                $list .= '<li>No Data Found</li>';
            }
        $list .= "<ul>";

        return $list;
    } // End Method
}