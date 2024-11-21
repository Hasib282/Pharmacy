<?php

namespace App\Http\Controllers\API\Backend\Admin_Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Transaction_Head;
use App\Models\Transaction_Groupe;

class TranHeadController extends Controller
{
    // Show All Transaction Heads
    public function ShowAll(Request $req){
        $groupes = Transaction_Groupe::orderBy('added_at')->get();
        $heads = Transaction_Head::with('Groupe')->orderBy('added_at')->paginate(15);
        return response()->json([
            'status'=> true,
            'data' => $heads,
            'groupes' => $groupes,
        ], 200);
    } // End Method



    // Insert Transaction Heads
    public function Insert(Request $req){
        $req->validate([
            "headName" => 'required|unique:transaction__heads,tran_head_name',
            "groupe" => 'required|numeric'
        ]);

        Transaction_Head::insert([
            "tran_head_name" => $req->headName,
            "groupe_id" => $req->groupe,
        ]);
        
        return response()->json([
            'status'=> true,
            'message' => 'Transaction Heads Added Successfully'
        ], 200);  
    } // End Method



    // Edit Transaction Heads
    public function Edit(Request $req){
        $groupes = Transaction_Groupe::orderBy('added_at')->get();
        $heads = Transaction_Head::with('Groupe')->findOrFail($req->id);
        return response()->json([
            'status'=> true,            
            'heads'=>$heads,
            'groupes'=>$groupes,
        ], 200);
    } // End Method



    // Update Transaction Heads
    public function Update(Request $req){
        $heads = Transaction_Head::findOrFail($req->id);

        $req->validate([
            "headName" => ['required',Rule::unique('transaction__heads', 'tran_head_name')->ignore($heads->id)],
            "groupe"  => 'required|numeric'
        ]);

        $update = Transaction_Head::findOrFail($req->id)->update([
            "tran_head_name" => $req->headName,
            "groupe_id" => $req->groupe,
            "updated_at" => now()
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Transaction Heads Updated Successfully',
            ], 200); 
        }
    } // End Method



    // Delete Transaction Heads
    public function Delete(Request $req){
        Transaction_Head::findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Transaction Heads Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Transaction Heads
    public function Search(Request $req){
        if($req->searchOption == 1){
            $heads = Transaction_Head::with('Groupe')
            ->where('tran_head_name', 'like', '%'.$req->search.'%')
            ->orderBy('tran_head_name')
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $heads = Transaction_Head::with('Groupe')
            ->whereHas('Groupe', function ($query) use ($req) {
                $query->where('tran_groupe_name', 'like', '%' . $req->search . '%');
                $query->orderBy('tran_groupe_name');
            })
            ->paginate(15);
        }
        
        return response()->json([
            'status' => true,
            'data' => $heads,
        ], 200);
    } // End Method



    // Get Transaction Heads By Name And Groupe
    public function Get(Request $req){
        $query = Transaction_Head::where('tran_head_name', 'like', '%' . $req->head . '%')
        ->orderBy('tran_head_name')
        ->take(10);

        if ($req->groupein == "1") {
            $query->whereIn('groupe_id', $req->groupe);
        } else {
            $query->where('groupe_id', $req->groupe);
        }

        $heads = $query->get();

        
        if($heads->count() > 0){
            $list = "";
            foreach($heads as $index => $head) {
                $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$head->id.'" data-groupe="'.$head->groupe_id.'">'.$head->tran_head_name.'</li>';
            }
        }
        else{
            $list = '<li>No Data Found</li>';
        }
        return $list;
    } // End Method
}
