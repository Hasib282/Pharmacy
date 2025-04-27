<?php

namespace App\Http\Controllers\API\Backend\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User_Info;
use App\Models\Transaction_Main;

class SupplierController extends Controller
{
    // Show All Suppliers
    public function Show(Request $req){
        $type = GetTranType($req->segment(2));

        $data = User_Info::on('mysql_second')
        ->with('Withs', 'Location')
        ->whereHas('Withs', function ($q) use ($type) {
            $q->where('tran_type', $type);
        })
        ->where('user_role', 5)
        ->orderBy('added_at', 'asc')
        ->get();

        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Suppliers
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required',
            "type" => 'required|exists:mysql_second.transaction__withs,id',
            "email" => 'required|email',
            "phone" => 'required|numeric',
            "gender" => 'required',
            "location" => 'required|exists:mysql.location__infos,id',
            "address" => 'required',
            'image' => 'mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = null;
        
        DB::transaction(function () use ($req, &$data) {
            // Calling UserHelper Functions
            $id = GenerateUserId(5, 'SU');
            $imageName = StoreUserImage($req, $id);
            
            $insert = User_Info::on('mysql_second')->create([
                "user_id" => $id,
                "tran_user_type" => $req->type,
                "user_name" => $req->name,
                "user_email" => $req->email,
                "user_phone" => $req->phone,
                "gender" => $req->gender,
                "loc_id" => $req->location,
                "address" => $req->address,
                "user_role" =>  5,
                "image" => $imageName,
            ]);

            $data = User_Info::on('mysql_second')->with('Withs', 'Location')->findOrFail($insert->id);
        });

        
        return response()->json([
            'status'=> true,
            'message' => 'Supplier Details Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method



    // Update Suppliers
    public function Update(Request $req){
        $data = User_Info::on('mysql_second')->findOrFail($req->id);

        $req->validate([
            "name" => 'required',
            "email" => 'required|email',
            "phone" => 'required|numeric',
            "gender" => 'required',
            "address" => 'required',
            "location" => 'required|exists:mysql.location__infos,id',
            "type" => 'required|exists:mysql_second.transaction__withs,id'
        ]);

        DB::transaction(function () use ($req, $data) {
            $imageName = UpdateUserImage($req, $data->image, null, $data->user_id);

            $update = $data->update([
                "tran_user_type" => $req->type,
                "user_name" => $req->name,
                "user_email" => $req->email,
                "user_phone" => $req->phone,
                "loc_id" => $req->location,
                "gender" => $req->gender,
                "address" => $req->address,
                "image" => $imageName,
                "updated_at" => now()
            ]);
        });

        $updatedData = User_Info::on('mysql_second')->with('Withs', 'Location')->findOrFail($req->id);

        return response()->json([
            'status'=>true,
            'message' => 'Supplier Details Updated Successfully',
            "updatedData" => $updatedData,
        ], 200);
    } // End Method



    // Delete Suppliers
    public function Delete(Request $req){
        $data = User_Info::on('mysql_second')->findOrFail($req->id);
        if($data->image){
            Storage::disk('public')->delete($data->image);
        }
        $data->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Supplier Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Show Supplier Details
    public function Details(Request $req){
        $supplier = User_Info::on('mysql_second')->with('Location','Withs')->where('user_id', "=", $req->id)->first();
        $transaction = Transaction_Main::on('mysql_second')->where('tran_user', "=", $req->id)->get();
        return response()->json([
            'status'=> true,
            'data'=>view('users.supplier.details', compact("supplier",'transaction'))->render(),
        ]);
    } // End Method
}
