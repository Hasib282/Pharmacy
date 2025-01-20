<?php

namespace App\Http\Controllers\API\Backend\Admin_Setup\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Login_User;
use App\Models\User_Info;
use App\Models\Transaction_With;
use App\Models\Transaction_Main;

class AdminController extends Controller
{
    // Show All Admins
    public function ShowAll(Request $req){
        $admin = User_Info::on('mysql_second')
        ->where('user_role', 2)
        ->orderBy('added_at', 'asc')
        ->paginate(15);

        return response()->json([
            'status'=> true,
            'data' => $admin,
        ], 200);
    } // End Method



    // Insert Admins
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required',
            "phone" => 'required|numeric|unique:mysql_second.user__infos,user_phone',
            "email" => 'required|email|unique:mysql_second.user__infos,user_email',
            'password' => 'required|confirmed',
            'image' => 'mimes:jpg,jpeg,png,gif|max:2048',
            'company' => 'required',
        ]);


        DB::transaction(function () use ($req) {
            // Calling UserHelper Functions
            $adminId = GenerateLoginUserId(2, 'AD');
            $id = GenerateUserId(2, 'AD');
            $imageName = StoreUserImage($req, $id);

            Login_User::on('mysql')->insert([
                "user_id" => $adminId,
                "user_name" => $req->name,
                "user_phone" => $req->phone,
                "user_email" => $req->email,
                "user_role" =>  2,
                "password" => Hash::make($req->password),
                "image" => $imageName,
                "store_id" =>  $req->store,
                "company_id" =>  $req->company,
            ]);
            
            
            User_Info::on('mysql_second')->insert([
                "user_id" => $id,
                "login_user_id" => $adminId,
                "user_name" => $req->name,
                "user_phone" => $req->phone,
                "user_email" => $req->email,
                "user_role" =>  2,
                "password" => Hash::make($req->password),
                "image" => $imageName,
                "store_id" =>  $req->store,
            ]);
        });
        
        return response()->json([
            'status'=> true,
            'message' => 'Admin Details Added Successfully'
        ], 200);  
    } // End Method



    // Edit Admins
    public function Edit(Request $req){
        $admin = User_Info::on('mysql_second')->findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'admin'=> $admin,
        ], 200);
    } // End Method



    // Update Admins
    public function Update(Request $req){
        $admin = User_Info::on('mysql_second')->findOrFail($req->id);

        $req->validate([
            "name" => 'required',
            "phone" => ['required','numeric',Rule::unique('mysql_second.user__infos', 'user_phone')->ignore($admin->id)],
            "email" => ['required','email',Rule::unique('mysql_second.user__infos', 'user_email')->ignore($admin->id)],
        ]);


        DB::transaction(function () use ($req, $admin) {
            $login_user = Login_User::on('mysql')->where('user_id', $admin->login_user_id)->first();
            // Calling UserHelper Functions
            $imageName = UpdateUserImage($req, $admin->image, $login_user->company_id, $admin->user_id);

            $login_user->update([
                "user_name" => $req->name,
                "user_phone" => $req->phone,
                "user_email" => $req->email,
                "image" => $imageName,
                "updated_at" => now(),
            ]);

            
            $admin->update([
                "user_name" => $req->name,
                "user_phone" => $req->phone,
                "user_email" => $req->email,
                "image" => $imageName,
                "updated_at" => now(),
            ]);
        });

        return response()->json([
            'status'=>true,
            'message' => 'Admin Details Updated Successfully',
        ], 200); 
    } // End Method



    // Delete Admins
    public function Delete(Request $req){
        $admin = User_Info::on('mysql_second')->findOrFail($req->id);
        if($admin->image){
            Storage::disk('public')->delete($admin->image);
        }
        Login_User::on('mysql')->where('user_id',$admin->login_user_id)->delete();
        $admin->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Admin Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Admins
    public function Search(Request $req){
        $query = User_Info::on('mysql_second')->where('user_role', 2);

        // Filter Data for Non-super-admin users
        if (Auth::user()->user_role != 1) {
            $query->where('company_id', Auth::user()->company_id);
        }

        // Handle search options
        switch ($req->searchOption) {
            case 1: // Search User By Name
                $query->where('user_name', 'like', '%' . $req->search . '%')->orderBy('user_name', 'asc');
                break;
            case 2: // Search By Email
                $query->where('user_email', 'like', '%' . $req->search . '%')->orderBy('user_email', 'asc');
                break;
            case 3: // Search By Phone
                $query->where('user_phone', 'like', '%' . $req->search . '%')->orderBy('user_phone', 'asc');
                break;
        }

        // Execute query and paginate
        $admins = $query->paginate(15);

        return response()->json([
            'status' => true,
            'data' => $admins,
        ], 200);
    } // End Method



    // Show Admin Details
    public function Details(Request $req){
        $admin = User_Info::on('mysql_second')->with('Location','Withs')->where('user_id', $req->id)->first();
        return response()->json([
            'status'=> true,
            'data'=>view('admin_setup.users.admin.details', compact('admin'))->render(),
        ]);
    } // End Method
}
