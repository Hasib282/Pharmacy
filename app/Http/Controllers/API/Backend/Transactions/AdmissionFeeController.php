<?php

namespace App\Http\Controllers\API\Backend\Transactions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdmissionFeeController extends Controller
{
    // Show All Admission Fee
    public function Show(Request $req){
        $data = Bed_Category::on('mysql_second')->orderBy('added_at')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Admission Fee
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required|unique:mysql_second.bed__categories,name',
        ]);

        $insert = Bed_Category::on('mysql_second')->create([
            "name" => $req->name,
        ]);

        $data = Bed_Category::on('mysql_second')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Admission Fee Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method



    // Update Admission Fee
    public function Update(Request $req){
        $data = Bed_Category::on('mysql_second')->findOrFail($req->id);
        
        $req->validate([
            "name" => ['required',Rule::unique('mysql_second.bed__categories', 'name')->ignore($data->id)],
        ]);

        $update = $data->update([
            "name" => $req->name,
            "updated_at" => now()
        ]);

        $updatedData = Bed_Category::on('mysql_second')->findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Admission Fee Updated Successfully',
                "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method



    // Delete Admission Fee
    public function Delete(Request $req){
        Bed_Category::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Admission Fee Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Admission Fee
    public function Search(Request $req){
        $data = Transaction_Main::on('mysql_second')
        ->with('Patient')
        ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
        ->where('tran_method',$req->method)
        ->where('tran_type', 7)
        ->orderBy('tran_id','asc')
        ->get();
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method
}
