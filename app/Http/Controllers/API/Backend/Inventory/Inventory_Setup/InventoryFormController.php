<?php

namespace App\Http\Controllers\API\Backend\Inventory\Inventory_Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Item_Form;

class InventoryFormController extends Controller
{
    // Show All Item/Product Form
    public function ShowAll(Request $req){
        $form = Item_Form::on('mysql')->where('type_id', '5')->orderBy('added_at','asc')->paginate(15);
        return response()->json([
            'status'=> true,
            'data' => $form,
        ], 200);
    } // End Method



    // Insert Item/Product Form
    public function Insert(Request $req){
        $req->validate([
            'name' => 'required',
        ]);
 
        Item_Form::on('mysql')->insert([
            'form_name' => $req->name,
            'type_id'=> '5',
        ]);
        
        return response()->json([
            'status'=> true,
            'message' => 'Form Added Successfully'
        ], 200);  
    } // End Method



    // Edit Item/Product Form
    public function Edit(Request $req){
        $form = Item_Form::on('mysql')->where('id', $req->id)->first();
        return response()->json([
            'status'=> true,
            'form'=> $form,
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
                'message' => 'Form Updated Successfully',
            ], 200); 
        }
    } // End Method



    // Delete Item/Product Form
    public function Delete(Request $req){
        Item_Form::on('mysql')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Form Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Item/Product Form
    public function Search(Request $req){
        $form = Item_Form::on('mysql')->where('type_id', '5')
        ->where('form_name', 'like', '%'.$req->search.'%')
        ->orderBy('form_name','asc')
        ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $form,
        ], 200);
    } // End Method



    // Get Item/Product Form
    public function Get(Request $req){
        $forms = Item_Form::on('mysql')->where('type_id', '5')
        ->where('form_name', 'like', '%'.$req->form.'%')
        ->orderBy('form_name','asc')
        ->take(10)
        ->get();


        if($forms->count() > 0){
            $list = "";
            foreach($forms as $index => $form) {
                $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$form->id.'">'.$form->form_name.'</li>';
            }
        }
        else{
            $list = '<li>No Data Found</li>';
        }
        return $list;
    } // End Method
}
