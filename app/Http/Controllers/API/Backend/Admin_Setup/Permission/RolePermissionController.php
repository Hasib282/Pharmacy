<?php

namespace App\Http\Controllers\API\Backend\Admin_Setup\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Role;
use App\Models\Permission_Role;
use App\Models\Permission_Head;

class RolePermissionController extends Controller
{
    // Show All Role Permissions
    public function ShowAll(Request $req){
        $rolepermission = Role::whereNotIn('id', ['1'])->with('permissions')->orderBy('id')->get();
        return response()->json([
            'status'=> true,
            'data' => $rolepermission,
        ], 200);
    } // End Method



    // Edit Role Permissions
    public function Edit(Request $req){
        $role = Role::whereNotIn('id', ['1'])->where('id',$req->id)->first();
        $rolepermission = Permission_Role::where('role_id', $req->id)->pluck('permission_id')->toArray();
        $permissions = Permission_Head::with('mainhead')
        ->orderBy('permission_mainhead')
        ->get()
        ->groupBy('permission_mainhead');

        return response()->json([
            'status'=> true,
            'permissions'=>$permissions,
            'rolepermission'=>$rolepermission,
            'role'=>$role
        ], 200);
    } // End Method



    // Update Role Permissions
    public function Update(Request $req){
        $role = Role::whereNotIn('id', ['1'])->findOrFail($req->role);

        $req->validate([
            'role' => 'required',
            'permissions' => 'array',
            'permissions.*' => 'integer|exists:permission__heads,id',
        ]);

        $role->permissions()->sync($req->permissions);
        
        return response()->json([
            'status'=> true,
            'message' => 'Role Permissions Added Successfully'
        ], 200);  
    } // End Method



    // Search Role Permissions
    public function Search(Request $req){
        $rolepermission = Role::whereNotIn('id', ['1'])
        ->where('name', 'like', '%'.$req->search.'%')
        ->with('permissions')
        ->orderBy('name')
        ->get();
        
        return response()->json([
            'status' => true,
            'data' => $rolepermission,
        ], 200);
    } // End Method
}
