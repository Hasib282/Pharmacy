<?php

namespace App\Http\Controllers\API\Backend\HR_Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Department_Info;
use App\Models\Designation;

class DesignationController extends Controller
{
    // Show All Designations
    public function ShowAll(Request $req){
        $designations = Designation::with('Department:id,dept_name')->orderBy('added_at','asc')->paginate(15);
        return response()->json([
            'status'=> true,
            'data' => $designations,
        ], 200);
    } // End Method



    // Insert Designations
    public function Insert(Request $req){
        $req->validate([
            "designations" => 'required|unique:designations,designation',
            "department" => 'required|numeric'
        ]);

        Designation::insert([
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
        $designations = Designation::with('Department:id,dept_name')->findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'designations'=> $designations,
        ], 200);
    } // End Method



    // Update Designations
    public function Update(Request $req){
        $designations = Designation::findOrFail($req->id);

        $req->validate([
            "designations" => ['required',Rule::unique('designations', 'designation')->ignore($designations->id)],
            "department"  => 'required|numeric'
        ]);

        $update = Designation::findOrFail($req->id)->update([
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
        Designation::findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Designation Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Designations
    public function Search(Request $req){
        if($req->searchOption == 1){
            $designations = Designation::with('Department:id,dept_name')->where('designation', 'like', '%'.$req->search.'%')
            ->orderBy('designation','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $designations = Designation::with('Department:id,dept_name')
            ->whereHas('Department', function ($query) use ($req) {
                $query->where('dept_name', 'like', '%' . $req->search . '%');
                $query->orderBy('dept_name','asc');
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
        if($req->department != ""){
            $designations = Designation::where('designation', 'like', '%'.$req->designation.'%')
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
                $list = '<li>No Data Found</li>';
            }
            return $list;
        }
        else{
            return $list = "";
        }
    } // End Method
}
