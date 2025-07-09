<?php

namespace App\Http\Controllers\API\Backend\Setup\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Item_Unit;

class UnitController extends Controller
{
    // Show All Item/Product Unit
    public function Show(Request $req){
        $type = GetTranType($req->segment(2));
        $data = filterByCompany(Item_Unit::on('mysql_second')->where('type_id', $type))->orderBy('added_at','asc')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Item/Product Unit
    public function Insert(Request $req){
        $type = GetTranType($req->segment(2));
        $req->validate([
            'name' => 'required',
        ]);

        $insert = Item_Unit::on('mysql_second')->create([
            'unit_name' => $req->name,
            'company_id' => $req->company,
            'type_id'=> $type,
        ]);

        $data = Item_Unit::on('mysql_second')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Unit Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method



    // Update Item/Product Unit
    public function Update(Request $req){
        $req->validate([
            'name' => 'required',
        ]);

        $update = Item_Unit::on('mysql_second')->findOrFail($req->id)->update([
            'unit_name' => $req->name,
            "updated_at" => now()
        ]);

        $updatedData = Item_Unit::on('mysql_second')->findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Unit Updated Successfully',
                "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method



    // Delete Item/Product Unit
    public function Delete(Request $req){
        Item_Unit::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Unit Deleted Successfully',
        ], 200); 
    } // End Method



    // Delete Item/Product Unit Status
    public function DeleteStatus(Request $req){
        $data = Item_Unit::on('mysql_second')->findOrFail($req->id);
        $data->update(['status' => $data->status == 0 ? 1 : 0]);
        
        $updatedData = Item_Unit::on('mysql_second')->findOrFail($req->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Item/Product Unit Deleted Successfully',
            'updatedData' => $updatedData
        ], 200);
    } // End Method



    // Get Unit
    public function Get(Request $req){
        $type = GetTranType($req->type);
        $data = filterByCompany(
                    Item_Unit::on('mysql_second')
                    ->where('type_id', $type)
                    ->where('unit_name', 'like', '%'.$req->unit.'%')
                )
                ->orderBy('unit_name','asc')
                ->take(10)
                ->get();

        $list = "<ul>";
            if($data->count() > 0){
                foreach($data as $index => $item) {
                    $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$item->id.'">'.$item->unit_name.'</li>';
                }
            }
            else{
                $list .= '<li>No Data Found</li>';
            }
        $list .= "</ul>";

        return $list;
    } // End Method
}
