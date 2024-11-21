<?php

namespace App\Http\Controllers\API\Backend\Admin_Setup\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

use App\Models\User_Info;
use App\Models\Transaction_With;
use App\Models\Transaction_Main;

class SuperAdminController extends Controller
{
    // Show All SuperAdmins
    public function ShowAll(Request $req){
        $superadmin = User_Info::with('Withs','Location')->where('user_role', 1)->orderBy('added_at','asc')->paginate(15);
        return response()->json([
            'status'=> true,
            'data' => $superadmin,
        ], 200);
    } // End Method



    // Insert SuperAdmins
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required',
            "phone" => 'required|numeric|unique:user__infos,user_phone',
            "email" => 'required|email|unique:user__infos,user_email',
            "gender" => 'required',
            "location" => 'required|numeric',
            'password' => 'required|confirmed',
            'image' => 'mimes:jpg,jpeg,png,gif|max:2048',
        ]);


        DB::transaction(function () use ($req) {
            // Generates Auto Increment Super Admin Id
            $latestEmployee = User_Info::where('user_role', 1)->orderBy('user_id','desc')->first();
            $id = ($latestEmployee) ? 'SA' . str_pad((intval(substr($latestEmployee->user_id, 2)) + 1), 9, '0', STR_PAD_LEFT) : 'SA000000001';

            if ($req->hasFile('image') && $req->file('image')->isValid()) {
                $originalName = $req->file('image')->getClientOriginalName();
                $imageName = $id. '('. $req->name . ').' . $req->file('image')->getClientOriginalExtension();
                $imagePath = $req->file('image')->storeAs('profiles', $imageName);
                \Log::info("Image stored at: $imagePath");
            }
            else{
                $imageName = null;
            }

            $superadmin = User_Info::insert([
                "user_id" => $id,
                "tran_user_type" => $req->type,
                "user_name" => $req->name,
                "user_phone" => $req->phone,
                "user_email" => $req->email,
                "gender" => $req->gender,
                "loc_id" => $req->location,
                "address" => $req->address,
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
        $superadmin = User_Info::with('Withs','Location')->findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'superadmin'=> $superadmin,
        ], 200);
    } // End Method



    // Update SuperAdmins
    public function Update(Request $req){
        $superadmin = User_Info::findOrFail($req->id);

        $req->validate([
            "name" => 'required',
            "phone" => ['required','numeric',Rule::unique('user__infos', 'user_phone')->ignore($superadmin->id)],
            "email" => ['required','email',Rule::unique('user__infos', 'user_email')->ignore($superadmin->id)],
            "gender" => 'required',
            "location" => 'required|numeric',
        ]);


        DB::transaction(function () use ($req) {
            $superadmin = User_Info::findOrFail($req->id);
            $path = 'public/profiles/'.$superadmin->image;
            
            if($req->image != null){
                $req->validate([
                    "image" => 'image|mimes:jpg,jpeg,png,gif|max:2048',
                ]);

                //process the image name and store it to storage/app/public/profiles directory
                if ($req->hasFile('image') && $req->file('image')->isValid()) {
                    Storage::delete($path);
                    $imageName = $superadmin->user_id. '('. $req->name . ').' . $req->file('image')->getClientOriginalExtension();
                    $imagePath = $req->file('image')->storeAs('profiles', $imageName);
                }
            }
            else{
                $imageName = $superadmin->image;
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
            'message' => 'SuperAdmin Details Updated Successfully',
        ], 200); 
    } // End Method



    // Delete SuperAdmins
    public function Delete(Request $req){
        $superadmin = User_Info::findOrFail($req->id);
        $path = 'public/profiles/'.$superadmin->image;
        Storage::delete($path);
        $superadmin->delete();
        return response()->json([
            'status'=> true,
            'message' => 'SuperAdmin Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Search SuperAdmins
    public function Search(Request $req){
        if($req->searchOption == 1){ // Search by User Name and Id
            $superadmin = User_Info::with('Withs','Location')
            ->where('user_role', 1)
            ->where('user_name', 'like', '%'.$req->search.'%')
            ->orderBy('user_name','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 2){ // Search by User Email
            $superadmin = User_Info::with('Withs','Location')
            ->where('user_role', 1)
            ->where('user_email', 'like', '%'.$req->search.'%')
            ->orderBy('user_email','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 3){ // Search by User Phone
            $superadmin = User_Info::with('Withs','Location')
            ->where('user_role', 1)
            ->where('user_phone', 'like', '%'.$req->search.'%')
            ->orderBy('user_phone','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 4){ // Search by Location
            $superadmin = User_Info::with('Withs','Location')
            ->whereHas('Location', function ($query) use ($req) {
                $query->where('upazila', 'like', '%'.$req->search.'%');
                $query->orderBy('upazila','asc');
            })
            ->where('user_role', 1)
            ->paginate(15);
        }
        else if($req->searchOption == 5){ // Search by Adderss
            $superadmin = User_Info::with('Withs','Location')
            ->where('user_role', 1)
            ->where('address', 'like', '%'.$req->search.'%')
            ->orderBy('address','asc')
            ->paginate(15);
        }
        
        return response()->json([
            'status' => true,
            'data' => $superadmin,
        ], 200);
    } // End Method



    // Show Super Admin Details
    public function Details(Request $req){
        $superadmin = User_Info::with('Location','Withs')->where('user_id', "=", $req->id)->first();
        return response()->json([
            'status'=> true,
            'data'=>view('admin_setup.users.super_admin.details', compact('superadmin'))->render(),
        ]);
    } // End Method



    public function GetCurrentUser(Request $request)
    {
        return response()->json(Auth::user());
    }
}
