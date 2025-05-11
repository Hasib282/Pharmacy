<?php

namespace App\Http\Controllers\API\Backend\Setup\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room_List;

class RoomListController extends Controller
{
   
      // Show all room list
    public function Show(Request $req){
        $data = Room_List::on('mysql_second')->get();

        return response()->json([
            'status'=>true,
            'data'=>$data
        ],200);
    }



      //Insert new floor
    public function Insert(Request $req){
        $req-> validate([
            "room_number" => 'required',
            "room_catagory" => 'required',
            "floor" => 'required',
            "price" => 'required',
            "capacity" => 'required',
            

        ]);

        $data= Room_List::on('mysql_second')->create([
            "room_number" => $req->room_number,
            "room_catagory" => $req->room_catagory,
            "floor" => $req->floor,
            "price" => $req->price,
            "capacity" => $req->capacity,
           
        ]);
        return response()->json([
            'status'=>true,
            'message'=>'Room List Added Successfully',
            'data'=>$data
        ],200);
    }


        //Update Room_List
    public function Update(Request $req){
        $data = Room_List::on('mysql_second')->findOrFail($req->id);
        
        $req-> validate([
            "update_room_number" => 'required',
            "update_room_catagory" => 'required',
            "update_floor" => 'required',
            "update_price" => 'required',
            "update_capacity" => 'required',
        ]);

        $update = $data->update([
            "room_number" => $req->update_room_number,
            "room_catagory" => $req->update_room_catagory,
            "floor" => $req->update_floor,
            "price" => $req->update_price,
            "capacity" => $req->update_capacity,
            "updated_at" => now()
        ]);

        $updatedData = Room_List::on('mysql_second')->findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Room List Updated Successfully',
                "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method



    //delete Room_List
    public function Delete(Request $req){
        Room_List::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message'=> 'Room List data Deleted Successfully'
        ], 200);
    } // End Method
}
