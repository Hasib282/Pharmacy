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

class ClientController extends Controller
{
    // Show All Clients
    public function ShowAll(Request $req){
        $client = User_Info::on('mysql')->with('Withs', 'Location')->where('user_role', 4)->orderBy('added_at', 'asc')->paginate(15);
        
        return response()->json([
            'status'=> true,
            'data' => $client,
        ], 200);
    } // End Method



    // Insert Clients
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required',
            "type" => 'required',
            "phone" => 'required|numeric',
            "email" => 'required|email',
            "gender" => 'required',
            "location" => 'required|numeric',
            'image' => 'mimes:jpg,jpeg,png,gif|max:2048',
        ]);


        DB::transaction(function () use ($req) {
            // Generates Auto Increment Client Id
            $latestEmployee = User_Info::on('mysql')->where('user_role', 4)->orderBy('user_id','desc')->first();
            $id = ($latestEmployee) ? 'C' . str_pad((intval(substr($latestEmployee->user_id, 1)) + 1), 9, '0', STR_PAD_LEFT) : 'C000000101';

            if ($req->hasFile('image') && $req->file('image')->isValid()) {
                $originalName = $req->file('image')->getClientOriginalName();
                $imageName = $id . '('. $req->name . ').' . $req->file('image')->getClientOriginalExtension();
                $imagePath = $req->file('image')->storeAs('profiles', $imageName);
            }
            else{
                $imageName = null;
            }

            $client = User_Info::on('mysql')->insert([
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
        });
        
        return response()->json([
            'status'=> true,
            'message' => 'Client Details Added Successfully'
        ], 200);  
    } // End Method



    // Edit Clients
    public function Edit(Request $req){
        $client = User_Info::on('mysql')->with('Withs','Location')->findOrFail($req->id);
        $tranwith = Transaction_With::on('mysql')->where('user_role', 4)->get();
        return response()->json([
            'status'=> true,
            'client'=> $client,
            'tranwith'=> $tranwith,
        ], 200);
    } // End Method



    // Update Clients
    public function Update(Request $req){
        $client = User_Info::on('mysql')->findOrFail($req->id);

        $req->validate([
            "type" => 'required',
            "name" => 'required',
            "phone" => 'required|numeric',
            "email" => 'required|email',
            "gender" => 'required',
            "location" => 'required|numeric',
        ]);

        DB::transaction(function () use ($req) {
            $client = User_Info::on('mysql')->findOrFail($req->id);
            $path = 'public/profiles/'.$client->image;
            
            if($req->image != null){
                $req->validate([
                    "image" => 'image|mimes:jpg,jpeg,png,gif|max:2048',
                ]);

                //process the image name and store it to storage/app/public/profiles directory
                if ($req->hasFile('image') && $req->file('image')->isValid()) {
                    Storage::delete($path);
                    $imageName = $client->user_id. '('. $req->name . ').' . $req->file('image')->getClientOriginalExtension();
                    $imagePath = $req->file('image')->storeAs('profiles', $imageName);
                }
            }
            else{
                $imageName = $client->image;
            }

            $update = User_Info::on('mysql')->findOrFail($req->id)->update([
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
            'message' => 'Client Details Updated Successfully',
        ], 200);
    } // End Method



    // Delete Clients
    public function Delete(Request $req){
        $admin = User_Info::on('mysql')->findOrFail($req->id);
        $path = 'public/profiles/'.$admin->image;
        Storage::delete($path);
        $admin->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Client Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Clients
    public function Search(Request $req){
        $query = User_Info::on('mysql')->with('Withs', 'Location')->where('user_role', 4);

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
            case 6: // Search By User Type
                $query->whereHas('Withs', function ($withQuery) use ($req) {
                    $withQuery->where('tran_with_name', 'like', '%' . $req->search . '%')->orderBy('tran_with_name', 'asc');
                });
                break;
        }

        // Execute query and paginate
        $client = $query->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $client,
        ], 200);
    } // End Method



    // Show Client Details
    public function Details(Request $req){
        $client = User_Info::on('mysql')->with('Location','Withs')->where('user_id', "=", $req->id)->first();
        $transaction = Transaction_Main::on('mysql')->where('tran_user', "=", $req->id)->get();
        return response()->json([
            'status'=> true,
            'data'=>view('admin_setup.users.client.details', compact('client','transaction'))->render(),
        ]);
    } // End Method
}
