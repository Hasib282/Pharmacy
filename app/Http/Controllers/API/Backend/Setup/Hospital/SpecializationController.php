<?php

namespace App\Http\Controllers\API\Backend\Setup\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Specialization;

class SpecializationController extends Controller
{
    // Show All Doctors Specialization
    public function ShowAll(Request $req){
        $data = Specialization::on('mysql_second')->orderBy('added_at')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Doctors Specialization
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required|unique:mysql_second.specializations,name',
        ]);

        Specialization::on('mysql_second')->insert([
            "name" => $req->name,
        ]);
        
        return response()->json([
            'status'=> true,
            'message' => 'Doctors Specialization Added Successfully'
        ], 200);  
    } // End Method



    // Edit Doctors Specialization
    public function Edit(Request $req){
        $data = Specialization::on('mysql_second')->findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'data'=> $data,
        ], 200);
    } // End Method



    // Update Doctors Specialization
    public function Update(Request $req){
        $data = Specialization::on('mysql_second')->findOrFail($req->id);
        
        $req->validate([
            "name" => ['required',Rule::unique('mysql_second.specializations', 'name')->ignore($data->id)],
        ]);

        $update = $data->update([
            "name" => $req->name,
            "updated_at" => now()
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Doctors Specialization Updated Successfully',
            ], 200); 
        }
    } // End Method



    // Delete Doctors Specialization
    public function Delete(Request $req){
        Specialization::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Doctors Specialization Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Doctors Specialization
    public function Search(Request $req){
        $data = Specialization::on('mysql_second')
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
        $data = Specialization::on('mysql_second')
        ->where('name', 'like', $req->specialization.'%')
        ->orderBy('name')
        ->take(10)
        ->get();

        $list = "<ul>";
            if($data->count() > 0){
                foreach($data as $index => $item) {
                    $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$item->id.'">'.$item->name.'</li>';
                }
            }
            else{
                $list .= '<li>No Data Found</li>';
            }
        $list .= "</ul>";
        return $list;
    } // End Method
}
