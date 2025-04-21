<?php

namespace App\Http\Controllers\API\Backend\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Location_Info;

class LocationController extends Controller
{
    // Show All Locations
    public function ShowAll(Request $req){
        $data = Location_Info::on('mysql')->orderBy('added_at')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Locations
    public function Insert(Request $req){
        $req->validate([
            "division" => 'required',
            "district" => 'required',
            "upazila" => 'required',
        ]);

        $insert = Location_Info::insert([
            "division" => $req->division,
            "district" => $req->district,
            "upazila" => $req->upazila,
        ]);
        
        return response()->json([
            'status'=> true,
            'message' => 'Location Added Successfully'
        ], 200);  
    } // End Method



    // Edit Locations
    public function Edit(Request $req){
        $data = Location_Info::on('mysql')->findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'data'=> $data,
        ], 200);
    } // End Method



    // Update Locations
    public function Update(Request $req){
        $data = Location_Info::on('mysql')->findOrFail($req->id);

        $req->validate([
            "division" => 'required',
            "district"  => 'required',
            "upazila"  => 'required',
        ]);

        $update = $data->update([
            "district" => $req->district,
            "division" => $req->division,
            "upazila" => $req->upazila,
            "updated_at" => now()
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Location Updated Successfully',
            ], 200); 
        }
    } // End Method



    // Delete Locations
    public function Delete(Request $req){
        Location_Info::on('mysql')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Location Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Locations
    public function Search(Request $req){
        if($req->searchOption == 1){ // Search By Division
            $data = Location_Info::on('mysql')->where('division', 'like', '%'.$req->search.'%')
            ->orderBy('division')
            ->paginate(15);
        }
        else if($req->searchOption == 2){ // Search By District
            $data = Location_Info::on('mysql')->where('district', 'like', '%'.$req->search.'%')
            ->orderBy('district')
            ->paginate(15);
        }
        else if($req->searchOption == 3){ // Search By Upazila
            $data = Location_Info::on('mysql')->where('upazila', 'like', '%'.$req->search.'%')
            ->orderBy('upazila')
            ->paginate(15);
        }
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Get Location By Upazila
    public function Get(Request $req){
        $data = Location_Info::on('mysql')
        ->where('upazila', 'like', $req->location.'%')
        ->when($req->division != 'undefined', function ($query) use ($req) {
            $query->where('division', $req->division);
        })
        ->orderBy('upazila')
        ->take(10)
        ->get();

        $list = "<ul>";
            if($data->count() > 0){
                foreach($data as $index => $item) {
                    $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$item->id.'">'.$item->upazila.'</li>';
                }
            }
            else{
                if($req->division != 'undefined'){
                    $list .= '<li>Select Division First</li>';
                }
                else{
                    $list .= '<li>No Data Found</li>';
                }
            }
        $list .= "</ul>";

        return $list;
    } // End Method
}
