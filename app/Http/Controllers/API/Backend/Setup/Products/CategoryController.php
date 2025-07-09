<?php

namespace App\Http\Controllers\API\Backend\Setup\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Item_Category;

class CategoryController extends Controller
{
    // Show All Item/Product Category
    public function Show(Request $req){
        $type = GetTranType($req->segment(2));
        $data = filterByCompany(Item_Category::on('mysql_second'))->where('type_id', $type)->orderBy('added_at','asc')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Item/Product Category
    public function Insert(Request $req){
        $type = GetTranType($req->segment(2));
        $req->validate([
            'name' => 'required',
        ]);

        $insert = Item_Category::on('mysql_second')->create([
            'category_name' => $req->name,
            'company_id' => $req->company,
            'type_id'=> $type,
        ]);

        $data = Item_Category::on('mysql_second')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Category Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method



    // Update Item/Product Category
    public function Update(Request $req){
        $req->validate([
            'name' => 'required',
        ]);

        $update = Item_Category::on('mysql_second')->findOrFail($req->id)->update([
            'category_name' => $req->name,
            "updated_at" => now()
        ]);

        $updatedData = Item_Category::on('mysql_second')->findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Category Updated Successfully',
                "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method



    // Delete Item/Product Category
    public function Delete(Request $req){
        Item_Category::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Category Deleted Successfully',
        ], 200); 
    } // End Method



    // Delete Item/Product Category Status
    public function DeleteStatus(Request $req){
        $data = Item_Category::on('mysql_second')->findOrFail($req->id);
        $data->update(['status' => $data->status == 0 ? 1 : 0]);
        
        $updatedData = Item_Category::on('mysql_second')->findOrFail($req->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Item/Product Category Deleted Successfully',
            'updatedData' => $updatedData
        ], 200);
    } // End Method



    // Get Item/Product Category By Name
    public function Get(Request $req){
        $type = GetTranType($req->type);
        $data = filterByCompany(
                        Item_Category::on('mysql_second')
                        ->where('type_id', $type)
                        ->where('category_name', 'like', '%'.$req->category.'%')
                    )
                    ->orderBy('category_name','asc')
                    ->take(10)
                    ->get();

        $list = "<ul>";
            if($data->count() > 0){
                foreach($data as $index => $item) {
                    $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$item->id.'">'.$item->category_name.'</li>';
                }
            }
            else{
                $list .= '<li>No Data Found</li>';
            }
        $list .= "</ul>";
        return $list;
    } // End Method
}
