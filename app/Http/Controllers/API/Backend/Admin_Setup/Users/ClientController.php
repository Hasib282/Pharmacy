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

class ClientController extends Controller
{
    // Show All Clients
    public function ShowAll(Request $req){
        $client = User_Info::with('Withs','Location')->where('user_role', 4)->orderBy('added_at','asc')->paginate(15);
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
            "phone" => 'required|numeric|unique:user__infos,user_phone',
            "email" => 'required|email|unique:user__infos,user_email',
            "gender" => 'required',
            "location" => 'required|numeric',
            'image' => 'mimes:jpg,jpeg,png,gif|max:2048',
            'company' => 'required',
        ]);


        DB::transaction(function () use ($req) {
            // Generates Auto Increment Client Id
            $latestEmployee = User_Info::where('user_role', 4)->orderBy('user_id','desc')->first();
            $id = ($latestEmployee) ? 'C' . str_pad((intval(substr($latestEmployee->user_id, 1)) + 1), 9, '0', STR_PAD_LEFT) : 'C000000101';

            if ($req->hasFile('image') && $req->file('image')->isValid()) {
                $originalName = $req->file('image')->getClientOriginalName();
                $imageName = '('. $req->company . ')'. $id . '('. $req->name . ').' . $req->file('image')->getClientOriginalExtension();
                $imagePath = $req->file('image')->storeAs('profiles', $imageName);
                \Log::info("Image stored at: $imagePath");
            }
            else{
                $imageName = null;
            }

            $client = User_Info::insert([
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
                "company_id" =>  $req->company,
            ]);
        });
        
        return response()->json([
            'status'=> true,
            'message' => 'Client Details Added Successfully'
        ], 200);  
    } // End Method



    // Edit Clients
    public function Edit(Request $req){
        $client = User_Info::with('Withs','Location')->findOrFail($req->id);
        $tranwith = Transaction_With::where('user_role', 4)->get();
        return response()->json([
            'status'=> true,
            'client'=> $client,
            'tranwith'=> $tranwith,
        ], 200);
    } // End Method



    // Update Clients
    public function Update(Request $req){
        $client = User_Info::findOrFail($req->id);

        $req->validate([
            "type" => 'required',
            "name" => 'required',
            "phone" => ['required','numeric',Rule::unique('user__infos', 'user_phone')->ignore($client->id)],
            "email" => ['required','email',Rule::unique('user__infos', 'user_email')->ignore($client->id)],
            "gender" => 'required',
            "location" => 'required|numeric',
        ]);

        DB::transaction(function () use ($req) {
            $client = User_Info::findOrFail($req->id);
            $path = 'public/profiles/'.$client->image;
            
            if($req->image != null){
                $req->validate([
                    "image" => 'image|mimes:jpg,jpeg,png,gif|max:2048',
                ]);

                //process the image name and store it to storage/app/public/profiles directory
                if ($req->hasFile('image') && $req->file('image')->isValid()) {
                    Storage::delete($path);
                    $imageName = '('. $client->company_id . ')' . $client->user_id. '('. $req->name . ').' . $req->file('image')->getClientOriginalExtension();
                    $imagePath = $req->file('image')->storeAs('profiles', $imageName);
                }
            }
            else{
                $imageName = $client->image;
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
            'message' => 'Client Details Updated Successfully',
        ], 200);
    } // End Method



    // Delete Clients
    public function Delete(Request $req){
        $admin = User_Info::findOrFail($req->id);
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
        if($req->searchOption == 1){
            $client = User_Info::with('Withs','Location')
            ->where('user_role', 4)
            ->where('user_name', 'like', '%'.$req->search.'%')
            ->orderBy('user_name','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $client = User_Info::with('Withs','Location')
            ->where('user_role', 4)
            ->where('user_email', 'like', '%'.$req->search.'%')
            ->orderBy('user_email','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 3){
            $client = User_Info::with('Withs','Location')
            ->where('user_role', 4)
            ->where('user_phone', 'like', '%'.$req->search.'%')
            ->orderBy('user_phone','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 4){
            $client = User_Info::with('Withs','Location')
            ->whereHas('Location', function ($query) use ($req) {
                $query->where('upazila', 'like', '%'.$req->search.'%');
                $query->orderBy('upazila','asc');
            })
            ->where('user_role', 4)
            ->paginate(15);
        }
        else if($req->searchOption == 5){
            $client = User_Info::with('Withs','Location')
            ->where('user_role', 4)
            ->where('address', 'like', '%'.$req->search.'%')
            ->orderBy('address','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 6){
            $client = User_Info::with('Withs','Location')
            ->whereHas('Withs', function ($query) use ($req) {
                $query->where('tran_with_name', 'like', '%'.$req->search.'%');
                $query->orderBy('tran_with_name','asc');
            })
            ->where('user_role', 4)
            ->paginate(15);
        }
        
        return response()->json([
            'status' => true,
            'data' => $client,
        ], 200);
    } // End Method



    // Show Client Details
    public function Details(Request $req){
        $client = User_Info::with('Location','Withs')->where('user_id', "=", $req->id)->first();
        $transaction = Transaction_Main::where('tran_user', "=", $req->id)->get();
        return response()->json([
            'status'=> true,
            'data'=>view('admin_setup.users.client.details', compact('client','transaction'))->render(),
        ]);
    } // End Method
}
