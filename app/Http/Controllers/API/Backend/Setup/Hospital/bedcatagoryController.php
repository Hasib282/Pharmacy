<?php

namespace App\Http\Controllers\API\Backend\Setup\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Bed_Category;

class BedCatagoryController extends Controller
{
    // Show All Bed Category
    public function ShowAll(Request $req){
        $data = Bed_Category::on('mysql_second')->orderBy('added_at')->paginate(15);
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Bed Category
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required|unique:mysql_second.bed__categories,name',
        ]);

        Bed_Category::on('mysql_second')->insert([
            "name" => $req->name,
        ]);
        
        return response()->json([
            'status'=> true,
            'message' => 'Bed Category Added Successfully'
        ], 200);  
    } // End Method



    // Edit Bed Category
    public function Edit(Request $req){
        $data = Bed_Category::on('mysql_second')->findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'data'=> $data,
        ], 200);
    } // End Method



    // Update Bed Category
    public function Update(Request $req){
        $type = Bed_Category::on('mysql_second')->findOrFail($req->id);
        
        $req->validate([
            "name" => ['required',Rule::unique('mysql_second.bed__categories', 'name')->ignore($type->id)],
        ]);

        $update = Bed_Category::on('mysql_second')->findOrFail($req->id)->update([
            "name" => $req->name,
            "updated_at" => now()
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Bed Category Updated Successfully',
            ], 200); 
        }
    } // End Method



    // Delete Bed Category
    public function Delete(Request $req){
        Bed_Category::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Bed Category Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Bed Category
    public function Search(Request $req){
        $data = Bed_Category::on('mysql_second')
        ->where('name', 'like', $req->search.'%')
        ->orderBy('name')
        ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Get Transaction Main Head
    public function Get(Request $req){
        $categories = Bed_Category::on('mysql_second')
        ->where('name', 'like', $req->bed_category.'%')
        ->orderBy('name')
        ->take(10)
        ->get();


        if($categories->count() > 0){
            $list = "";
            foreach($categories as $index => $category) {
                $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$category->id.'">'.$category->name.'</li>';
            }
        }
        else{
            $list = '<li>No Data Found</li>';
        }
        return $list;
    } // End Method
}
