<?php

namespace App\Http\Controllers\API\Backend\Setup\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Booking;
use App\Models\Transaction_Main;
use App\Models\Transaction_Detail;

class HotelBillSettlementController extends Controller
{
    // Show All Hotel Bill Settlement Data
    public function Show(Request $req)
    {
        $data = Booking::on('mysql_second')->with('User','Category','List','Sr','Bill')->where('status','1')->get();

        return response()->json([
            'status'=>true,
            'data'=>$data
        ],200);
    }



    // Edit Hotel Bill Settlement Data
    public function Edit(Request $req){
        $booking = Booking::on('mysql_second')->with('User','Category','List','Sr','Bill')->where('booking_id', $req->id)->first();
        $deposit = Transaction_Main::on('mysql_second')->where('tran_method', 'Deposit')->where('booking_id', $req->id)->sum('bill_amount');
        $refund = Transaction_Main::on('mysql_second')->where('tran_method', 'Refund')->where('booking_id', $req->id)->sum('bill_amount');
        $discount = Transaction_Main::on('mysql_second')->where('tran_method', 'Discount')->where('booking_id', $req->id)->sum('bill_amount');
        
        $transactionMain = Transaction_Main::on('mysql_second')
        ->select(
            DB::raw('SUM(bill_amount) as sum_bill_amount'), 
            DB::raw('SUM(discount) as sum_discount'), 
            DB::raw('SUM(net_amount) as sum_net_amount'), 
            DB::raw('SUM(receive) as sum_receive'), 
            DB::raw('SUM(payment) as sum_payment'), 
            DB::raw('SUM(due) as sum_due')
        )
        ->where('tran_method', 'Receive')
        ->where('booking_id', $req->id)
        ->first();

        
        
        $transDetailsInvoice = Transaction_Detail::on('mysql_second')
        ->with(['groupe', 'head'])
        ->select(
            'tran_groupe_id', 
            'tran_head_id', 
            'amount', 
            'quantity', 
            'quantity_actual',
            'tot_amount',
            'tran_id',
            'tran_date'
        )
        ->where('booking_id', $req->id)
        ->where('tran_method', 'Receive')
        ->orderBy('tran_groupe_id')
        ->orderBy('tran_id')
        ->get()
        ->groupBy('tran_groupe_id');

        return response()->json([
            'status'=> true,
            'data'=> view('common_modals.billclearence', compact('transactionMain', 'transDetailsInvoice', 'booking','deposit','refund','discount'))->render(),
        ]);
    }



    // Make Hotel Bill Settlement
    public function Settlement(Request $req)
    {
        $req->validate([
            "id"      => 'required|exists:mysql_second.bookings,booking_id',
            'discount' => 'required',
        ]);

        if(($req->receiveable && $req->discount > $req->receiveable) || ($req->payable && $req->discount > $req->payable)){
            return response()->json([
                'errors' => [
                    'message' => ["Discount amount can't be greater than settlement amount."]
                ]
            ], 422);
        }

        $booking = Booking::on('mysql_second')->where('booking_id', $req->id)->first();

        if($req->discount > 0){
            $tran_id = GenerateTranId(8,'Discount','HTD');
            DB::transaction(function () use ($req, $tran_id, $booking) {
                Transaction_Main::on('mysql_second')->create([
                    "tran_id" => $tran_id,
                    "tran_type" => 8,
                    "tran_method" => 'Discount',
                    "tran_user" => $booking->user_id,

                    "bill_amount" => $req->discount,
                    "discount" => $req->discount,
                    "net_amount" => 0,
                    "receive" => 0,
                    "payment" => 0,
                    "due" => 0,
                    'booking_id' => $req->id,
                ]);

                Transaction_Detail::on('mysql_second')->create([
                    "tran_id" => $tran_id,
                    "tran_type" => $req->type ?? 8,
                    "tran_method" => 'Discount',
                    "tran_user" => $booking->user_id,

                    "tran_groupe_id" => 9,
                    "tran_head_id" => 11,

                    "amount" => $req->discount,
                    "quantity_actual" => 1,
                    "quantity" => 1,
                    "tot_amount" => $req->discount,
                    "discount" => $req->discount,
                    "receive" => 0,
                    "payment" => 0,
                    "due" => 0,
                    'booking_id' => $req->id,
                ]);
            });
        }




        $amount = $req->receiveable - $req->discount;
        if($req->receiveable > 0){
            $id = GenerateTranId(8,'Deposit','HMD');

            DB::transaction(function () use ($req, $id, $amount, $booking) {
                $insert = Transaction_Main::on('mysql_second')->create([
                    "tran_id" => $id,
                    "tran_type" => $req->type ?? 8,
                    "tran_method" => "Deposit",
                    "tran_user" => $booking->user_id,
                    "bill_amount" => $amount,
                    "discount" => 0,
                    "net_amount" => $amount,
                    "receive" => $amount,
                    "payment" => 0,
                    "due" => 0,
                    "booking_id" => $booking->booking_id,
                    "payment_mode" => $req->payment_method ?? 1,
                ]);


                Transaction_Detail::on('mysql_second')->create([
                    "tran_id" => $id,
                    "tran_type" => $req->type ?? 8,
                    "tran_method" => "Deposit",
                    "tran_user" => $booking->user_id,

                    "tran_groupe_id" => 9,
                    "tran_head_id" => 9,

                    "amount" => $amount,
                    "quantity_actual" => 1,
                    "quantity" => 1,
                    "tot_amount" => $amount,
                    "discount" => 0,
                    "receive" => $amount,
                    "payment" => 0,
                    "due" => 0,
                    "booking_id" => $booking->booking_id,
                    "payment_mode" => $req->payment_method ?? 1,
                ]);

                Booking::on('mysql_second')->findOrFail($booking->id)->update([
                    'status' => 3,
                    'check_out' => now(),
                ]);
            });
        }
        else if($req->payable > 0){
            $id = GenerateTranId(8,'Refund','HMR');

            DB::transaction(function () use ($req, $id, $amount, $booking) {
                $insert = Transaction_Main::on('mysql_second')->create([
                    "tran_id" => $id,
                    "tran_type" => $req->type ?? 8,
                    "tran_method" => "Refund",
                    "tran_user" => $booking->user_id,
                    "bill_amount" => $amount,
                    "discount" => 0,
                    "net_amount" => $amount,
                    "receive" => 0,
                    "payment" => $amount,
                    "due" => 0,
                    "booking_id" => $booking->booking_id,
                    "payment_mode" => $req->payment_method ?? 1,
                ]);

                Transaction_Detail::on('mysql_second')->create([
                    "tran_id" => $id,
                    "tran_type" => $req->type ?? 8,
                    "tran_method" => "Refund",
                    "tran_user" => $booking->user_id,

                    "tran_groupe_id" => 9,
                    "tran_head_id" => 10,

                    "amount" => $amount,
                    "quantity_actual" => 1,
                    "quantity" => 1,
                    "tot_amount" => $amount,
                    "discount" => 0,
                    "receive" => 0,
                    "payment" => $amount,
                    "due" => 0,
                    "booking_id" => $booking->booking_id,
                    "payment_mode" => $req->payment_method ?? 1,
                ]);


                Booking::on('mysql_second')->findOrFail($booking->id)->update([
                    'status' => 3,
                    'check_out' => now(),
                ]);
            });
        }
        
        return response()->json([
            'status'      => true,
            'message'     => 'Hotel Bill Settlement Completed Successfully',
        ], 200);
    } // End Method
}
