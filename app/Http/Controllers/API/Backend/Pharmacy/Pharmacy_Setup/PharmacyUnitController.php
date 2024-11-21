<?php

namespace App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Item_Unit;

class PharmacyUnitController extends Controller
{
    // Show All Item/Product Unit
    public function ShowAll(Request $req){
        $unit = Item_Unit::where('type_id', '6')->orderBy('added_at','asc')->paginate(15);
        return response()->json([
            'status'=> true,
            'data' => $unit,
        ], 200);
    } // End Method



    // Insert Item/Product Unit
    public function Insert(Request $req){
        $req->validate([
            'name' => 'required',
        ]);

        Item_Unit::insert([
            'unit_name' => $req->name,
            'type_id'=> '6',
        ]);
        
        return response()->json([
            'status'=> true,
            'message' => 'Unit Added Successfully'
        ], 200);  
    } // End Method



    // Edit Item/Product Unit
    public function Edit(Request $req){
        $unit = Item_Unit::where('id', $req->id)->first();
        return response()->json([
            'status'=> true,
            'unit'=> $unit,
        ], 200);
    } // End Method



    // Update Item/Product Unit
    public function Update(Request $req){
        $req->validate([
            'name' => 'required',
        ]);

        $update = Item_Unit::findOrFail($req->id)->update([
            'unit_name' => $req->name,
            "updated_at" => now()
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Unit Updated Successfully',
            ], 200); 
        }
    } // End Method



    // Delete Item/Product Unit
    public function Delete(Request $req){
        Item_Unit::findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Unit Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Item/Product Unit
    public function Search(Request $req){
        $unit = Item_Unit::where('type_id', '6')
        ->where('unit_name', 'like', '%'.$req->search.'%')
        ->orderBy('unit_name','asc')
        ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $unit,
        ], 200);
    } // End Method



    // Get Unit
    public function Get(Request $req){
        $units = Item_Unit::where('type_id', '6')
        ->where('unit_name', 'like', '%'.$req->unit.'%')
        ->orderBy('unit_name','asc')
        ->take(10)
        ->get();


        if($units->count() > 0){
            $list = "";
            foreach($units as $index => $unit) {
                $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$unit->id.'">'.$unit->unit_name.'</li>';
            }
        }
        else{
            $list = '<li>No Data Found</li>';
        }
        return $list;
    } // End Method
}
