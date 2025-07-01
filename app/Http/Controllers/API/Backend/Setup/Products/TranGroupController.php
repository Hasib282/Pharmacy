<?php

namespace App\Http\Controllers\API\Backend\Setup\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use App\Models\Transaction_Groupe;
use App\Models\Transaction_Main_Head;

class TranGroupController extends Controller
{
    // Show All Transaction Group
    public function Show(Request $req){
        $type = GetTranType($req->segment(2));

        $data = filterByCompany(
                    Transaction_Groupe::on('mysql')
                    ->with('Type')
                    ->when($type, function ($query) use ($type) { // when $type is not null
                        $query->where('tran_groupe_type', $type);
                    })
                )
                ->orderBy('added_at')
                ->get();

        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Transaction Group
    public function Insert(Request $req){
        $req->validate([
            "groupeName" => 'required|unique:mysql.transaction__groupes,tran_groupe_name',
            "type" => 'required|exists:mysql.transaction__main__heads,id',
            "method" => 'required|in:Receive,Payment,Both',
        ]);

        $insert = Transaction_Groupe::on('mysql')->create([
            "tran_groupe_name" => $req->groupeName,
            "tran_groupe_type" => $req->type,
            "tran_method" => $req->method,
            "company_id" => $req->company,
        ]);

        $data = Transaction_Groupe::on('mysql')->with('Type')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Transaction Groupe Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method



    // Update Transaction Group
    public function Update(Request $req){
        $data = Transaction_Groupe::on('mysql')->whereNotIn('id', ['1','2','3','4'])->findOrFail($req->id);

        $req->validate([
            "groupeName" => ['required', Rule::unique('mysql.transaction__groupes', 'tran_groupe_name')->ignore($data->id)],
            "type" => 'required|exists:mysql.transaction__main__heads,id',
            "method" => 'required|in:Receive,Payment,Both',
        ]);

        $update = $data->update([
            "tran_groupe_name" => $req->groupeName,
            "tran_groupe_type" => $req->type,
            "tran_method" => $req->method,
            "updated_at" => now()
        ]);

        $updatedData = Transaction_Groupe::on('mysql')->with('Type')->findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Transaction Groupe Updated Successfully',
                "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method



    // Delete Transaction Group
    public function Delete(Request $req){
        Transaction_Groupe::on('mysql')->whereNotIn('id', ['1','2','3','4'])->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Transaction Groupe Deleted Successfully',
        ], 200); 
    } // End Method



    // Delete Transaction Group Status
    public function DeleteStatus(Request $req){
        $data = Transaction_Groupe::on('mysql')->whereNotIn('id', ['1','2','3','4'])->findOrFail($req->id);
        $data->update(['status' => $data->status == 0 ? 1 : 0]);
        
        $updatedData = Transaction_Groupe::on('mysql')->with('Type')->findOrFail($req->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Transaction Group Deleted Successfully',
            'updatedData' => $updatedData
        ], 200);
    } // End Method



    // Get Transaction Groupes By Type
    public function Get(Request $req){
        $type = $req->type;
        $method = $req->method;

        $data = filterByCompany(
                    Transaction_Groupe::on('mysql')
                    ->when($type, function ($query) use ($type) { // when $type is not null
                        $query->where('tran_groupe_type', $type);
                    })
                    ->when($method, function ($query) use ($method) { // when $method is not null
                        $query->whereIn('tran_method',[$method,'Both']);
                    })
                )
                ->orderBy('tran_groupe_name')
                ->get();

        return response()->json([
            'status' => "success",
            'data'=> $data,
        ]);
    } // End Method
}
