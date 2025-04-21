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
        $data = Transaction_Main::on('mysql_second')->with('Bank')->where('tran_method','Withdraw')->where('tran_type','4')->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])->orderBy('tran_date','asc')->get();
        foreach ($data as $item) {
            $item->bill_amount = number_format($item->bill_amount, 0, '.', ',');
        }
        $groupes = Transaction_Groupe::on('mysql')->where('tran_groupe_type', '4')->whereIn('tran_method',["Receive",'Both'])->orderBy('added_at','asc')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
            'groupes' => $groupes,
        ], 200);
    } // End Method


    
    // Show All Bank Deposits
    public function ShowAllDeposits(Request $req){
        $data = Transaction_Main::on('mysql_second')->with('Bank')->where('tran_method','Deposit')->where('tran_type','4')->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])->orderBy('tran_date','asc')->paginate(15);
        foreach ($data as $item) {
            $item->bill_amount = number_format($item->bill_amount, 0, '.', ',');
        }
        
        $groupes = Transaction_Groupe::on('mysql')->where('tran_groupe_type', '4')->whereIn('tran_method',["Payment",'Both'])->orderBy('added_at','asc')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
            'groupes' => $groupes,
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

        DB::transaction(function () use ($req, $id) {
            $receive = $req->method === 'Withdraw' ? $req->amount : null;
            $payment = $req->method === 'Deposit' ? $req->amount : null;
            Transaction_Main::on('mysql_second')->insert([
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


            Transaction_Detail::on('mysql_second')->insert([
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
        });
        
        return response()->json([
            'status'=> true,
            'message' => 'Bank Transaction Added Successfully'
        ], 200);  
    } // End Method



    // Edit Bank Transactions
    public function Edit(Request $req){
        $data = Transaction_Detail::on('mysql_second')->with('Bank','Head')->where('tran_id', $req->id )->first();
        return response()->json([
            'status'=> true,
            'data'=> $data,
        ], 200);
    } // End Method



    // Update Bank Transactions
    public function Update(Request $req){
        $req->validate([
            "bank"  => 'required|exists:mysql.banks,id',
            "head"  => 'required|exists:mysql.transaction__heads,id',
            "amount"  => 'required|numeric',
        ]);

        $transaction = Transaction_Main::on('mysql_second')->where('tran_id', $req->id)->first();
        
        DB::transaction(function () use ($req, $transaction) {
            $receive = $req->method === 'Withdraw' ? $req->amount : null;
            $payment = $req->method === 'Deposit' ? $req->amount : null;
            Transaction_Main::on('mysql_second')->where('tran_id', $req->id)->update([
                "tran_bank" => $req->bank,
                "bill_amount" => $req->amount,
                "net_amount" => $req->amount,
                "receive" => $receive,
                "payment" => $payment,
                "updated_at" => now()
            ]);


            Transaction_Detail::on('mysql_second')->where('tran_id', $req->id)->update([
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

        
        return response()->json([
            'status'=>true,
            'message' => 'Bank Transaction Updated Successfully',
        ], 200); 
        
    } // End Method



    // Delete Bank Transactions
    public function Delete(Request $req){
        Transaction_Main::on('mysql_second')->where("tran_id", $req->id)->delete();
        Transaction_Detail::on('mysql_second')->where("tran_id", $req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Bank Transaction Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Bank Transactions
    public function Search(Request $req){
        if($req->searchOption == 1){
            $data = Transaction_Main::on('mysql_second')->with('Bank')
            ->where('tran_id', "like", '%'. $req->search .'%')
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', 4)
            ->orderBy('tran_id','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $data = Transaction_Main::on('mysql_second')->with('Bank')
            ->whereHas('Bank', function ($query) use ($req) {
                $query->where('name', 'like', '%'.$req->search.'%');
                $query->orderBy('name','asc');
            })
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', 4)
            ->paginate(15);
        }
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method
}
