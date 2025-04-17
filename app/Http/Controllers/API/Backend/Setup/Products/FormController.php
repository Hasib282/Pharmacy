<?php

namespace App\Http\Controllers\API\Backend\Setup\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Item_Form;

class FormController extends Controller
{
    // Show All Item/Product Form
    public function ShowAll(Request $req){
        $type = GetTranType($req->segment(2));
        $data = filterByCompany(Item_Form::on('mysql')->where('type_id', $type))->orderBy('added_at','asc')->paginate(15);
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
 
        Item_Form::on('mysql')->insert([
            'form_name' => $req->name,
            'company_id' => $req->company,
            'type_id'=> $type,
        ]);
        
        return response()->json([
            'status'=> true,
            'message' => 'Form Added Successfully'
        ], 200);  
    } // End Method



    // Edit Item/Product Form
    public function Edit(Request $req){
        $data = Item_Form::on('mysql')->where('id', $req->id)->first();
        return response()->json([
            'status'=> true,
            'data'=> $data,
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

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Location Updated Successfully',
            ], 200); 
        }
    } // End Method



    // Delete Item/Product Form
    public function Delete(Request $req){
        Item_Form::on('mysql')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Location Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Item/Product Form
    public function Search(Request $req){
        $type = GetTranType($req->segment(2));
        $data = filterByCompany(
                    Item_Form::on('mysql')
                    ->where('type_id', $type)
                    ->where('form_name', 'like', '%'.$req->search.'%')
                )
                ->orderBy('form_name','asc')
                ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Get Item/Product Form
    public function Get(Request $req){
        $type = GetTranType($req->segment(2));
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
