<?php

namespace App\Http\Controllers\Api\Backend\Setup\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Nursing_Station;

class NursingStationController extends Controller
{
    // Show All Nursing station
    public function ShowAll(Request $req){
        $data = Nursing_Station::on('mysql_second')->paginate(15);
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Nursing station
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required',
            "floor" => 'required|numeric'
        ]);

        Nursing_Station::on('mysql_second')->insert([
            "name" => $req->name,
            "floor" => $req->floor,
        ]);
        
        return response()->json([
            'status'=> true,
            'message' => ' Added Successfully'
        ], 200);  
    } // End Method



    // Edit Nursing station
    public function Edit(Request $req){
        $data = Nursing_Station::on('mysql_second')->findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'data'=> $data,
        ], 200);
    } // End Method



    // Update Nursing station
    public function Update(Request $req){
        $mainhead = Nursing_Station::on('mysql_second')->findOrFail($req->id);
        
        $req->validate([
            "name" => 'required',
            "floor"=> 'required'
        ]);

        $update = Nursing_Station::on('mysql_second')->findOrFail($req->id)->update([
            "name" => $req->name,
            "floor" => $req->floor,
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'MainHead Updated Successfully',
            ], 200); 
        }
    } // End Method



    // Delete Nursing station
    public function Delete(Request $req){
        Nursing_Station::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'MainHead Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Nursing station
    public function Search(Request $req){
        if($req->searchOption == 1){ // Search By Name
            $data = Nursing_Station::on('mysql_second')
            ->where('name', 'like', $req->search.'%')
            ->orderBy('name')
            ->paginate(15);
        }
        else if($req->searchOption == 2){ // Search By Floor
            $data = Nursing_Station::on('mysql_second')
            ->where('floor', 'like', $req->search.'%')
            ->orderBy('name')
            ->paginate(15);
        }

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Get Nursing station
    public function Get(Request $req){
        $nursing_stations = Nursing_Station::on('mysql_second')
        ->where('name', 'like', $req->nursing_station.'%')
        ->orderBy('name')
        ->take(10)
        ->get();

        $list = "<ul>";
            if($nursing_stations->count() > 0){
                foreach($nursing_stations as $index => $nursing_station) {
                    $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$nursing_station->id.'">'.$nursing_station->name.'</li>';
                }
            }
            else{
                $list .= '<li>No Data Found</li>';
            }
        $list .= "</ul>";

        return $list;
    } 
}
