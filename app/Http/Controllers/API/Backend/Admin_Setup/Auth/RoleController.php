<?php

namespace App\Http\Controllers\API\Backend\Admin_Setup\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Role;

class RoleController extends Controller
{
    // Show All User Roles
    public function ShowAll(Request $req){
        $roles = Role::whereNotIn('id', ['1'])->orderBy('added_at','asc')->paginate(15);
        return response()->json([
            'status'=> true,
            'data' => $roles,
        ], 200);
    } // End Method



    // Insert User Roles
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required|unique:roles,name',
        ]);

        Role::insert([
            "name" => $req->name,
        ]);
        
        return response()->json([
            'status'=> true,
            'message' => 'User Role Added Successfully'
        ], 200);  
    } // End Method



    // Edit User Roles
    public function Edit(Request $req){
        $roles = Role::findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'roles'=> $roles,
        ], 200);
    } // End Method



    // Update User Roles
    public function Update(Request $req){
        $roles = Role::findOrFail($req->id);

        $req->validate([
            "name" => ['required',Rule::unique('roles', 'name')->ignore($roles->id)],
        ]);

        $update = Role::findOrFail($req->id)->update([
            "name" => $req->name
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'User Role Updated Successfully',
            ], 200); 
        }
    } // End Method



    // Delete User Roles
    public function Delete(Request $req){
        Role::whereNotIn('id', ['1'])->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'User Role Deleted Successfully',
        ], 200); 
    } // End Method



    // Search User Roles
    public function Search(Request $req){
        $roles = Role::whereNotIn('id', ['1'])->where('name', 'like', '%'.$req->search.'%')
        ->orderBy('name','asc')
        ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $roles,
        ], 200);
    } // End Method



    // Get Roles
    public function Get(){
        $roles = Role::whereNotIn('id', ['1'])
        ->where('name', 'like', '%'.$req->role.'%')
        ->orderBy('name')
        ->take(10)
        ->get();

        return response()->json([
            'status' => true,
            'roles'=> $roles,
        ]);
    } // End Method
}
