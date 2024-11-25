<?php

namespace App\Http\Controllers\API\Backend\Admin_Setup\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User_Info;
use App\Models\Transaction_With;
use App\Models\Transaction_Main;

class AdminController extends Controller
{
    // Show All Admins
    public function ShowAll(Request $req){
        $query = User_Info::with('Withs', 'Location')->where('user_role', 2);

        if (Auth::user()->user_role != 1) {
            $query->where('company_id', Auth::user()->company_id);
        }

        $admin = $query->orderBy('added_at', 'asc')->paginate(15);

        return response()->json([
            'status'=> true,
            'data' => $admin,
        ], 200);
    } // End Method



    // Insert Admins
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required',
            "phone" => 'required|numeric|unique:user__infos,user_phone',
            "email" => 'required|email|unique:user__infos,user_email',
            "gender" => 'required',
            "location" => 'required|numeric',
            'password' => 'required|confirmed',
            'image' => 'mimes:jpg,jpeg,png,gif|max:2048',
            'company' => 'required',
        ]);


        DB::transaction(function () use ($req) {
            // Generates Auto Increment Admin Id
            $latestEmployee = User_Info::where('user_role', 2)->orderBy('user_id','desc')->first();
            $id = ($latestEmployee) ? 'AD' . str_pad((intval(substr($latestEmployee->user_id, 2)) + 1), 9, '0', STR_PAD_LEFT) : 'AD000000001';

            if ($req->hasFile('image') && $req->file('image')->isValid()) {
                $originalName = $req->file('image')->getClientOriginalName();
                $imageName = '('. $req->company . ')'.$id. '('. $req->name . ').' . $req->file('image')->getClientOriginalExtension();
                $imagePath = $req->file('image')->storeAs('profiles', $imageName);
            }
            else{
                $imageName = null;
            }

            $admin = User_Info::insert([
                "user_id" => $id,
                "tran_user_type" => $req->type,
                "user_name" => $req->name,
                "user_phone" => $req->phone,
                "user_email" => $req->email,
                "gender" => $req->gender,
                "loc_id" => $req->location,
                "address" => $req->address,
                "user_role" =>  2,
                "password" => Hash::make($req->password),
                "image" => $imageName,
                "company_id" =>  $req->company,
            ]);
        });
        
        return response()->json([
            'status'=> true,
            'message' => 'Admin Details Added Successfully'
        ], 200);  
    } // End Method



    // Edit Admins
    public function Edit(Request $req){
        $admin = User_Info::with('Withs','Location')->findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'admin'=> $admin,
        ], 200);
    } // End Method



    // Update Admins
    public function Update(Request $req){
        $admin = User_Info::findOrFail($req->id);

        $req->validate([
            "name" => 'required',
            "phone" => ['required','numeric',Rule::unique('user__infos', 'user_phone')->ignore($admin->id)],
            "email" => ['required','email',Rule::unique('user__infos', 'user_email')->ignore($admin->id)],
            "gender" => 'required',
            "location" => 'required|numeric',
        ]);


        DB::transaction(function () use ($req) {
            $admin = User_Info::findOrFail($req->id);
            $path = 'public/profiles/'.$admin->image;
            
            if($req->image != null){
                $req->validate([
                    "image" => 'image|mimes:jpg,jpeg,png,gif|max:2048',
                ]);

                //process the image name and store it to storage/app/public/profiles directory
                if ($req->hasFile('image') && $req->file('image')->isValid()) {
                    Storage::delete($path);
                    $imageName = '('. $admin->company_id . ')' . $admin->user_id . '('. $req->name . ').' . $req->file('image')->getClientOriginalExtension();
                    $imagePath = $req->file('image')->storeAs('profiles', $imageName);
                }
            }
            else{
                $imageName = $admin->image;
            }

            $update = User_Info::findOrFail($req->id)->update([
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

        return response()->json([
            'status'=>true,
            'message' => 'Admin Details Updated Successfully',
        ], 200); 
    } // End Method



    // Delete Admins
    public function Delete(Request $req){
        $admin = User_Info::findOrFail($req->id);
        $path = 'public/profiles/'.$admin->image;
        Storage::delete($path);
        $admin->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Admin Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Admins
    public function Search(Request $req){
        $query = User_Info::with('Withs', 'Location')->where('user_role', 2);

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
            case 4: // Search By Location
                $query->whereHas('Location', function ($locationQuery) use ($req) {
                    $locationQuery->where('upazila', 'like', '%' . $req->search . '%')->orderBy('upazila', 'asc');
                });
                break;
            case 5: // Search By Address
                $query->where('address', 'like', '%' . $req->search . '%')->orderBy('address', 'asc');
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
        $admin = User_Info::with('Location','Withs')->where('user_id', $req->id)->first();
        return response()->json([
            'status'=> true,
            'data'=>view('admin_setup.users.admin.details', compact('admin'))->render(),
        ]);
    } // End Method
}
