<?php

namespace App\Http\Controllers\API\Backend\Users;

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
        if(Auth::user()->user_role == 1) {
            $data = User_Info::on('mysql_second')
            ->where('user_role', 2)
            ->orderBy('added_at', 'asc')
            ->get();
        }
        else{
            $data = User_Info::on('mysql_second')
            ->where('company_id', Auth::user()->company_id)
            ->where('user_role', 2)
            ->orderBy('added_at', 'asc')
            ->get();
        }

        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Admins
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required',
            "phone" => 'required|numeric|unique:mysql.login__users,user_phone',
            "email" => 'required|email|unique:mysql.login__users,user_email',
            'password' => 'required|confirmed',
            'image' => 'mimes:jpg,jpeg,png,gif|max:2048',
            'company' => 'required|exists:mysql.company__details,company_id',
        ]);


        DB::transaction(function () use ($req) {
            // Calling UserHelper Functions
            $adminId = GenerateLoginUserId(2, 'AD');
            $id = GenerateUserId(2, 'AD');
            $imageName = StoreUserImage($req, $id);

            Login_User::on('mysql')->create([
                "user_id" => $adminId,
                "company_user_id" => $id,
                "user_name" => $req->name,
                "user_phone" => $req->phone,
                "user_email" => $req->email,
                "user_role" =>  2,
                "password" => Hash::make($req->password),
                "image" => $imageName,
                "store_id" =>  $req->store,
                "company_id" =>  $req->company,
            ]);
            
            
            $insert = User_Info::on('mysql_second')->create([
                "user_id" => $id,
                "login_user_id" => $adminId,
                "user_name" => $req->name,
                "user_phone" => $req->phone,
                "user_email" => $req->email,
                "user_role" =>  2,
                "password" => Hash::make($req->password),
                "image" => $imageName,
                "store_id" =>  $req->store,
                "company_id" =>  $req->company,
            ]);
        });

        $data = User_Info::on('mysql_second')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Admin Details Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method



    // Edit Admins
    public function Edit(Request $req){
        $data = User_Info::on('mysql_second')->findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'data'=> $data,
        ], 200);
    } // End Method



    // Update Admins
    public function Update(Request $req){
        $data = User_Info::on('mysql_second')->findOrFail($req->id);

        $req->validate([
            "name" => 'required',
            "phone" => ['required','numeric',Rule::unique('mysql.login__users', 'user_phone')->ignore($data->login_user_id, 'user_id' )],
            "email" => ['required','email',Rule::unique('mysql.login__users', 'user_email')->ignore( $data->login_user_id, 'user_id')],
        ]);


        DB::transaction(function () use ($req, $data) {
            $login_user = Login_User::on('mysql')->where('user_id', $data->login_user_id)->first();
            // Calling UserHelper Functions
            $imageName = UpdateUserImage($req, $data->image, $login_user->company_id, $data->user_id);

            $login_user->update([
                "user_name" => $req->name,
                "user_phone" => $req->phone,
                "user_email" => $req->email,
                "image" => $imageName,
                "updated_at" => now(),
            ]);

            
            $data->update([
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
            "updatedData" => $updatedData,
        ], 200); 
    } // End Method



    // Delete Admins
    public function Delete(Request $req){
        $data = User_Info::on('mysql_second')->findOrFail($req->id);
        if($data->image){
            Storage::disk('public')->delete($data->image);
        }
        Login_User::on('mysql')->where('user_id',$data->login_user_id)->delete();
        $data->delete();
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
        if(Auth::user()->user_role = 1){
            $data = $query->paginate(15);
        }
        else{
            $data = $query->where('company_id', Auth::user()->company_id)->paginate(15);
        }
        

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Show Admin Details
    public function Details(Request $req){
        $admin = User_Info::on('mysql_second')->with('Location','Withs')->where('user_id', $req->id)->first();
        return response()->json([
            'status'=> true,
            'data'=>view('users.admin.details', compact('admin'))->render(),
        ]);
    } // End Method
}
