<?php

namespace App\Http\Controllers\API\Backend\Admin_Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Transaction_Groupe;
use App\Models\Transaction_Main_head;

class TranGroupController extends Controller
{
    // Show All Transaction Group
    public function ShowAll(Request $req){
        $groupes = Transaction_Groupe::on('mysql_second')->whereNotIn('id', ['1','2','3','4','5'])->with('Type')->orderBy('added_at')->paginate(15);
        $types = Transaction_Main_head::on('mysql_second')->orderBy('added_at')->get();
        return response()->json([
            'status'=> true,
            'data' => $groupes,
            'types' => $types,
        ], 200);
    } // End Method



    // Insert Transaction Group
    public function Insert(Request $req){
        $req->validate([
            "groupeName" => 'required|unique:mysql_second.transaction__groupes,tran_groupe_name',
            "type" => 'required|numeric',
            "method" => 'required|in:Receive,Payment,Both',
        ]);

        Transaction_Groupe::on('mysql_second')->insert([
            "tran_groupe_name" => $req->groupeName,
            "tran_groupe_type" => $req->type,
            "tran_method" => $req->method,
        ]);
        
        return response()->json([
            'status'=> true,
            'message' => 'Transaction Groupe Added Successfully'
        ], 200);  
    } // End Method



    // Edit Transaction Group
    public function Edit(Request $req){
        $groupes = Transaction_Groupe::on('mysql_second')->whereNotIn('id', ['1','2','3','4','5'])->with('Type')->findOrFail($req->id);
        $types = Transaction_Main_head::on('mysql_second')->orderBy('added_at')->get();
        return response()->json([
            'status'=> true,            
            'groupes'=>$groupes,
            'types'=>$types,
        ], 200);
    } // End Method



    // Update Transaction Group
    public function Update(Request $req){
        $groupes = Transaction_Groupe::on('mysql_second')->whereNotIn('id', ['1','2','3','4','5'])->findOrFail($req->id);

        $req->validate([
            "groupeName" => ['required', Rule::unique('mysql_second.transaction__groupes', 'tran_groupe_name')->ignore($groupes->id)],
            "type" => 'required|numeric',
            "method" => 'required|in:Receive,Payment,Both',
        ]);

        $update = Transaction_Groupe::on('mysql_second')->findOrFail($req->id)->update([
            "tran_groupe_name" => $req->groupeName,
            "tran_groupe_type" => $req->type,
            "tran_method" => $req->method,
            "updated_at" => now()
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Transaction Groupe Updated Successfully',
            ], 200); 
        }
    } // End Method



    // Delete Transaction Group
    public function Delete(Request $req){
        Transaction_Groupe::on('mysql_second')->whereNotIn('id', ['1','2','3','4','5'])->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Transaction Groupe Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Transaction Group
    public function Search(Request $req){
        $groupes = Transaction_Groupe::on('mysql_second')
        ->whereNotIn('id', ['1','2','3','4','5'])
        ->with('Type')
        ->where('tran_groupe_name', 'like', '%'.$req->search.'%')
        ->where('tran_groupe_type', 'like', '%'.$req->type.'%')
        ->where('tran_method', 'like', '%'.$req->method.'%')
        ->orderBy('tran_groupe_name')
        ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $groupes,
        ], 200);
    } // End Method



    // Get Transaction Groupes
    public function Get(Request $req){
        $groupes = Transaction_Groupe::on('mysql_second')->where('tran_groupe_name', 'like', '%'.$req->groupe.'%')
        ->orderBy('tran_groupe_name')
        ->take(10)
        ->get();


        if($groupes->count() > 0){
            $list = "";
            foreach($groupes as $index => $groupe) {
                $list .= '<li tabindex="'.($index + 1).'" data-id="'.$groupe->id.'">'.$groupe->tran_groupe_name.'</li>';
            }
        }
        else{
            $list = '<li>No Data Found</li>';
        }
        return $list;
    } // End Method



    // Get Transaction Groupes By Type
    public function GetByType(Request $req){
        $groupes = Transaction_Groupe::on('mysql_second')->where('tran_groupe_type', 'like', '%'.$req->type.'%')
        ->orderBy('tran_groupe_type')
        ->get();

        return response()->json([
            'status' => "success",
            'groupes'=> $groupes,
        ]);
    } // End Method
}
