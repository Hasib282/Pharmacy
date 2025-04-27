<?php

namespace App\Http\Controllers\API\Backend\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Store;
use App\Models\Location_Info;

class StoreController extends Controller
{
    // Show All Stores
    public function Show(Request $req){
        $data = Store::on('mysql_second')->with('Location')->orderBy('added_at')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Stores
    public function Insert(Request $req){
        $req->validate([
            'store_name' => 'required',
            'division' => 'required',
            'location' => 'required|exists:mysql.location__infos,id',
        ]);
 
        $insert = Store::on('mysql_second')->create([
            'store_name' => $req->store_name,
            'division' => $req->division,
            'location_id' => $req->location,
            'address' => $req->address,
        ]);

        $data = Store::on('mysql_second')->with('Location')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Store Details Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method



    // Update Stores
    public function Update(Request $req){
        $data = Store::on('mysql_second')->findOrFail($req->id);

        $req->validate([
            'store_name' => 'required',
            'division' => 'required',
            'location' => 'required|exists:mysql.location__infos,id',
        ]);

        $update = $data->update([
            'store_name' => $req->store_name,
            'division' => $req->division,
            'location_id' => $req->location,
            'address' => $req->address,
            "updated_at" => now()
        ]);

        $updatedData = Store::on('mysql_second')->with('Location')->findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Store Details Updated Successfully',
                "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method



    // Delete Stores
    public function Delete(Request $req){
        Store::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Store Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Get Store By Name
    public function Get(Request $req){
        $data = Store::on('mysql_second')
        ->select('id','store_name')
        ->orderBy('store_name')
        ->get();

        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method
}
