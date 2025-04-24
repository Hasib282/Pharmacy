<?php

namespace App\Http\Controllers\API\Backend\Setup\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Company_Type;

class CompanyTypeController extends Controller
{
    // Show All Company Types
    public function ShowAll(Request $req){
        $data = Company_Type::on('mysql')->orderBy('added_at')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Company Types
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required|unique:mysql.company__types,name',
        ]);

        $insert = Company_Type::on('mysql')->create([
            "name" => $req->name,
        ]);
        
        $data = Company_Type::on('mysql')->findOrFail($insert->id);

        return response()->json([
            'status'=> true,
            'message' => 'Company Type Added Successfully',
            "data" => $data,
        ], 200);
    } // End Method



    // Edit Company Types
    public function Edit(Request $req){
        $data = Company_Type::on('mysql')->findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'data'=> $data,
        ], 200);
    } // End Method



    // Update Company Types
    public function Update(Request $req){
        $data = Company_Type::on('mysql')->findOrFail($req->id);
        
        $req->validate([
            "name" => ['required',Rule::unique('mysql.company__types', 'name')->ignore($data->id)],
        ]);

        $update = $data->update([
            "name" => $req->name,
            "updated_at" => now()
        ]);
        
        $updatedData = Company_Type::on('mysql')->findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Company Type Updated Successfully',
                "updatedData" => $updatedData,
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
        $data = Company_Type::on('mysql')->where('name', 'like', $req->search.'%')
        ->orderBy('name')
        ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Get Company Types
    public function Get(){
        $data = Company_Type::on('mysql')->orderBy('id')->get();
        return response()->json([
            'status' => true,
            'data'=> $data,
        ]);
    } // End Method
}
