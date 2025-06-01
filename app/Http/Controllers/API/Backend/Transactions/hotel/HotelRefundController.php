<?php

namespace App\Http\Controllers\API\Backend\Transactions\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Transaction_Detail;
use App\Models\Transaction_Main;

class HotelRefundController extends Controller
{
   // Show All Deposit Refunds
    public function Show(Request $req){
        $data = Transaction_Main::on('mysql_second')
        ->with('User')
        ->where('tran_method','Receive')
        ->where('tran_type','8')
        ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
        ->orderBy('tran_date')
        ->get();

        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Deposit Refunds
    public function Insert(Request $req){
        $req->validate([
            "method" => 'required',
            "type" => 'required|exists:mysql.transaction__main__heads,id',
            "guest_id" => 'required|exists:mysql_second.user__infos,user_id',
            "amount" => 'required',
            "booking_id" => 'required|exists:mysql_second.bookings,booking_id',
        ]);

        $id = GenerateTranId(8,'Refund','HMR');

        $data = null;

        DB::transaction(function () use ($req, $id, &$data) {
            $insert = Transaction_Main::on('mysql_second')->create([
                "tran_id" => $id,
                "tran_type" => $req->type,
                "tran_method" => "Refund",
                "tran_user" => $req->guest_id,
                "bill_amount" => $req->amount,
                "discount" => 0,
                "net_amount" => $req->amount,
                "receive" => 0,
                "payment" => $req->amount,
                "due" => 0,
                "booking_id" => $req->booking_id,
            ]);


            Transaction_Detail::on('mysql_second')->create([
                "tran_id" => $id,
                "tran_type" => $req->type,
                "tran_method" => "Refund",
                "tran_user" => $req->guest_id,
                "tran_groupe_id" => $req->groupe_id,
                "tran_head_id" => $req->head_id,
                "amount" => $req->amount,
                "quantity_actual" => 1,
                "quantity" => 1,
                "tot_amount" => $req->amount,
                "discount" => 0,
                "receive" => 0,
                "payment" => $req->amount,
                "due" => 0,
                "booking_id" => $req->booking_id,
            ]);

            $data = Transaction_Main::on('mysql_second')->with('User')->findOrFail($insert->id);
        });
        
        return response()->json([
            'status'=> true,
            'message' => 'Deposits Added Successfully',
            "data" => $data,
        ], 200);
    } // End Method



    // Update Deposit Refunds
    public function Update(Request $req){
        $req->validate([
            "guest_id" => 'required|exists:mysql_second.user__infos,user_id',
            "amount" => 'required',
            "booking_id" => 'required|exists:mysql_second.bookings,booking_id',
        ]);

        $transaction = Transaction_Main::on('mysql_second')->findOrFail($req->id);

        DB::transaction(function () use ($req, $transaction) {
            $transaction->update([
                "bill_amount" => $req->amount,
                "discount" => 0,
                "net_amount" => $req->amount,
                "receive" => 0,
                "payment" => $req->amount,
                "due" => 0,
                "booking_id" => $req->booking_id,
                "updated_at" => now()
            ]);

            // Delete the previous transaction details
            $details = Transaction_Detail::on('mysql_second')->where('tran_id', $req->tranid)->first();

            Transaction_Detail::on('mysql_second')->findOrFail($details->id)->update([
                "tran_user" => $req->guest_id,
                "amount" => $req->amount,
                "tot_amount" => $req->amount,
                "payment" => $req->amount,
                "booking_id" => $req->booking_id,
            ]);
        });

        $updatedData = Transaction_Main::on('mysql_second')->with('User')->findOrFail($req->id);

        return response()->json([
            'status'=>true,
            'message' => 'Transaction Updated Successfully',
            "updatedData" => $updatedData,
        ], 200); 
    } // End Method



    // Delete Deposit Refunds
    public function Delete(Request $req){
        $transaction = Transaction_Main::on('mysql_second')->findOrFail($req->id);
        
        Transaction_Main::on('mysql_second')->where("tran_id", $transaction->tran_id)->delete();
        Transaction_Detail::on('mysql_second')->where("tran_id", $transaction->tran_id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Transaction Deleted Successfully',
        ], 200);
    } // End Method



    // Search Deposit Refunds
    public function Search(Request $req){
        $data = Transaction_Main::on('mysql_second')
        ->with('User')
        ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
        ->where('tran_method',$req->method)
        ->where('tran_type', 8)
        ->orderBy('tran_id','asc')
        ->get();
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method

}
