<?php

namespace App\Http\Controllers\API\Backend\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

use App\Models\Login_User;
use App\Models\Transaction_With;
use App\Models\Transaction_Main;

class SuperAdminController extends Controller
{
    // Show All SuperAdmins
    public function ShowAll(Request $req){
        $superadmin = Login_User::on('mysql')->where('user_role', 1)->orderBy('added_at','asc')->paginate(15);
        return response()->json([
            'status'=> true,
            'data' => $superadmin,
        ], 200);
    } // End Method



    // Insert SuperAdmins
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required',
            "phone" => 'required|numeric|unique:mysql.login__users,user_phone',
            "email" => 'required|email|unique:mysql.login__users,user_email',
            'password' => 'required|confirmed',
            'image' => 'mimes:jpg,jpeg,png,gif|max:2048',
        ]);


        DB::transaction(function () use ($req) {
            // Calling UserHelper Functions
            $id = GenerateLoginUserId(1, "SA");
            $imageName = StoreUserImage($req, $id);

            Login_User::on('mysql')->insert([
                "user_id" => $id,
                "user_name" => $req->name,
                "user_phone" => $req->phone,
                "user_email" => $req->email,
                "user_role" => 1,
                "password" => Hash::make($req->password),
                "image" => $imageName,
            ]);
        });
        
        return response()->json([
            'status'=> true,
            'message' => 'SuperAdmin Details Added Successfully'
        ], 200);  
    } // End Method



    // Edit SuperAdmins
    public function Edit(Request $req){
        $superadmin = Login_User::on('mysql')->findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'superadmin'=> $superadmin,
        ], 200);
    } // End Method



    // Update SuperAdmins
    public function Update(Request $req){
        $superadmin = Login_User::on('mysql')->findOrFail($req->id);

        $req->validate([
            "name" => 'required',
            "phone" => ['required','numeric',Rule::unique('mysql.login__users', 'user_phone')->ignore($superadmin->id)],
            "email" => ['required','email',Rule::unique('mysql.login__users', 'user_email')->ignore($superadmin->id)],
        ]);


        DB::transaction(function () use ($req, $superadmin) {
            // Calling UserHelper Functions
            $imageName = UpdateUserImage($req, $superadmin->image, null, $superadmin->user_id);

            Login_User::on('mysql')->findOrFail($req->id)->update([
                "user_name" => $req->name,
                "user_phone" => $req->phone,
                "user_email" => $req->email,
                "image" => $imageName,
                "updated_at" => now(),
            ]);
        });

        return response()->json([
            'status'=>true,
            'message' => 'SuperAdmin Details Updated Successfully',
        ], 200); 
    } // End Method



    // Delete SuperAdmins
    public function Delete(Request $req){
        $superadmin = Login_User::on('mysql')->findOrFail($req->id);
        if($superadmin->image){
            Storage::disk('public')->delete($superadmin->image);
        }
        $superadmin->delete();
        return response()->json([
            'status'=> true,
            'message' => 'SuperAdmin Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Search SuperAdmins
    public function Search(Request $req){
        if($req->searchOption == 1){ // Search by User Name and Id
            $superadmin = Login_User::on('mysql')
            ->where('user_role', 1)
            ->where('user_name', 'like', $req->search.'%')
            ->orderBy('user_name','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 2){ // Search by User Email
            $superadmin = Login_User::on('mysql')
            ->where('user_role', 1)
            ->where('user_email', 'like', $req->search.'%')
            ->orderBy('user_email','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 3){ // Search by User Phone
            $superadmin = Login_User::on('mysql')
            ->where('user_role', 1)
            ->where('user_phone', 'like', $req->search.'%')
            ->orderBy('user_phone','asc')
            ->paginate(15);
        }
        
        return response()->json([
            'status' => true,
            'data' => $superadmin,
        ], 200);
    } // End Method
}
