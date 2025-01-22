<?php

namespace App\Http\Controllers\API\Backend\Admin_Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Store;
use App\Models\Location_Info;

class StoreController extends Controller
{
    // Show All Stores
    public function ShowAll(Request $req){
        $store = Store::on('mysql_second')->with('Location')->orderBy('added_at')->paginate(15);
        return response()->json([
            'status'=> true,
            'data' => $store,
        ], 200);
    } // End Method



    // Insert Stores
    public function Insert(Request $req){
        $req->validate([
            'store_name' => 'required',
            'division' => 'required',
            'location' => 'required|exists:mysql.location__infos,id',
        ]);
 
        Store::on('mysql_second')->insert([
            'store_name' => $req->store_name,
            'division' => $req->division,
            'location_id' => $req->location,
            'address' => $req->address,
        ]);
        
        return response()->json([
            'status'=> true,
            'message' => 'Store Details Added Successfully'
        ], 200);  
    } // End Method



    // Edit Stores
    public function Edit(Request $req){
        $store = Store::on('mysql_second')->with('Location')->where('id', $req->id)->first();
        return response()->json([
            'status'=> true,
            'store'=> $store,
        ], 200);
    } // End Method



    // Update Stores
    public function Update(Request $req){
        $req->validate([
            'store_name' => 'required',
            'division' => 'required',
            'location' => 'required|exists:mysql.location__infos,id',
        ]);

        $update = Store::on('mysql_second')->findOrFail($req->id)->update([
            'store_name' => $req->store_name,
            'division' => $req->division,
            'location_id' => $req->location,
            'address' => $req->address,
            "updated_at" => now()
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Store Details Updated Successfully',
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



    // Search Stores
    public function Search(Request $req){
        if($req->searchOption == 1){ // Search By Store Name
            $store = Store::on('mysql_second')->with('Location')
            ->where('store_name', 'like', '%'.$req->search.'%')
            ->where('division', 'like','%'.$req->division.'%')
            ->orderBy('store_name')
            ->paginate(15);
        }
        else if($req->searchOption == 2){ // Search By Upazila/Location
            // Fetch matching locations from the 'mysql' database
            $locations = Location_Info::on('mysql')
            ->where('upazila', 'like', $req->search.'%')
            ->orderBy('upazila')
            ->pluck('id');

            // Fetch stores from the 'mysql_second' database using the location IDs
            $store = Store::on('mysql_second')
            ->with('Location')
            ->whereIn('location_id', $locations)
            ->where('division', 'like', $req->division.'%')
            ->paginate(15);
        }
        else if($req->searchOption == 3){ // Search By Upazila/Location
            $store = Store::on('mysql_second')->with('Location')
            ->where('address', 'like', $req->search.'%')
            ->where('division', 'like', $req->division.'%')
            ->orderBy('store_name')
            ->paginate(15);
        }
        
        return response()->json([
            'status' => true,
            'data' => $store,
        ], 200);
    } // End Method



    // Get Store By Name
    public function Get(Request $req){
        $stores = Store::on('mysql_second')->where('store_name', 'like', $req->store.'%')
        ->orderBy('store_name')
        ->take(10)
        ->get();

        if($stores->count() > 0){
            $list = "";
            foreach($stores as $index => $store) {
                $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$store->id.'">'.$store->store_name.'</li>';
            }
        }
        else{
            $list = '<li>No Data Found</li>';
        }
        return $list;
    } // End Method
}
