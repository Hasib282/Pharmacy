<?php

namespace App\Http\Controllers\API\Backend\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Transaction_Main_Head;

class MainHeadController extends Controller
{
    // Show All MainHeads
    public function Show(Request $req){
        $data = Transaction_Main_Head::on('mysql')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert MainHeads
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required|unique:mysql.transaction__main__heads,type_name',
        ]);

        $insert = Transaction_Main_Head::on('mysql')->create([
            "type_name" => $req->name,
        ]);

        $data = Transaction_Main_Head::on('mysql')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'MainHead Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method



    // Update MainHeads
    public function Update(Request $req){
        $data = Transaction_Main_Head::on('mysql')->findOrFail($req->id);
        
        $req->validate([
            "name" => ['required',Rule::unique('mysql.transaction__main__heads', 'type_name')->ignore($data->id)],
        ]);

        $update = $data->update([
            "type_name" => $req->name,
            "updated_at" => now()
        ]);

        $updatedData = Transaction_Main_Head::on('mysql')->findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'MainHead Updated Successfully',
                "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method



    // Delete MainHeads
    public function Delete(Request $req){
        Transaction_Main_Head::on('mysql')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'MainHead Deleted Successfully',
        ], 200); 
    } // End Method



    // Delete MainHeads Status
    public function DeleteStatus(Request $req){
        $data = Transaction_Main_Head::on('mysql')->findOrFail($req->id);
        $data->update(['status' => $data->status == 0 ? 1 : 0]);
        
        $updatedData = Transaction_Main_Head::on('mysql')->findOrFail($req->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'MainHead Deleted Successfully',
            'updatedData' => $updatedData
        ], 200);
    } // End Method



    // Get Transaction Main Head
    public function Get(){
        $data = Transaction_Main_Head::on('mysql')->select('id','type_name')->get();
        return response()->json([
            'status' => true,
            'data'=> $data,
        ],200);
    } // End Method
}
