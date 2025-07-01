<?php

namespace App\Http\Controllers\API\Backend\Setup;

use App\Http\Controllers\Controller;
use App\Models\Floor;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    // Show All Floors
    public function Show(Request $req){
        $data = Floor::on('mysql_second')->get();

        return response()->json([
            'status'=>true,
            'data'=>$data
        ],200);
    } // End Method



    // Insert New Floor
    public function Insert(Request $req){
        $req-> validate([
            "name" => 'required|string|max:255',
        ]);

        $data= Floor::on('mysql_second')->create([
            "name" => $req->name,
        ]);

        return response()->json([
            'status'=>true,
            'message'=>'Floor Added Successfully',
            'data'=>$data
        ],200);
    } // End Method



    // Update Floor
    public function Update(Request $req){
        $data = Floor::on('mysql_second')->findOrFail($req->id);
        
        $req->validate([
            "name" => 'required|string|max:255',
        ]);

        $update = $data->update([
            "name" => $req->name,
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
    


    // Delete Floor
    public function Delete(Request $req){
        Floor::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message'=> 'Floor Deleted Successfully'
        ], 200);
    } // End Method



    // Delete Floor Status
    public function DeleteStatus(Request $req){
        $data = Floor::on('mysql_second')->findOrFail($req->id);
        $data->update(['status' => $data->status == 0 ? 1 : 0]);
        
        $updatedData = Floor::on('mysql_second')->findOrFail($req->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Floor Deleted Successfully',
            'updatedData' => $updatedData
        ], 200);
    } // End Method



    // Get Transaction Main Head
    public function Get(){
        $data = Floor::on('mysql_second')->get();
        
        $list = "<ul>";
            if($data->count() > 0){
                foreach($data as $index => $item) {
                    $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$item->id.'">'.$item->name.'</li>';
                }
            }
            else{
                $list .= '<li>No Data Found</li>';
            }
        $list .= "</ul>";

        return $list;
    } // End Method
}
