<?php

namespace App\Http\Controllers\API\Backend\Admin_Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Transaction_With;
use App\Models\Transaction_Main_head;
use App\Models\Role;

class TranWithController extends Controller
{
    // Show All Tranwith
    public function ShowAll(Request $req){
        $tranwith = Transaction_With::with('Role','Type')->orderBy('added_at')->paginate(15);
        $types = Transaction_Main_head::orderBy('added_at')->get();
        $roles = Role::whereNotIn('name', ['Super Admin','Admin', 'Company'])->orderBy('added_at')->get();
        return response()->json([
            'status'=> true,
            'data' => $tranwith,
            'types' => $types,
            'roles' => $roles,
        ], 200);
    } // End Method



    // Insert Tranwith
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required|unique:transaction__withs,tran_with_name',
            "role" => 'required',
            "tranType" => 'required',
            "tranMethod" => 'required',
        ]);

        Transaction_With::insert([
            "tran_with_name" => $req->name,
            "user_role" => $req->role,
            "tran_type" => $req->tranType,
            "tran_method" => $req->tranMethod,
        ]);
        
        return response()->json([
            'status'=> true,
            'message' => 'Transaction With Added Successfully'
        ], 200);  
    } // End Method



    // Edit Tranwith
    public function Edit(Request $req){
        $tranwith = Transaction_With::with('Role','Type')->findOrFail($req->id);
        $types = Transaction_Main_head::orderBy('added_at')->get();
        $roles = Role::whereNotIn('name', ['Super Admin','Admin'])->orderBy('added_at')->get();
        return response()->json([
            'status'=> true,            
            'tranwith'=>$tranwith,
            'types'=>$types,
            'roles'=>$roles,
        ], 200);
    } // End Method



    // Update Tranwith
    public function Update(Request $req){
        $tranwith = Transaction_With::findOrFail($req->id);
        // dd($tranwith);
        $req->validate([
            "name" => ['required', Rule::unique('transaction__withs', 'tran_with_name')->ignore($tranwith->id)],
            "role"  => 'required',
            "tranType" => 'required',
            "tranMethod" => 'required',
        ]);

        $update = Transaction_With::findOrFail($req->id)->update([
            "tran_with_name" => $req->name,
            "user_role" => $req->role,
            "tran_type" => $req->tranType,
            "tran_method" => $req->tranMethod,
            "updated_at" => now()
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Transaction With Updated Successfully',
            ], 200); 
        }
    } // End Method



    // Delete Tranwith
    public function Delete(Request $req){
        Transaction_With::findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Transaction With Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Tranwith
    public function Search(Request $req){
        $tranwith = Transaction_With::with('Role','Type')
        ->where('tran_with_name', 'like', '%'.$req->search.'%')
        ->where('tran_method', 'like', '%'.$req->method.'%')
        ->where('tran_type', 'like', '%'.$req->type.'%')
        ->where('user_role', 'like', '%'.$req->role.'%')
        ->orderBy('tran_with_name')
        ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $tranwith,
        ], 200);
    } // End Method



    // Get Tran With By Transaction Method And Type
    public function Get(Request $req){
        if ($req->type == null && $req->method != null) { // Find Transaction With For Party Payment
            $tranwith = Transaction_With::whereIn('tran_method', [$req->method, 'Both'])->where('user_role', $req->user)->get();
        }
        else if ($req->type == null && $req->method == null) { // Find Transaction With For User Entry
            $tranwith = Transaction_With::where('user_role', $req->user)->get();
        }
        else {  // Find Transaction With For Transactions
            $tranwith = Transaction_With::whereIn('tran_method', [$req->method, 'Both'])->where('tran_type',$req->type)->get();
        }
        
        return response()->json([
            'status' => true,
            'tranwith' => $tranwith,
        ]);
    } // End Method
}
