<?php

namespace App\Http\Controllers\API\Backend\Admin_Setup\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Permission_Head;
use App\Models\Permission_Main_Head;

class PermissionHeadController extends Controller
{
    // Show All Permission Head
    public function ShowAll(Request $req){
        $permissions = Permission_Head::with('mainhead')->orderBy('created_at','asc')->paginate(15);
        $permissionMainhead = Permission_Main_Head::orderBy('created_at','asc')->get();
        return response()->json([
            'status'=> true,
            'data' => $permissions,
            'permissionMainhead' => $permissionMainhead,
        ], 200);
    } // End Method



    // Insert Permission Head
    public function Insert(Request $req){
        $req->validate([
            'mainhead' => 'required|numeric',
            "name" => 'required|unique:permission__heads,name',
        ]);

        Permission_Head::insert([
            "permission_mainhead" => $req->mainhead,
            "name" => $req->name,
        ]);
        
        return response()->json([
            'status'=> true,
            'message' => 'Permission Head Added Successfully'
        ], 200);  
    } // End Method



    // Edit Permission Head
    public function Edit(Request $req){
        $permission = Permission_Head::with('mainhead')->findOrFail($req->id);
        $permissionMainhead = Permission_Main_Head::orderBy('created_at','asc')->get();
        return response()->json([
            'status'=> true,
            'permission'=>$permission,
            'permissionMainhead'=>$permissionMainhead,
        ], 200);
    } // End Method



    // Update Permission Head
    public function Update(Request $req){
        $permission = Permission_Head::findOrFail($req->id);

        $req->validate([
            'mainhead' => 'required|numeric',
            "name" => ['required',Rule::unique('permission__heads', 'name')->ignore($req->id)],
        ]);

        $update = Permission_Head::findOrFail($req->id)->update([
            "permission_mainhead" => $req->mainhead,
            "name" => $req->name
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Permission Head Updated Successfully',
            ], 200); 
        }
    } // End Method



    // Delete Permission Head
    public function Delete(Request $req){
        Permission_Head::findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Permission Head Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Permission Head
    public function Search(Request $req){
        $permissions = Permission_Head::with('mainhead')
        ->whereHas('mainhead', function ($query) use ($req) {
            $query->where('id', 'like', '%'.$req->searchHead.'%');
        })
        ->where('name', 'like', '%'.$req->search.'%')
        ->orderBy('name')
        ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $permissions,
        ], 200);
    } // End Method



    // Get Permission Heads
    public function Get(){
        $permissions = Permission_Head::where('name', 'like', '%'.$req->role.'%')
        ->orderBy('name')
        ->take(10)
        ->get();

        return response()->json([
            'status' => true,
            'permissions'=> $permissions,
        ]);
    } // End Method
}
