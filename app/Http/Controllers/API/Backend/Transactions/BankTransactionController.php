<?php

namespace App\Http\Controllers\API\Backend\Transactions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Transaction_With;
use App\Models\Transaction_Groupe;
use App\Models\Transaction_Detail;
use App\Models\Transaction_Main;

class BankTransactionController extends Controller
{
    // Show All Bank Withdraws
    public function ShowAllWithdraws(Request $req){
        $data = Transaction_Detail::on('mysql_second')->with('Bank','Head')->where('tran_method','Withdraw')->where('tran_type','4')->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])->orderBy('tran_date','asc')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method


    
    // Show All Bank Deposits
    public function ShowAllDeposits(Request $req){
        $data = Transaction_Detail::on('mysql_second')->with('Bank','Head')->where('tran_method','Deposit')->where('tran_type','4')->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])->orderBy('tran_date','asc')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method
    
    
    
    // Insert Bank Transactions
    public function Insert(Request $req){
        $req->validate([
            "bank"  => 'required|exists:mysql.banks,user_id',
            "head"  => 'required|exists:mysql.transaction__heads,id',
            "amount"  => 'required|numeric',
        ]);

        // Generates Auto Increment Purchase Id
        $transaction = Transaction_Main::on('mysql_second')->where('tran_type', 4)->where('tran_method', $req->method)->latest('tran_id')->first();
        if($req->method === 'Withdraw'){
            $id = ($transaction) ? 'BMW' . str_pad((intval(substr($transaction->tran_id, 3)) + 1), 9, '0', STR_PAD_LEFT) :  'BMW000000001';
        }
        else if($req->method === 'Deposit'){
            $id = ($transaction) ? 'BMD' . str_pad((intval(substr($transaction->tran_id, 3)) + 1), 9, '0', STR_PAD_LEFT) :  'BMD000000001';
        }

        $data = null;

        DB::transaction(function () use ($req, $id, &$data) {
            $receive = $req->method === 'Withdraw' ? $req->amount : null;
            $payment = $req->method === 'Deposit' ? $req->amount : null;
            Transaction_Main::on('mysql_second')->create([
                "tran_id" => $id,
                "tran_type" => 4,
                "tran_method" => $req->method,
                "tran_bank" => $req->bank,
                "bill_amount" => $req->amount,
                "discount" => 0,
                "net_amount" => $req->amount,
                "receive" => $receive,
                "payment" => $payment,
                "due" => 0,
            ]);


            $insert = Transaction_Detail::on('mysql_second')->create([
                "tran_id" => $id,
                "tran_type" => 4,
                "tran_method" => $req->method,
                "tran_bank" => $req->bank,
                "tran_groupe_id" => $req->groupe,
                "tran_head_id" => $req->head,
                "amount" => $req->amount,
                "quantity" => 1,
                "tot_amount" => $req->amount,
                "discount" => 0,
                "receive" => $receive,
                "payment" => $payment,
                "due" => 0,
            ]);

            $data = Transaction_Detail::on('mysql_second')->with('Bank','Head')->findOrFail($insert->id);
        });

        
        return response()->json([
            'status'=> true,
            'message' => 'Bank Transaction Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method



    // Update Bank Transactions
    public function Update(Request $req){
        $req->validate([
            "bank"  => 'required|exists:mysql.banks,user_id',
            "head"  => 'required|exists:mysql.transaction__heads,id',
            "amount"  => 'required|numeric',
        ]);

        $transaction = Transaction_Detail::on('mysql_second')->findOrFail($req->id);
        
        DB::transaction(function () use ($req, $transaction) {
            $receive = $req->method === 'Withdraw' ? $req->amount : null;
            $payment = $req->method === 'Deposit' ? $req->amount : null;
            Transaction_Main::on('mysql_second')->where('tran_id', $transaction->tran_id)->update([
                "tran_bank" => $req->bank,
                "bill_amount" => $req->amount,
                "net_amount" => $req->amount,
                "receive" => $receive,
                "payment" => $payment,
                "updated_at" => now()
            ]);


            $transaction->update([
                "tran_bank" => $req->bank,
                "tran_head_id" => $req->head,
                "amount" => $req->amount,
                "tot_amount" => $req->amount,
                "receive" => $receive,
                "payment" => $payment,
                "tran_date" => $transaction->tran_date,
                "updated_at" => now()
            ]);
        });

        $updatedData = Transaction_Detail::on('mysql_second')->with('Bank','Head')->findOrFail($req->id);
        
        return response()->json([
            'status'=>true,
            'message' => 'Bank Transaction Updated Successfully',
            "updatedData" => $updatedData,
        ], 200); 
        
    } // End Method



    // Delete Bank Transactions
    public function Delete(Request $req){
        $data = Transaction_Detail::on('mysql_second')->findOrFail($req->id);
        Transaction_Main::on('mysql_second')->where('tran_id',$data->tran_id)->delete();
        $data->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Bank Transaction Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Bank Transactions
    public function Search(Request $req){
        $data = Transaction_Detail::on('mysql_second')
        ->with('Bank','Head')
        ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
        ->where('tran_method',$req->method)
        ->where('tran_type', 4)
        ->orderBy('tran_id','asc')
        ->get();
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method
}
