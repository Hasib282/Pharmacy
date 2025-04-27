<?php

namespace App\Http\Controllers\API\Backend\Users\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Designation;

class DesignationController extends Controller
{
    // Show All Designations
    public function Show(Request $req){
        $data = Designation::on('mysql_second')
        ->with('Department:id,name')
        ->orderBy('added_at','asc')
        ->get();
        
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Designations
    public function Insert(Request $req){
        $req->validate([
            "designations" => 'required|unique:mysql_second.designations,designation',
            "department" => 'required|exists:mysql_second.departments,id'
        ]);

        $insert = Designation::on('mysql_second')->create([
            "designation" => $req->designations,
            "dept_id" => $req->department,
        ]);
        
        $data = Designation::on('mysql_second')->with('Department:id,name')->findOrFail($insert->id);

        return response()->json([
            'status'=> true,
            'message' => 'Designation Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method



    // Update Designations
    public function Update(Request $req){
        $data = Designation::on('mysql_second')->findOrFail($req->id);

        $req->validate([
            "designations" => ['required',Rule::unique('mysql_second.designations', 'designation')->ignore($data->id)],
            "department"  => 'required|exists:mysql_second.departments,id'
        ]);

        $update = $data->update([
            "designation" => $req->designations,
            "dept_id" => $req->department,
            "updated_at" => now()
        ]);

        $updatedData = Designation::on('mysql_second')->with('Department:id,name')->findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Designation Updated Successfully',
                "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method



    // Delete Designations
    public function Delete(Request $req){
        Designation::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Designation Deleted Successfully',
        ], 200); 
    } // End Method



    // Get Designation By Department
    public function Get(Request $req){
        $data = Designation::on('mysql_second')
        ->where('designation', 'like', $req->designation.'%')
        ->where('dept_id', $req->department)
        ->orderBy('designation','asc')
        ->take(10)
        ->get();

        $list = "<ul>";
            if($data->count() > 0){
                foreach($data as $index => $item) {
                    $list .= '<li tabindex="'. ($index + 1) .'" data-id="'.$item->id.'">'.$item->designation.'</li>';
                }
            }
            else{
                if($req->department != ""){
                    $list = '<li>No Data Found</li>';
                }
                else{
                    $list .= '<li>Select Department First</li>';
                }
            }
        $list .= "</ul>";

        return $list;
    } // End Method
}
