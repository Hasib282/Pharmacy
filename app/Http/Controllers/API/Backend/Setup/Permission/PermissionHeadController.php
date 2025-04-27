<?php

namespace App\Http\Controllers\API\Backend\Setup\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Permission_Head;
use App\Models\Permission_Main_Head;

class PermissionHeadController extends Controller
{
    // Show All Permission Head
    public function Show(Request $req){
        $data = Permission_Head::on('mysql')->with('mainhead')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Permission Head
    public function Insert(Request $req){
        $req->validate([
            'mainhead' => 'required|exists:mysql.permission__main__heads,id',
            "name" => 'required|unique:mysql.permission__heads,name',
        ]);

        $insert = Permission_Head::on('mysql')->create([
            "permission_mainhead" => $req->mainhead,
            "name" => $req->name,
        ]);

        $data = Permission_Head::on('mysql')->with('mainhead')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Permission Head Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method



    // Update Permission Head
    public function Update(Request $req){
        $data = Permission_Head::on('mysql')->findOrFail($req->id);

        $req->validate([
            'mainhead' => 'required|exists:mysql.permission__main__heads,id',
            "name" => ['required',Rule::unique('mysql.permission__heads', 'name')->ignore($req->id)],
        ]);

        $update = $data->update([
            "permission_mainhead" => $req->mainhead,
            "name" => $req->name
        ]);

        $updatedData = Permission_Head::on('mysql')->with('mainhead')->findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Permission Head Updated Successfully',
                "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method



    // Delete Permission Head
    public function Delete(Request $req){
        Permission_Head::on('mysql')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Permission Head Deleted Successfully',
        ], 200); 
    } // End Method
}
