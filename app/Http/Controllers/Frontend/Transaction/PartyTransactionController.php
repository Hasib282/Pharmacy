<?php

namespace App\Http\Controllers\Frontend\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PartyTransactionController extends Controller
{
    //Show Party Payments Receive From Client
    public function ShowPartyReceive(Request $req){
        $name = "Receive from Client";
        $js = "receive_from_client";
        if ($req->ajax()) {
            return view('transaction.party_payment.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('transaction.party_payment.partyPayments', compact('name', 'js'));
        }
    } // End Method

    
    
    //Show Party Payments Payment To Supplier
    public function ShowPartyPayment(Request $req){
        $name = "Payment to Supplier";
        $js = "payment_to_supplier";
        if ($req->ajax()) {
            return view('transaction.party_payment.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('transaction.party_payment.partyPayments', compact('name', 'js'));
        }
    } // End Method

    

    // Search Party
    public function SearchParty(Request $req){
        $requestPath = $req->path();
        if (strpos($requestPath, 'receive') !== false) {
            $name = "Receive from Client";
            $js = "receive_from_client";
            return view('transaction.party_payment.partyPayments', compact('name', 'js'));
        }
        else if(strpos($requestPath, 'payment') !== false){
            $name = "Payment to Supplier";
            $js = "payment_to_supplier";
            return view('transaction.party_payment.partyPayments', compact('name', 'js'));
        }
    } // End Method



    /////////////////////////// --------------- Party Payments Common Methods start ---------- //////////////////////////

    // // Edit Party Payments
    // public function EditParty(Request $req){
    //     $party = Transaction_Main::with('Location','User','withs','Store')->where('tran_id', $req->id )->first();
    //     return response()->json([
    //         'party'=>$party,
    //     ]);
    // } // End Method



    // //Update Party Payments
    // public function UpdateParty(Request $req){
    //     if($req->dId != ""){
    //         $transaction = Transaction_Main::findOrFail($req->dId);

    //         $req->validate([
    //             "groupe"  => 'required|numeric',
    //             "head"  => 'required|numeric',
    //             "quantity"  => 'required|numeric',
    //             "amount"  => 'required|numeric',
    //             "totAmount"  => 'required|numeric',
    //         ]);

    //         $update = Transaction_Main::findOrFail($req->dId)->update([
    //             "tran_groupe_id" => $req->groupe,
    //             "tran_head_id" => $req->head,
    //             "quantity" => $req->quantity,
    //             "amount" => $req->amount,
    //             "tot_amount" => $req->totAmount,
    //             "updated_at" => now()
    //         ]);

    //         if($update){
    //             return response()->json([
    //                 'status'=>'success'
    //             ]); 
    //         }
    //     }
    //     else{
    //         $req->validate([
    //             "tranId" => 'required',
    //             "location" => 'required|numeric',
    //             "type" => 'required',
    //             "groupe" => 'required',
    //             "head" => 'required',
    //             "with" => 'required',
    //             "user" => 'required',
    //             "amount" => 'required',
    //             "quantity" => 'required',
    //             "totAmount" => 'required',
    //         ]);
    
    //         Transaction_Main::insert([
    //             "tran_id" => $req->tranId,
    //             "loc_id" => $req->location,
    //             "tran_type" => 2,
    //             "tran_groupe_id" => $req->groupe,
    //             "tran_head_id" => $req->head,
    //             "tran_type_with" => $req->with,
    //             "tran_user" => $req->user,
    //             "amount" => $req->amount,
    //             "quantity" => $req->quantity,
    //             "tot_amount" => $req->totAmount,
    //         ]);
    
    //         return response()->json([
    //             'status'=>'success',
    //         ]);  
    //     }
    // }//End Method



    // //Delete Party Payments
    // public function DeleteParty(Request $req){
    //     Transaction_Main::findOrFail($req->id)->delete();
    //     return response()->json([
    //         'status'=>'success'
    //     ]); 
    // }//End Method

    /////////////////////////// --------------- Party Payments Common Methods start ---------- //////////////////////////
}
