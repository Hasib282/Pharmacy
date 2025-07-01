<?php

namespace App\Http\Controllers\API\Backend\Setup\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Item_Form;

class FormController extends Controller
{
    // Show All Item/Product Form
    public function Show(Request $req){
        $type = GetTranType($req->segment(2));
        $data = filterByCompany(Item_Form::on('mysql')->where('type_id', $type))->orderBy('added_at','asc')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Item/Product Form
    public function Insert(Request $req){
        $type = GetTranType($req->segment(2));
        $req->validate([
            'name' => 'required',
        ]);
 
        $insert = Item_Form::on('mysql')->create([
            'form_name' => $req->name,
            'company_id' => $req->company,
            'type_id'=> $type,
        ]);

        $data = Item_Form::on('mysql')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Item/Product Form Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method



    // Update Item/Product Form
    public function Update(Request $req){
        $req->validate([
            'name' => 'required',
        ]);

        $update = Item_Form::on('mysql')->findOrFail($req->id)->update([
            'form_name' => $req->name,
            "updated_at" => now()
        ]);

        $updatedData = Item_Form::on('mysql')->findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Item/Product Form Updated Successfully',
                "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method



    // Delete Item/Product Form
    public function Delete(Request $req){
        Item_Form::on('mysql')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Item/Product Form Deleted Successfully',
        ], 200); 
    } // End Method



    // Delete Item/Product Form Status
    public function DeleteStatus(Request $req){
        $data = Item_Form::on('mysql')->findOrFail($req->id);
        $data->update(['status' => $data->status == 0 ? 1 : 0]);
        
        $updatedData = Item_Form::on('mysql')->findOrFail($req->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Item/Product Form Deleted Successfully',
            'updatedData' => $updatedData
        ], 200);
    } // End Method



    // Get Item/Product Form
    public function Get(Request $req){
        $type = GetTranType($req->type);
        $data = filterByCompany(
                    Item_Form::on('mysql')
                    ->where('type_id', $type)
                    ->where('form_name', 'like', '%'.$req->form.'%')
                )
                ->orderBy('form_name','asc')
                ->take(10)
                ->get();

        $list = "<ul>";
            if($data->count() > 0){
                foreach($data as $index => $item) {
                    $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$item->id.'">'.$item->form_name.'</li>';
                }
            }
            else{
                $list .= '<li>No Data Found</li>';
            }
        $list .= "</ul>";

        return $list;
    } // End Method
}
