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
        $data = Nursing_Station::on('mysql_second')->get();
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

        $insert = Nursing_Station::on('mysql_second')->create([
            "name" => $req->name,
            "floor" => $req->floor,
        ]);

        $data = Nursing_Station::on('mysql_second')->findOrFail($insert->id);
        
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
            "floor"=> 'required'
        ]);

        $update = $data->update([
            "name" => $req->name,
            "floor" => $req->floor,
        ]);

        $updatedData = Nursing_Station::on('mysql_second')->findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Nursing station Updated Successfully',
                "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method



    // Delete Nursing station
    public function Delete(Request $req){
        Nursing_Station::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Nursing station Deleted Successfully',
        ], 200); 
    } // End Method



    // Get Nursing station
    public function Get(Request $req){
        $data = Nursing_Station::on('mysql_second')
        ->where('name', 'like', $req->nursing_station.'%')
        ->orderBy('name')
        ->take(10)
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
