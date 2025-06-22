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

class ClientController extends Controller
{
    // Show All Clients
    public function Show(Request $req){
        $type = GetTranType($req->segment(2));

        $data = User_Info::on('mysql_second')
        ->with('Withs', 'Location')
        ->whereHas('Withs', function ($q) use ($type) {
            $q->where('tran_type', $type);
        })
        ->where('user_role', 4)
        ->orderBy('added_at', 'asc')
        ->get();

        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Clients
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required',
            "type" => 'required|exists:mysql_second.transaction__withs,id',
            "phone" => 'required|numeric',
            "email" => 'required|email',
            "gender" => 'required',
            "location" => 'required|exists:mysql.location__infos,id',
            'image' => 'mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = null;

        DB::transaction(function () use ($req, &$data) {
            // Calling UserHelper Functions
            $id = GenerateUserId(4, 'CL');
            $imageName = StoreUserImage($req, $id);

            $insert = User_Info::on('mysql_second')->create([
                "user_id" => $id,
                "tran_user_type" => $req->type,
                "user_name" => $req->name,
                "user_phone" => $req->phone,
                "user_email" => $req->email,
                "gender" => $req->gender,
                "loc_id" => $req->location,
                "address" => $req->address,
                "user_role" =>  4,
                "image" => $imageName,
            ]);

            $data = User_Info::on('mysql_second')->with('Withs', 'Location')->findOrFail($insert->id);
        });

        
        return response()->json([
            'status'=> true,
            'message' => 'Client Details Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method



    // Update Clients
    public function Update(Request $req){
        $data = User_Info::on('mysql_second')->where('user_role', 4)->findOrFail($req->id);

        $req->validate([
            "type" => 'required|exists:mysql_second.transaction__withs,id',
            "name" => 'required',
            "phone" => 'required|numeric',
            "email" => 'required|email',
            "gender" => 'required',
            "location" => 'required|exists:mysql.location__infos,id',
        ]);

        DB::transaction(function () use ($req, $data) {
            $imageName = UpdateUserImage($req, $data->image, null, $data->user_id);

            $update = User_Info::on('mysql_second')->where('user_role', 4)->findOrFail($req->id)->update([
                "tran_user_type" => $req->type,
                "user_name" => $req->name,
                "user_phone" => $req->phone,
                "user_email" => $req->email,
                "gender" => $req->gender,
                "loc_id" => $req->location,
                "address" => $req->address,
                "image" => $imageName,
                "updated_at" => now(),
            ]);
        });

        $updatedData = User_Info::on('mysql_second')->with('Withs', 'Location')->findOrFail($req->id);

        return response()->json([
            'status'=>true,
            'message' => 'Client Details Updated Successfully',
            "updatedData" => $updatedData,
        ], 200);
    } // End Method



    // Delete Clients
    public function Delete(Request $req){
        $data = User_Info::on('mysql_second')->where('user_role', 4)->findOrFail($req->id);
        if($data->image){
            Storage::disk('public')->delete($data->image);
        }
        $data->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Client Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Show Client Details
    public function Details(Request $req){
        $client = User_Info::on('mysql_second')->where('user_role', 4)->with('Location','Withs')->where('user_id', "=", $req->id)->first();
        $transaction = Transaction_Main::on('mysql_second')->where('tran_user', "=", $req->id)->get();
        return response()->json([
            'status'=> true,
            'data'=>view('users.client.details', compact('client','transaction'))->render(),
        ]);
    } // End Method
}
