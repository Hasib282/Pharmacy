<?php

namespace App\Http\Controllers\API\Backend\Users\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Role;

class RoleController extends Controller
{
    // Show All User Roles
    public function ShowAll(Request $req){
        $data = Role::on('mysql')->orderBy('added_at','asc')->paginate(15);
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert User Roles
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required|unique:mysql.roles,name',
        ]);

        Role::on('mysql')->insert([
            "name" => $req->name,
        ]);
        
        return response()->json([
            'status'=> true,
            'message' => 'User Role Added Successfully'
        ], 200);  
    } // End Method



    // Edit User Roles
    public function Edit(Request $req){
        $data = Role::on('mysql')->findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'data'=> $data,
        ], 200);
    } // End Method



    // Update User Roles
    public function Update(Request $req){
        $data = Role::on('mysql')->findOrFail($req->id);

        $req->validate([
            "name" => ['required',Rule::unique('mysql.roles', 'name')->ignore($data->id)],
        ]);

        $update = $data->update([
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
        Role::on('mysql')->whereNotIn('id', ['1'])->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'User Role Deleted Successfully',
        ], 200); 
    } // End Method



    // Search User Roles
    public function Search(Request $req){
        $data = Role::on('mysql')->where('name', 'like', $req->search.'%')
        ->orderBy('name','asc')
        ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Get Roles
    public function Get(){
        $data = Role::on('mysql')
        ->whereNotIn('id', ['1'])
        ->where('name', 'like', $req->role.'%')
        ->orderBy('name')
        ->take(10)
        ->get();

        return response()->json([
            'status' => true,
            'data'=> $data,
        ]);
    } // End Method
}
