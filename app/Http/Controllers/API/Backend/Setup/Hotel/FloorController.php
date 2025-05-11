<?php

namespace App\Http\Controllers\API\Backend\Setup\Hotel;

use App\Http\Controllers\Controller;
use App\Models\Floor;
use Illuminate\Http\Request;

class FloorController extends Controller
{


    // Show all floors
    public function Show(Request $req){
        $data = Floor::on('mysql_second')->get();

        return response()->json([
            'status'=>true,
            'data'=>$data
        ],200);
    }



    //Insert new floor
    public function Insert(Request $req){
        $req-> validate([
            "floor_name" => 'required|string|max:255',
            "number_of_rooms" => 'required|integer',
            "starting_floor" => 'required',

        ]);

        $data= Floor::on('mysql_second')->create([
            "floor_name" => $req->floor_name,
            "no_of_rooms" => $req->number_of_rooms,
            "starting_floor_no" => $req->starting_floor,
            "action" => $req->action,
        ]);
        return response()->json([
            'status'=>true,
            'message'=>'Floor Added Successfully',
            'data'=>$data
        ],200);
    }


    //update floor

     public function Update(Request $req){
        $data = Floor::on('mysql_second')->findOrFail($req->id);
        
        $req->validate([
            "floor_name" => 'required|string|max:255',
            "number_of_rooms" => 'required|integer',
            "starting_floor" => 'required',
        ]);

        $update = $data->update([
            "floor_name" => $req->floor_name,
            "no_of_rooms" => $req->number_of_rooms,
            "starting_floor_no" => $req->starting_floor,
            "action" => $req->action,
            "updated_at" => now()
        ]);

        $updatedData = Floor::on('mysql_second')->findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Floor Updated Successfully',
                "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method
    
    //delete floor
    public function Delete(Request $req){
        Floor::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message'=> 'Floor data Deleted Successfully'
        ], 200);
    } // End Method

}
