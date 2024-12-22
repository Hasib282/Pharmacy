<?php

namespace App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Item_Manufacturer;

class PharmacyManufacturerController extends Controller
{
    // Show All Item/Product MAnufacturer
    public function ShowAll(Request $req){
        $manufacturer = Item_Manufacturer::on('mysql')->where('type_id', '6')->orderBy('added_at','asc')->paginate(15);
        return response()->json([
            'status'=> true,
            'data' => $manufacturer,
        ], 200);
    } // End Method



    // Insert Item/Product MAnufacturer
    public function Insert(Request $req){
        $req->validate([
            'name' => 'required',
        ]);
 
        Item_Manufacturer::on('mysql')->insert([
            'manufacturer_name' => $req->name,
            'type_id'=> '6',
        ]);
        
        return response()->json([
            'status'=> true,
            'message' => 'Manufacturer Added Successfully'
        ], 200);  
    } // End Method



    // Edit Item/Product MAnufacturer
    public function Edit(Request $req){
        $manufacturer = Item_Manufacturer::on('mysql')->where('id', $req->id)->first();
        return response()->json([
            'status'=> true,
            'manufacturer'=> $manufacturer,
        ], 200);
    } // End Method



    // Update Item/Product MAnufacturer
    public function Update(Request $req){
        $req->validate([
            'name' => 'required',
        ]);

        $update = Item_Manufacturer::on('mysql')->findOrFail($req->id)->update([
            'manufacturer_name' => $req->name,
            "updated_at" => now()
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Manufacturer Updated Successfully',
            ], 200); 
        }
    } // End Method



    // Delete Item/Product MAnufacturer
    public function Delete(Request $req){
        Item_Manufacturer::on('mysql')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Manufacturer Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Item/Product MAnufacturer
    public function Search(Request $req){
        $manufacturer = Item_Manufacturer::on('mysql')->where('type_id', '6')
        ->where('manufacturer_name', 'like', '%'.$req->search.'%')
        ->orderBy('manufacturer_name','asc')
        ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $manufacturer,
        ], 200);
    } // End Method



    // Get Manufacturer
    public function Get(Request $req){
        $manufacturers = Item_Manufacturer::on('mysql')->where('type_id', '6')
        ->where('manufacturer_name', 'like', '%'.$req->manufacturer.'%')
        ->orderBy('manufacturer_name','asc')
        ->take(10)
        ->get();

        if($manufacturers->count() > 0){
            $list = "";
            foreach($manufacturers as $index => $manufacturer) {
                $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$manufacturer->id.'">'.$manufacturer->manufacturer_name.'</li>';
            }
        }
        else{
            $list = '<li>No Data Found</li>';
        }
        return $list;
    } // End Method
}
