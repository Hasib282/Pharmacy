<?php

namespace App\Http\Controllers\API\Backend\Setup\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Transaction_Head;
use App\Models\Transaction_Groupe;

class TranHeadController extends Controller
{
    // Show All Transaction Heads
    public function Show(Request $req){
        $type = GetTranType($req->segment(2));

        $data = filterByCompany(
                    Transaction_Head::on('mysql_second')
                    ->with('Groupe')
                    ->when($type, function ($query) use ($type) { // when $type is not null
                        $query->whereHas('Groupe', function ($q) use ($type) {
                            $q->where('tran_groupe_type', $type);
                        });
                    })
                )
                ->orderBy('added_at')
                ->get();
        
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Transaction Heads
    public function Insert(Request $req){
        $req->validate([
            "headName" => 'required|unique:mysql_second.transaction__heads,tran_head_name',
            "groupe" => 'required|exists:mysql_second.transaction__groupes,id',
            "price" => 'nullable|numeric',
        ]);



        $insert = Transaction_Head::on('mysql_second')->create([
            "tran_head_name" => $req->headName,
            "groupe_id" => $req->groupe,
            "mrp" => $req->price ?? 0,
            "editable"=> ($req->editable == 'on') ? 1 : 0,
            "company_id" => $req->company,
        ]);

        $data = Transaction_Head::on('mysql_second')->with('Groupe')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Transaction Heads Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method



    // Update Transaction Heads
    public function Update(Request $req){
        $data = Transaction_Head::on('mysql_second')->whereNotIn('id', ['1','2','3','4','5','6'])->findOrFail($req->id);

        $req->validate([
            "headName" => ['required',Rule::unique('mysql_second.transaction__heads', 'tran_head_name')->ignore($data->id)],
            "groupe"  => 'required|exists:mysql_second.transaction__groupes,id',
            "price" => 'nullable|numeric',
        ]);

        $update = $data->update([
            "tran_head_name" => $req->headName,
            "groupe_id" => $req->groupe,
            "mrp" => $req->price ?? 0,
            "editable"=> ($req->editable == 'on') ? 1 : 0,
            "updated_at" => now()
        ]);

        $updatedData = Transaction_Head::on('mysql_second')->with('Groupe')->findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Transaction Heads Updated Successfully',
                "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method



    // Delete Transaction Heads
    public function Delete(Request $req){
        Transaction_Head::on('mysql_second')->whereNotIn('id', ['1','2','3','4','5','6'])->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Transaction Heads Deleted Successfully',
        ], 200); 
    } // End Method



    // Delete Transaction Heads Status
    public function DeleteStatus(Request $req){
        $data = Transaction_Head::on('mysql_second')->whereNotIn('id', ['1','2','3','4','5','6'])->findOrFail($req->id);
        $data->update(['status' => $data->status == 0 ? 1 : 0]);
        
        $updatedData = Transaction_Head::on('mysql_second')->with('Groupe')->findOrFail($req->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Transaction Heads Deleted Successfully',
            'updatedData' => $updatedData
        ], 200);
    } // End Method



    // Get Transaction Heads By Name And Groupe
    public function Get(Request $req){
        $query = Transaction_Head::on('mysql_second')
        ->where('tran_head_name', 'like', $req->head . '%')
        ->orderBy('tran_head_name')
        ->take(10);

        if ($req->groupein == "1") {
            $query->whereIn('groupe_id', $req->groupe);
        } else {
            $query->where('groupe_id', $req->groupe);
        }

        $data = $query->get();

        $list = "<ul>";
            if($data->count() > 0){
                foreach($data as $index => $item) {
                    $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$item->id.'" data-mrp="'.$item->mrp.'" data-groupe="'.$item->groupe_id.'">'.$item->tran_head_name.'</li>';
                }
            }
            else{
                $list .= '<li>No Data Found</li>';
            }
        $list .= "</ul>";

        return $list;
    } // End Method
}
