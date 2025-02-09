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
    public function ShowAll(Request $req){
        $type = GetTranType($req->segment(2));

        $heads = filterByCompany(
                    Transaction_Head::on('mysql')
                    ->with('Groupe')
                    ->when($type, function ($query) use ($type) { // when $type is not null
                        $query->whereHas('Groupe', function ($q) use ($type) {
                            $q->where('tran_groupe_type', $type);
                        });
                    })
                )
                ->orderBy('added_at')
                ->paginate(15);
        
        return response()->json([
            'status'=> true,
            'data' => $heads,
        ], 200);
    } // End Method



    // Insert Transaction Heads
    public function Insert(Request $req){
        $req->validate([
            "headName" => 'required|unique:mysql.transaction__heads,tran_head_name',
            "groupe" => 'required|exists:mysql.transaction__groupes,id'
        ]);

        Transaction_Head::on('mysql')->insert([
            "tran_head_name" => $req->headName,
            "groupe_id" => $req->groupe,
            "company_id" => $req->company,
        ]);
        
        return response()->json([
            'status'=> true,
            'message' => 'Transaction Heads Added Successfully'
        ], 200);  
    } // End Method



    // Edit Transaction Heads
    public function Edit(Request $req){
        $segments = [
            'transaction' => 1,
            'hr' => 3,
            'inventory' => 5,
            'pharmacy' => 6,
        ];

        $type = $segments[$req->segment(2)] ?? null;

        if($type != null){
            $groupes = Transaction_Groupe::on('mysql')->whereIn('tran_groupe_type', [$type])->orderBy('added_at')->get();
        }
        else{
            $groupes = Transaction_Groupe::on('mysql')->orderBy('added_at')->get();
        }

        $heads = Transaction_Head::on('mysql')->with('Groupe')->findOrFail($req->id);
        return response()->json([
            'status'=> true,            
            'heads'=>$heads,
            'groupes'=>$groupes,
        ], 200);
    } // End Method



    // Update Transaction Heads
    public function Update(Request $req){
        $heads = Transaction_Head::on('mysql')->whereNotIn('id', ['1','2','3','4','5','6'])->findOrFail($req->id);

        $req->validate([
            "headName" => ['required',Rule::unique('mysql.transaction__heads', 'tran_head_name')->ignore($heads->id)],
            "groupe"  => 'required|exists:mysql.transaction__groupes,id'
        ]);

        $update = Transaction_Head::on('mysql')->findOrFail($req->id)->update([
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
        Transaction_Head::on('mysql')->whereNotIn('id', ['1','2','3','4','5','6'])->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Transaction Heads Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Transaction Heads
    public function Search(Request $req){
        $type = GetTranType($req->segment(2));

        $heads = Transaction_Head::on('mysql')
        ->with('Groupe')
        ->when($type, function ($query) use ($type) { // when $type is not null
            $query->whereHas('Groupe', function ($q) use ($type) {
                $q->where('tran_groupe_type', $type);
            });
        });

        if($req->searchOption == 1){
            $heads = filterByCompany($heads)
            ->where('tran_head_name', 'like', $req->search.'%')
            ->orderBy('tran_head_name')
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $heads = filterByCompany($heads)
            ->whereHas('Groupe', function ($q) use ($req, $type) {
                $q->where('tran_groupe_name', 'like', $req->search . '%');
                $q->orderBy('tran_groupe_name');
            })
            ->paginate(15);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'Wrong Search Option Selected',
            ], 200);
        }
        
        return response()->json([
            'status' => true,
            'data' => $heads,
        ], 200);
    } // End Method



    // Get Transaction Heads By Name And Groupe
    public function Get(Request $req){
        $query = Transaction_Head::on('mysql')->where('tran_head_name', 'like', $req->head . '%')
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
