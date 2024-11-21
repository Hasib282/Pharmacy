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

class SupplierController extends Controller
{
    // Show All Suppliers
    public function ShowAll(Request $req){
        $supplier = User_Info::with('Withs','Location')->where('user_role', 5)->orderBy('added_at','asc')->paginate(15);
        return response()->json([
            'status'=> true,
            'data' => $supplier,
        ], 200);
    } // End Method



    // Insert Suppliers
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required',
            "type" => 'required',
            "email" => 'required|email|unique:user__infos,user_email',
            "phone" => 'required|numeric|unique:user__infos,user_phone',
            "gender" => 'required',
            "location" => 'required',
            "address" => 'required',
            'image' => 'mimes:jpg,jpeg,png,gif|max:2048',
            'company' => 'required',
        ]);

        DB::transaction(function () use ($req) {
            // Generates Auto Increment Client Id
            $latestEmployee = User_Info::where('user_role', 5)->orderBy('user_id','desc')->first();
            $id = ($latestEmployee) ? 'S' . str_pad((intval(substr($latestEmployee->user_id, 1)) + 1), 9, '0', STR_PAD_LEFT) : 'S000000101';

            if ($req->hasFile('image') && $req->file('image')->isValid()) {
                $originalName = $req->file('image')->getClientOriginalName();
                $imageName = '('. $req->company . ')'. $id . '('. $req->name . ').' . $req->file('image')->getClientOriginalExtension();
                $imagePath = $req->file('image')->storeAs('profiles', $imageName);
                \Log::info("Image stored at: $imagePath");
            }
            else{
                $imageName = null;
            }
            
            User_Info::insert([
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
                "company_id" =>  $req->company,
            ]);
        });
        
        return response()->json([
            'status'=> true,
            'message' => 'Supplier Details Added Successfully'
        ], 200);  
    } // End Method



    // Edit Suppliers
    public function Edit(Request $req){
        $supplier = User_Info::with('Withs','Location')->findOrFail($req->id);
        $tranwith = Transaction_With::where('user_role','Supplier')->get();
        return response()->json([
            'status'=> true,
            'supplier'=> $supplier,
            'tranwith'=> $tranwith,
        ], 200);
    } // End Method



    // Update Suppliers
    public function Update(Request $req){
        $supplier = User_Info::findOrFail($req->id);

        $req->validate([
            "name" => 'required',
            "email" => ['required','email',Rule::unique('user__infos', 'user_email')->ignore($supplier->id)],
            "phone" => ['required','numeric',Rule::unique('user__infos', 'user_phone')->ignore($supplier->id)],
            "gender" => 'required',
            "address" => 'required',
            "location" => 'required',
            "type" => 'required'
        ]);

        DB::transaction(function () use ($req) {
            $supplier = User_Info::findOrFail($req->id);
            $path = 'public/profiles/'.$supplier->image;
            
            if($req->image != null){
                $req->validate([
                    "image" => 'image|mimes:jpg,jpeg,png,gif|max:2048',
                ]);

                //process the image name and store it to storage/app/public/profiles directory
                if ($req->hasFile('image') && $req->file('image')->isValid()) {
                    Storage::delete($path);
                    $imageName = '('. $supplier->company_id . ')' . $supplier->user_id. '('. $req->name . ').' . $req->file('image')->getClientOriginalExtension();
                    $imagePath = $req->file('image')->storeAs('profiles', $imageName);
                }
            }
            else{
                $imageName = $supplier->image;
            }

            $update = User_Info::findOrFail($req->id)->update([
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

        return response()->json([
            'status'=>true,
            'message' => 'Supplier Details Updated Successfully',
        ], 200);
    } // End Method



    // Delete Suppliers
    public function Delete(Request $req){
        $admin = User_Info::findOrFail($req->id);
        $path = 'public/profiles/'.$admin->image;
        Storage::delete($path);
        $admin->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Supplier Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Suppliers
    public function Search(Request $req){
        if($req->searchOption == 1){
            $supplier = User_Info::with('Withs','Location')
            ->where('user_role', 5)
            ->where('user_name', 'like','%'.$req->search.'%')
            ->orderBy('user_name','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $supplier = User_Info::with('Withs','Location')
            ->where('user_role', 5)
            ->where('user_email', 'like','%'.$req->search.'%')
            ->orderBy('user_email','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 3){
            $supplier = User_Info::with('Withs','Location')
            ->where('user_role', 5)
            ->where('user_phone', 'like','%'.$req->search.'%')
            ->orderBy('user_phone','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 4){
            $supplier = User_Info::with('Withs','Location')
            ->whereHas('Location', function ($query) use ($req) {
                $query->where('upazila', 'like', '%'.$req->search.'%');
                $query->orderBy('upazila','asc');
            })
            ->where('user_role', 5)
            ->paginate(15);
        }
        else if($req->searchOption == 5){
            $supplier = User_Info::with('Withs','Location')->where('user_role', 5)
            ->where('address', 'like', '%'.$req->search.'%')
            ->orderBy('address','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 6){
            $supplier = User_Info::with('Withs','Location')
            ->whereHas('Withs', function ($query) use ($req) {
                $query->where('tran_with_name', 'like', '%'.$req->search.'%');
                $query->orderBy('tran_with_name','asc');
            })
            ->where('user_role', 5)
            ->paginate(15);
        }
        
        return response()->json([
            'status' => true,
            'data' => $supplier,
        ], 200);
    } // End Method



    // Show Supplier Details
    public function SupplierDetails(Request $req){
        $supplier = User_Info::with('Location','Withs')->where('user_id', "=", $req->id)->first();
        $transaction = Transaction_Main::where('tran_user', "=", $req->id)->get();
        return response()->json([
            'status'=> true,
            'data'=>view('admin_setup.users.supplier.details', compact("supplier",'transaction'))->render(),
        ]);
    } // End Method
}
