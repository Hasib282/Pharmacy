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

        //delete room catagory
    public function Delete(Request $req){
        Room_Catagory::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message'=> 'Room_Catagory data Deleted Successfully'
        ], 200);
    }

}
