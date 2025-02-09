<?php

namespace App\Http\Controllers\API\Backend\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Transaction_Main_Head;

class MainHeadController extends Controller
{
    // Show All MainHeads
    public function ShowAll(Request $req){
        $mainhead = Transaction_Main_Head::on('mysql')->orderBy('added_at')->paginate(15);
        return response()->json([
            'status'=> true,
            'data' => $mainhead,
        ], 200);
    } // End Method



    // Insert MainHeads
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required|unique:mysql.transaction__main__heads,type_name',
        ]);

        Transaction_Main_Head::on('mysql')->insert([
            "type_name" => $req->name,
        ]);
        
        return response()->json([
            'status'=> true,
            'message' => 'MainHead Added Successfully'
        ], 200);  
    } // End Method



    // Edit MainHeads
    public function Edit(Request $req){
        $mainhead = Transaction_Main_Head::on('mysql')->findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'mainhead'=> $mainhead,
        ], 200);
    } // End Method



    // Update MainHeads
    public function Update(Request $req){
        $mainhead = Transaction_Main_Head::on('mysql')->findOrFail($req->id);
        
        $req->validate([
            "name" => ['required',Rule::unique('mysql.transaction__main__heads', 'type_name')->ignore($mainhead->id)],
        ]);

        $update = Transaction_Main_Head::findOrFail($req->id)->update([
            "type_name" => $req->name,
            "updated_at" => now()
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'MainHead Updated Successfully',
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



    // Search MainHeads
    public function Search(Request $req){
        $mainhead = Transaction_Main_Head::on('mysql')->where('type_name', 'like', $req->search.'%')
        ->orderBy('type_name')
        ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $mainhead,
        ], 200);
    } // End Method



    // Get Transaction Main Head
    public function Get(){
        $mainhead = Transaction_Main_Head::on('mysql')->orderBy('added_at')->paginate(15);
        return response()->json([
            'status' => true,
            'mainhead'=> $mainhead,
        ]);
    } // End Method
}
