<?php

namespace App\Http\Controllers\API\Backend\Admin_Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Location_Info;

class LocationController extends Controller
{
    // Show All Locations
    public function ShowAll(Request $req){
        $location = Location_Info::orderBy('added_at')->paginate(15);
        return response()->json([
            'status'=> true,
            'data' => $location,
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
        $location = Location_Info::findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'location'=> $location,
        ], 200);
    } // End Method



    // Update Locations
    public function Update(Request $req){
        $req->validate([
            "division" => 'required',
            "district"  => 'required',
            "upazila"  => 'required',
        ]);

        $update = Location_Info::findOrFail($req->id)->update([
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
        Location_Info::findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Location Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Locations
    public function Search(Request $req){
        if($req->searchOption == 1){ // Search By Division
            $location = Location_Info::where('division', 'like', '%'.$req->search.'%')
            ->orderBy('division')
            ->paginate(15);
        }
        else if($req->searchOption == 2){ // Search By District
            $location = Location_Info::where('district', 'like', '%'.$req->search.'%')
            ->orderBy('district')
            ->paginate(15);
        }
        else if($req->searchOption == 3){ // Search By Upazila
            $location = Location_Info::where('upazila', 'like', '%'.$req->search.'%')
            ->orderBy('upazila')
            ->paginate(15);
        }
        
        return response()->json([
            'status' => true,
            'data' => $location,
        ], 200);
    } // End Method



    // Get Location By Upazila
    public function Get(Request $req){
        $locations = Location_Info::where('upazila', 'like', '%'.$req->location.'%')
        ->orderBy('upazila')
        ->take(10)
        ->get();


        if($locations->count() > 0){
            $list = "";
            foreach($locations as $index => $location) {
                $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$location->id.'">'.$location->upazila.'</li>';
            }
        }
        else{
            $list = '<li>No Data Found</li>';
        }
        return $list;
    } // End Method


    
    // Get Location By Division
    public function GetLocationByDivision(Request $req){
        $locations = Location_Info::where('upazila', 'like', '%'.$req->location.'%')
        ->where('division', '=', $req->division)
        ->orderBy('upazila')
        ->take(10)
        ->get();


        if($locations->count() > 0){
            $list = "";
            foreach($locations as $index => $location) {
                $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$location->id.'">'.$location->upazila.'</li>';
            }
        }
        else{
            $list = '<li>No Data Found</li>';
        }
        return $list;
    } // End Method
}
