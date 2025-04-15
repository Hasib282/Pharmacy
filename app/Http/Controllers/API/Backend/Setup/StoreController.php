<?php

namespace App\Http\Controllers\API\Backend\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Store;
use App\Models\Location_Info;

class StoreController extends Controller
{
    // Show All Stores
    public function ShowAll(Request $req){
        $data = Store::on('mysql_second')->with('Location')->orderBy('added_at')->paginate(15);
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
        $data = Store::on('mysql_second')->with('Location')->where('id', $req->id)->first();
        return response()->json([
            'status'=> true,
            'data'=> $data,
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
            $data = Store::on('mysql_second')->with('Location')
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
            $data = Store::on('mysql_second')
            ->with('Location')
            ->whereIn('location_id', $locations)
            ->where('division', 'like', $req->division.'%')
            ->paginate(15);
        }
        else if($req->searchOption == 3){ // Search By Address
            $data = Store::on('mysql_second')->with('Location')
            ->where('address', 'like', '%'.$req->search.'%')
            ->where('division', 'like', $req->division.'%')
            ->orderBy('store_name')
            ->paginate(15);
        }
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Get Store By Name
    public function Get(Request $req){
        $data = Store::on('mysql_second')
        ->where('store_name', 'like', $req->store.'%')
        ->orderBy('store_name')
        ->take(10)
        ->get();

        $list = "<ul>";
            if($data->count() > 0){
                foreach($data as $index => $item) {
                    $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$item->id.'">'.$item->store_name.'</li>';
                }
            }
            else{
                $list .= '<li>No Data Found</li>';
            }
        $list .= "</ul>";

        return $list;
    } // End Method
}
