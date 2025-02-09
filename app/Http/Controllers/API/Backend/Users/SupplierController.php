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
use App\Models\Transaction_With;
use App\Models\Transaction_Main;
use App\Models\Location_Info;

class SupplierController extends Controller
{
    // Show All Suppliers
    public function ShowAll(Request $req){
        $segments = [
            'transaction' => 1,
            'inventory' => 5,
            'pharmacy' => 6,
        ];

        $type = $segments[$req->segment(2)] ?? null;

        $supplier = User_Info::on('mysql_second')
        ->with('Withs', 'Location')
        ->whereHas('Withs', function ($q) use ($type) {
            $q->where('tran_type', $type);
        })
        ->where('user_role', 5)
        ->orderBy('added_at', 'asc')
        ->paginate(15);

        return response()->json([
            'status'=> true,
            'data' => $supplier,
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

        DB::transaction(function () use ($req) {
            // Calling UserHelper Functions
            $id = GenerateUserId(5, 'SU');
            $imageName = StoreUserImage($req, $id);
            
            User_Info::on('mysql_second')->insert([
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
        });
        
        return response()->json([
            'status'=> true,
            'message' => 'Supplier Details Added Successfully'
        ], 200);  
    } // End Method



    // Edit Suppliers
    public function Edit(Request $req){
        $segments = [
            'transaction' => 1,
            'inventory' => 5,
            'pharmacy' => 6,
        ];

        $type = $segments[$req->segment(2)] ?? null;

        $supplier = User_Info::on('mysql_second')->with('Withs','Location')->findOrFail($req->id);
        $tranwith = Transaction_With::on('mysql_second')->where('tran_type', $type)->where('user_role','5')->get();
        return response()->json([
            'status'=> true,
            'supplier'=> $supplier,
            'tranwith'=> $tranwith,
        ], 200);
    } // End Method



    // Update Suppliers
    public function Update(Request $req){
        $supplier = User_Info::on('mysql_second')->findOrFail($req->id);

        $req->validate([
            "name" => 'required',
            "email" => 'required|email',
            "phone" => 'required|numeric',
            "gender" => 'required',
            "address" => 'required',
            "location" => 'required|exists:mysql.location__infos,id',
            "type" => 'required|exists:mysql_second.transaction__withs,id'
        ]);

        DB::transaction(function () use ($req, $supplier) {
            $imageName = UpdateUserImage($req, $supplier->image, null, $supplier->user_id);

            $update = User_Info::on('mysql_second')->findOrFail($req->id)->update([
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
        $supplier = User_Info::on('mysql_second')->findOrFail($req->id);
        if($supplier->image){
            Storage::disk('public')->delete($supplier->image);
        }
        $supplier->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Supplier Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Suppliers
    public function Search(Request $req){
        $segments = [
            'transaction' => 1,
            'inventory' => 5,
            'pharmacy' => 6,
        ];

        $type = $segments[$req->segment(2)] ?? null;

        $query = User_Info::on('mysql_second')
        ->with('Withs', 'Location')
        ->where('user_role', 5)
        ->whereHas('Withs', function ($q) use ($type) {
            $q->where('tran_type', $type);
        });

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
                // Fetch matching locations from the 'mysql' database
                $locations = Location_Info::on('mysql')
                ->where('upazila', 'like', $req->search.'%')
                ->orderBy('upazila')
                ->pluck('id');

                $query->whereIn('loc_id', $locations);
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
        $supplier = $query->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $supplier,
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
