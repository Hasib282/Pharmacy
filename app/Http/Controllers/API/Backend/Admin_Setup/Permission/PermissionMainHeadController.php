<?php

namespace App\Http\Controllers\API\Backend\Admin_Setup\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Permission_Main_Head;

class PermissionMainHeadController extends Controller
{
    // Show All Permission Mainheads
    public function ShowAll(Request $req){
        $permissionMainhead = Permission_Main_Head::orderBy('created_at','asc')->paginate(15);
        return response()->json([
            'status'=> true,
            'data' => $permissionMainhead,
        ], 200);
    } // End Method



    // Insert Permission Mainheads
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required|unique:permission__main__heads,name',
        ]);

        Permission_Main_Head::insert([
            "name" => $req->name,
        ]);
        
        return response()->json([
            'status'=> true,
            'message' => 'Permission Mainheads Added Successfully'
        ], 200);  
    } // End Method



    // Edit Permission Mainheads
    public function Edit(Request $req){
        $permissionMainhead = Permission_Main_Head::findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'permissionMainhead'=> $permissionMainhead,
        ], 200);
    } // End Method



    // Update Permission Mainheads
    public function Update(Request $req){
        $permission = Permission_Main_Head::findOrFail($req->id);

        $req->validate([
            "name" => ['required',Rule::unique('permission__main__heads', 'name')->ignore($req->id)],
        ]);

        $update = Permission_Main_Head::findOrFail($req->id)->update([
            "name" => $req->name
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Permission Mainheads Updated Successfully',
            ], 200); 
        }
    } // End Method



    // Delete Permission Mainheads
    public function Delete(Request $req){
        Permission_Main_Head::findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Permission Mainheads Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Permission Mainheads
    public function Search(Request $req){
        $permissionMainhead = Permission_Main_Head::where('name', 'like', '%'.$req->search.'%')
        ->orderBy('name')
        ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $permissionMainhead,
        ], 200);
    } // End Method



    // Get Permission Mainheads
    public function Get(){
        $permissionMainhead = Permission_Main_Head::where('name', 'like', '%'.$req->role.'%')
        ->orderBy('name')
        ->take(10)
        ->get();

        return response()->json([
            'status' => true,
            'permissionMainhead'=> $permissionMainhead,
        ]);
    } // End Method
}
