<?php

namespace App\Http\Controllers\API\Backend\Setup\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Item_Manufacturer;

class ManufacturerController extends Controller
{
    // Show All Item/Product MAnufacturer
    public function Show(Request $req){
        $type = GetTranType($req->segment(2));
        $data = filterByCompany(Item_Manufacturer::on('mysql')->where('type_id', $type))->orderBy('added_at','asc')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Item/Product MAnufacturer
    public function Insert(Request $req){
        $type = GetTranType($req->segment(2));
        $req->validate([
            'name' => 'required',
        ]);
 
        $insert = Item_Manufacturer::on('mysql')->create([
            'manufacturer_name' => $req->name,
            'company_id' => $req->company,
            'type_id'=> $type,
        ]);

        $data = Item_Manufacturer::on('mysql')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Manufacturer Added Successfully',
            "data" => $data,
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

        $updatedData = Item_Manufacturer::on('mysql')->findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Manufacturer Updated Successfully',
                "updatedData" => $updatedData,
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



    // Get Manufacturer
    public function Get(Request $req){
        $type = GetTranType($req->type);
        $data = filterByCompany(
                            Item_Manufacturer::on('mysql')
                            ->where('type_id', $type)
                            ->where('manufacturer_name', 'like', '%'.$req->manufacturer.'%')
                        )
                        ->orderBy('manufacturer_name','asc')
                        ->take(10)
                        ->get();
        
        $list = "<ul>";
            if($data->count() > 0){
                foreach($data as $index => $item) {
                    $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$item->id.'">'.$item->manufacturer_name.'</li>';
                }
            }
            else{
                $list .= '<li>No Data Found</li>';
            }
        $list .= "</ul>";

        return $list;
    } // End Method
}
