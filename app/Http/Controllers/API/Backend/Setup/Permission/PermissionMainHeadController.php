<?php

namespace App\Http\Controllers\API\Backend\Setup\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Permission_Main_Head;

class PermissionMainHeadController extends Controller
{
    // Show All Permission Mainheads
    public function ShowAll(Request $req){
        $data = Permission_Main_Head::on('mysql')->orderBy('created_at','asc')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Permission Mainheads
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required|unique:mysql.permission__main__heads,name',
        ]);

        $insert = Permission_Main_Head::on('mysql')->create([
            "name" => $req->name,
        ]);

        $data = Permission_Main_Head::on('mysql')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Permission Mainheads Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method



    // Edit Permission Mainheads
    public function Edit(Request $req){
        $data = Permission_Main_Head::on('mysql')->findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'data'=> $data,
        ], 200);
    } // End Method



    // Update Permission Mainheads
    public function Update(Request $req){
        $data = Permission_Main_Head::on('mysql')->findOrFail($req->id);

        $req->validate([
            "name" => ['required',Rule::unique('mysql.permission__main__heads', 'name')->ignore($req->id)],
        ]);

        $update = $data->update([
            "name" => $req->name
        ]);

        $updatedData = Permission_Main_Head::on('mysql')->findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Permission Mainheads Updated Successfully',
                "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method



    // Delete Permission Mainheads
    public function Delete(Request $req){
        Permission_Main_Head::on('mysql')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Permission Mainheads Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Permission Mainheads
    public function Search(Request $req){
        $data = Permission_Main_Head::on('mysql')
        ->where('name', 'like', $req->search.'%')
        ->orderBy('name')
        ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Get Permission Mainheads
    public function Get(){
        $data = Permission_Main_Head::on('mysql')->orderBy('created_at','asc')->get();
        return response()->json([
            'status' => true,
            'data'=> $data,
        ]);
    } // End Method
}
