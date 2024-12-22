<?php

namespace App\Http\Controllers\API\Backend\Admin_Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Company_Type;

class CompanyTypeController extends Controller
{
    // Show All Company Types
    public function ShowAll(Request $req){
        $type = Company_Type::on('mysql')->orderBy('added_at')->paginate(15);
        return response()->json([
            'status'=> true,
            'data' => $type,
        ], 200);
    } // End Method



    // Insert Company Types
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required|unique:mysql.company__types,name',
        ]);

        Company_Type::on('mysql')->insert([
            "name" => $req->name,
        ]);
        
        return response()->json([
            'status'=> true,
            'message' => 'Company Type Added Successfully'
        ], 200);  
    } // End Method



    // Edit Company Types
    public function Edit(Request $req){
        $type = Company_Type::on('mysql')->findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'type'=> $type,
        ], 200);
    } // End Method



    // Update Company Types
    public function Update(Request $req){
        $type = Company_Type::on('mysql')->findOrFail($req->id);
        
        $req->validate([
            "name" => ['required',Rule::unique('mysql.company__types', 'name')->ignore($type->id)],
        ]);

        $update = Company_Type::on('mysql')->findOrFail($req->id)->update([
            "name" => $req->name,
            "updated_at" => now()
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Company Type Updated Successfully',
            ], 200); 
        }
    } // End Method



    // Delete Company Types
    public function Delete(Request $req){
        Company_Type::on('mysql')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Company Type Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Company Types
    public function Search(Request $req){
        $type = Company_Type::on('mysql')->where('name', 'like', '%'.$req->search.'%')
        ->orderBy('name')
        ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $type,
        ], 200);
    } // End Method



    // Get Transaction Main Head
    public function Get(){
        $type = Company_Type::on('mysql')->orderBy('added_at')->paginate(15);
        return response()->json([
            'status' => true,
            'type'=> $type,
        ]);
    } // End Method
}
