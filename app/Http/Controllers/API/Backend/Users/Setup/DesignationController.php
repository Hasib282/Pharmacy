<?php

namespace App\Http\Controllers\API\Backend\Users\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Designation;

class DesignationController extends Controller
{
    // Show All Designations
    public function ShowAll(Request $req){
        $designations = Designation::on('mysql_second')
        ->with('Department:id,name')
        ->orderBy('added_at','asc')
        ->paginate(15);
        return response()->json([
            'status'=> true,
            'data' => $designations,
        ], 200);
    } // End Method



    // Insert Designations
    public function Insert(Request $req){
        $req->validate([
            "designations" => 'required|unique:mysql_second.designations,designation',
            "department" => 'required|exists:mysql_second.departments,id'
        ]);

        Designation::on('mysql_second')->insert([
            "designation" => $req->designations,
            "dept_id" => $req->department,
        ]);
        
        return response()->json([
            'status'=> true,
            'message' => 'Designation Added Successfully'
        ], 200);  
    } // End Method



    // Edit Designations
    public function Edit(Request $req){
        $designations = Designation::on('mysql_second')->with('Department:id,name')->findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'designations'=> $designations,
        ], 200);
    } // End Method



    // Update Designations
    public function Update(Request $req){
        $designations = Designation::on('mysql_second')->findOrFail($req->id);

        $req->validate([
            "designations" => ['required',Rule::unique('mysql_second.designations', 'designation')->ignore($designations->id)],
            "department"  => 'required|exists:mysql_second.departments,id'
        ]);

        $update = Designation::on('mysql_second')->findOrFail($req->id)->update([
            "designation" => $req->designations,
            "dept_id" => $req->department,
            "updated_at" => now()
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Designation Updated Successfully',
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



    // Search Designations
    public function Search(Request $req){
        if($req->searchOption == 1){
            $designations = Designation::on('mysql_second')
            ->with('Department:id,name')
            ->where('designation', 'like', $req->search.'%')
            ->orderBy('designation','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $designations = Designation::on('mysql_second')
            ->with('Department:id,name')
            ->whereHas('Department', function ($query) use ($req) {
                $query->where('name', 'like', $req->search . '%');
                $query->orderBy('name','asc');
            })
            ->paginate(15);
        }
        
        return response()->json([
            'status' => true,
            'data' => $designations,
        ], 200);
    } // End Method



    // Get Designation By Department
    public function Get(Request $req){
        $designations = Designation::on('mysql_second')
        ->where('designation', 'like', $req->designation.'%')
        ->where('dept_id', $req->department)
        ->orderBy('designation','asc')
        ->take(10)
        ->get();

        if($designations->count() > 0){
            $list = "";
            foreach($designations as $index => $designation) {
                $list .= '<li tabindex="'. ($index + 1) .'" data-id="'.$designation->id.'">'.$designation->designation.'</li>';
            }
        }
        else{
            if($req->department != ""){
                $list = '<li>No Data Found</li>';
            }
            else{
                $list = '<li>Select Department First</li>';
            }
        }
        return $list;
        
    } // End Method
}
