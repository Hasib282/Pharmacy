<?php

namespace App\Http\Controllers\API\Backend\HR_Setup\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Models\User_Info;
use App\Models\Attendence;
use App\Models\Pay_Roll_Setup;
use App\Models\Transaction_With;
use App\Models\Employee_Personal_Detail;
use App\Models\Employee_Training_Detail;
use App\Models\Employee_Education_Detail;
use App\Models\Employee_Experience_Detail;
use App\Models\Employee_Organization_Detail;

class AttendenceController extends Controller
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
}
