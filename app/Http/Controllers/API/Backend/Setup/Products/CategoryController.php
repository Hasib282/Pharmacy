<?php

namespace App\Http\Controllers\API\Backend\Setup\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Item_Category;

class CategoryController extends Controller
{
    // Show All Item/Product Category
    public function ShowAll(Request $req){
        $type = GetTranType($req->segment(2));
        $category = filterByCompany(Item_Category::on('mysql'))->where('type_id', $type)->orderBy('added_at','asc')->paginate(15);
        return response()->json([
            'status'=> true,
            'data' => $category,
        ], 200);
    } // End Method



    // Insert Item/Product Category
    public function Insert(Request $req){
        $type = GetTranType($req->segment(2));
        $req->validate([
            'name' => 'required',
        ]);

        Item_Category::on('mysql')->insert([
            'category_name' => $req->name,
            'company_id' => $req->company,
            'type_id'=> $type,
        ]);
        
        return response()->json([
            'status'=> true,
            'message' => 'Category Added Successfully'
        ], 200);  
    } // End Method



    // Edit Item/Product Category
    public function Edit(Request $req){
        $category = Item_Category::on('mysql')->where('id', $req->id)->first();
        return response()->json([
            'status'=> true,
            'category'=> $category,
        ], 200);
    } // End Method



    // Update Item/Product Category
    public function Update(Request $req){
        $req->validate([
            'name' => 'required',
        ]);

        $update = Item_Category::on('mysql')->findOrFail($req->id)->update([
            'category_name' => $req->name,
            "updated_at" => now()
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Category Updated Successfully',
            ], 200); 
        }
    } // End Method



    // Delete Item/Product Category
    public function Delete(Request $req){
        Item_Category::on('mysql')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Category Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Item/Product Category
    public function Search(Request $req){
        $type = GetTranType($req->segment(2));
        $category = filterByCompany(
                        Item_Category::on('mysql')
                        ->where('type_id', $type)
                        ->where('category_name', 'like', '%'.$req->search.'%')
                    )
                    ->orderBy('category_name','asc')
                    ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $category,
        ], 200);
    } // End Method



    // Get Item/Product Category By Name
    public function Get(Request $req){
        $type = GetTranType($req->segment(2));
        $categories = filterByCompany(
                        Item_Category::on('mysql')
                        ->where('type_id', $type)
                        ->where('category_name', 'like', '%'.$req->category.'%')
                    )
                    ->orderBy('category_name','asc')
                    ->take(10)
                    ->get();


        if($categories->count() > 0){
            $list = "";
            foreach($categories as $index => $category) {
                $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$category->id.'">'.$category->category_name.'</li>';
            }
        }
        else{
            $list = '<li>No Data Found</li>';
        }
        return $list;
    } // End Method
}
