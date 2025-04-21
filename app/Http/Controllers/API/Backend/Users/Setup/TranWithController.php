<?php

namespace App\Http\Controllers\API\Backend\Users\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Transaction_With;
use App\Models\Transaction_Main_Head;
use App\Models\Role;

class TranWithController extends Controller
{
    // Show All Tranwith
    public function ShowAll(Request $req){
        $type = GetTranType($req->segment(2));

        if($type != null){
            $tranwith = Transaction_With::on('mysql_second')
            ->with('Role','Type')
            ->where('tran_type', $type)
            ->orderBy('added_at')
            ->get();
        }
        else{
            $tranwith = Transaction_With::on('mysql_second')
            ->with('Role','Type')
            ->orderBy('added_at')
            ->get();
        }

        $types = Transaction_Main_Head::on('mysql')->orderBy('added_at')->get();
        $roles = Role::on('mysql')->whereNotIn('name', ['Super Admin','Admin'])->orderBy('added_at')->get();
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
            "name" => 'required|unique:mysql_second.transaction__withs,tran_with_name',
            "role" => 'required|exists:mysql.roles,id',
            "tranType" => 'required|exists:mysql.transaction__main__heads,id',
            "tranMethod" => 'required|in:Receive,Payment,Both',
        ]);

        Transaction_With::on('mysql_second')->insert([
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
        $data = Transaction_With::on('mysql_second')->with('Role','Type')->findOrFail($req->id);
        $types = Transaction_Main_Head::on('mysql')->orderBy('added_at')->get();
        $roles = Role::on('mysql')->whereNotIn('name', ['Super Admin','Admin'])->orderBy('added_at')->get();
        return response()->json([
            'status'=> true,            
            'data'=>$data,
            'types'=>$types,
            'roles'=>$roles,
        ], 200);
    } // End Method



    // Update Tranwith
    public function Update(Request $req){
        $data = Transaction_With::on('mysql_second')->findOrFail($req->id);
        $req->validate([
            "name" => ['required', Rule::unique('mysql_second.transaction__withs', 'tran_with_name')->ignore($data->id)],
            "role"  => 'required|exists:mysql.roles,id',
            "tranType" => 'required|exists:mysql.transaction__main__heads,id',
            "tranMethod" => 'required|in:Receive,Payment,Both',
        ]);

        $update = $data->update([
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
        Transaction_With::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Transaction With Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Tranwith
    public function Search(Request $req){
        $data = Transaction_With::on('mysql_second')->with('Role','Type')
        ->where('tran_with_name', 'like', $req->search.'%')
        ->where('tran_method', 'like', '%'.$req->method.'%')
        ->where('tran_type', 'like', '%'.$req->type.'%')
        ->where('user_role', 'like', '%'.$req->role.'%')
        ->orderBy('tran_with_name')
        ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Get Tran With By Transaction Method And Type
    public function Get(Request $req){
        if ($req->type == null && $req->method != null) { // Find Transaction With For Party Payment
            $data = Transaction_With::on('mysql_second')->whereIn('tran_method', [$req->method, 'Both'])->where('user_role', $req->user)->get();
        }
        else if ($req->type == null && $req->method == null) { // Find Transaction With For User Entry
            $data = Transaction_With::on('mysql_second')->where('user_role', $req->user)->get();
        }
        else if ($req->type != null && $req->method == null) { // Find Transaction With For User Entry
            $data = Transaction_With::on('mysql_second')->where('tran_type',$req->type)->where('user_role', $req->user)->get();
        }
        else {  // Find Transaction With For Transactions
            $data = Transaction_With::on('mysql_second')->whereIn('tran_method', [$req->method, 'Both'])->where('tran_type',$req->type)->get();
        }
        
        return response()->json([
            'status' => true,
            'tranwith' => $data,
        ]);
    } // End Method
}
