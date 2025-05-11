<?php

namespace App\Http\Controllers\API\Backend\Setup\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room_Catagory;

class RoomCatagoryController extends Controller
{
 
      // Show all room list
    public function Show(Request $req){
        $data = Room_Catagory::on('mysql_second')->get();

        return response()->json([
            'status'=>true,
            'data'=>$data
        ],200);
    }

    
     //Insert new floor
    public function Insert(Request $req){
        $req-> validate([
            "name" => 'required|string|max:255',
            

        ]);

        $data= Room_Catagory::on('mysql_second')->create([
            "name" => $req->name,
           
        ]);
        return response()->json([
            'status'=>true,
            'message'=>'Room Added Successfully',
            'data'=>$data
        ],200);
    }


    
    // Update Room Category
    public function Update(Request $req){
        $data = Room_Catagory::on('mysql_second')->findOrFail($req->id);
        
        $req->validate([
           "update_name" => 'required|string|max:255',
        ]);

        $update = $data->update([
            "name" => $req->update_name,
            "updated_at" => now()
        ]);

        $updatedData = Room_Catagory::on('mysql_second')->findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Room Category Updated Successfully',
                "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method


        //delete room catagory
    public function Delete(Request $req){
        Room_Catagory::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message'=> 'Room Catagory data Deleted Successfully'
        ], 200);
    }

}
