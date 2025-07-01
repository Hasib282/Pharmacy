<?php

namespace App\Http\Controllers\Api\Backend\Setup\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Nursing_Station;

class NursingStationController extends Controller
{
    // Show All Nursing station
    public function Show(Request $req){
        $data = Nursing_Station::on('mysql_second')->with('Floor')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Nursing station
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required',
            "floor" => 'required|exists:mysql_second.floors,id'
        ]);

        $insert = Nursing_Station::on('mysql_second')->create([
            "name" => $req->name,
            "floor" => $req->floor,
        ]);

        $data = Nursing_Station::on('mysql_second')->with('Floor')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Nursing station Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method



    // Update Nursing station
    public function Update(Request $req){
        $data = Nursing_Station::on('mysql_second')->findOrFail($req->id);
        
        $req->validate([
            "name" => 'required',
            "floor"=> 'required|exists:mysql_second.floors,id'
        ]);

        $update = $data->update([
            "name" => $req->name,
            "floor" => $req->floor,
        ]);

        $updatedData = Nursing_Station::on('mysql_second')->with('Floor')->findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Nursing station Updated Successfully',
                "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method



    // Delete Nursing Station
    public function Delete(Request $req){
        Nursing_Station::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Nursing Station Deleted Successfully',
        ], 200); 
    } // End Method



    // Delete Nursing Station Status
    public function DeleteStatus(Request $req){
        $data = Nursing_Station::on('mysql_second')->findOrFail($req->id);
        $data->update(['status' => $data->status == 0 ? 1 : 0]);
        
        $updatedData = Nursing_Station::on('mysql_second')->with('Floor')->findOrFail($req->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Nursing Station Deleted Successfully',
            'updatedData' => $updatedData
        ], 200);
    } // End Method



    // Get Nursing station
    public function Get(Request $req){
        $data = Nursing_Station::on('mysql_second')
        ->with('Floor')
        ->where('name', 'like', $req->nursing_station.'%')
        ->orderBy('name')
        ->get();

        $list = "<ul>";
            if($data->count() > 0){
                foreach($data as $index => $item) {
                    $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$item->id.'">'.$item->name.'('.$item->floor.')</li>';
                }
            }
            else{
                $list .= '<li>No Data Found</li>';
            }
        $list .= "</ul>";

        return $list;
    } 
}
