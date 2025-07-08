<?php

namespace App\Http\Controllers\API\Backend\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Corporate;

class CorporateController extends Controller
{
     // Show All corporate
    public function Show(Request $req){
        $data = Corporate::on('mysql_second')->orderBy('added_at')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert corporate
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required',
            "price" => 'required',
        ]);

        $insert = Corporate::on('mysql_second')->create([
            "name" => $req->name,
            "discount" => $req->price,
        ]);

        $data = Corporate::on('mysql_second')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'corporate Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method



    // Update corporate
    public function Update(Request $req){
        $data = Corporate::on('mysql_second')->findOrFail($req->id);
        
        $req->validate([
            "name" => 'required',
            "price"=> 'required',
        ]);

        $update = $data->update([
            "name" => $req->name,
            "discount" => $req->price,
        ]);

        $updatedData = Corporate::on('mysql_second')->findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'corporate Updated Successfully',
                "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method



    // Delete corporate
    public function Delete(Request $req){
        Corporate::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'corporate Deleted Successfully',
        ], 200); 
    } // End Method



    // Delete corporate Status
    public function DeleteStatus(Request $req){
        $data = Corporate::on('mysql_second')->findOrFail($req->id);
        $data->update(['status' => $data->status == 0 ? 1 : 0]);
        
        $updatedData = Corporate::on('mysql_second')->findOrFail($req->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'corporate Details Deleted Successfully',
            'updatedData' => $updatedData
        ], 200);
    } // End Method



    // Get corporate
    public function Get(Request $req){
        $data = Corporate::on('mysql_second')
        ->where('name', 'like', $req->corporate.'%')
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
