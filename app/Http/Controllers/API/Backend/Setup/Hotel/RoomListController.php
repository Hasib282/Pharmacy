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



    //delete Room_List
    public function Delete(Request $req){
        Room_List::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message'=> 'Room List data Deleted Successfully'
        ], 200);
    } // End Method
}
