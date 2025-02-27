<?php

namespace App\Http\Controllers\Api\Backend\Setup\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Nursing_Station;

class NursingStationController extends Controller
{
    
        // Show All Nursing station
        public function ShowAll(Request $req){
            $data = Nursing_Station::on('mysql_second')->paginate(15);
            return response()->json([
                'status'=> true,
                'data' => $data,
            ], 200);
        } // End Method
    
    
    
        // Insert Nursing station
        public function Insert(Request $req){
            $req->validate([
                "name" => 'required|unique:mysql_second.nursing__stations,name',
                "floor" => 'required|numeric'
            ]);
    
            Nursing_Station::on('mysql_second')->insert([
                "name" => $req->name,
                "floor" => $req->floor,
            ]);
            
            return response()->json([
                'status'=> true,
                'message' => ' Added Successfully'
            ], 200);  
        } // End Method
    
    
    
        // Edit Nursing station
        public function Edit(Request $req){
            $data = Nursing_Station::on('mysql_second')->findOrFail($req->id);
            return response()->json([
                'status'=> true,
                'data'=> $data,
            ], 200);
        } // End Method
    
    
    
        // Update Nursing station
        public function Update(Request $req){
            $mainhead = Nursing_Station::on('mysql_second')->findOrFail($req->id);
            
            $req->validate([
                "name" => ['required',Rule::unique('mysql_second.nursing__stations', 'name')->ignore($mainhead->id)],
                "floor"=> 'required'
            ]);
    
            $update = Nursing_Station::on('mysql_second')->findOrFail($req->id)->update([
                "name" => $req->name,
                "floor" => $req->floor,
            ]);
    
            if($update){
                return response()->json([
                    'status'=>true,
                    'message' => 'MainHead Updated Successfully',
                ], 200); 
            }
        } // End Method
    
    
    
        // Delete Nursing station
        public function Delete(Request $req){
            Nursing_Station::on('mysql_second')->findOrFail($req->id)->delete();
            return response()->json([
                'status'=> true,
                'message' => 'MainHead Deleted Successfully',
            ], 200); 
        } // End Method
    
    
    
        // Search Nursing station
        public function Search(Request $req){
            $mainhead = Nursing_Station::on('mysql_second')->where('type_name', 'like', $req->search.'%')
            ->orderBy('type_name')
            ->paginate(15);
            
            return response()->json([
                'status' => true,
                'data' => $mainhead,
            ], 200);
        } // End Method
    
    
    
        // Get Transaction Main Head
        public function Get(){
            $mainhead = Nursing_Station::on('mysql_second')->orderBy('added_at')->paginate(15);
            return response()->json([
                'status' => true,
                'mainhead'=> $mainhead,
            ]);
        } 
}
