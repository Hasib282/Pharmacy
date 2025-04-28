<?php

namespace App\Http\Controllers\API\Backend\Transactions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Transaction_Detail;
use App\Models\Transaction_Main;

class ServicesController extends Controller
{
    // Show All Services
    public function Show(Request $req){
        $data = Transaction_Main::on('mysql_second')
        ->with('Patient')
        ->where('tran_method','Receive')
        ->where('tran_type','7')
        ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
        ->orderBy('tran_date')
        ->get();

        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Services
    public function Insert(Request $req){
        $req->validate([
            "method" => 'required',
            "type" => 'required|exists:mysql.transaction__main__heads,id',
            "ptn_id" => 'required|exists:mysql_second.patient__information,ptn_id',
            "amountRP" => 'required',
            "discount" => 'required',
            "netAmount" => 'required',
            "advance" => 'required',
            "balance" => 'required',
        ]);

        if($req->discount > $req->amountRP){
            return response()->json([
                'errors' => [
                    'message' => ["Discount amount can't be bigger than total amount"]
                ]
            ], 422);
        }
        if($req->discount < 0){
            return response()->json([
                'errors' => [
                    'message' => ["Discount amount can't be negative"]
                ]
            ], 422);
        }
        else if($req->advance  < 0){
            return response()->json([
                'errors' => [
                    'message' => ["Advance amount can't be negative"]
                ]
            ], 422);
        }
        else if($req->advance  > $req->netAmount){
            return response()->json([
                'errors' => [
                    'message' => ["Advance amount can't be bigger than Net amount"]
                ]
            ], 422);
        }

        // Generates Auto Increment Purchase Id
        $transaction = Transaction_Main::on('mysql_second')->where('tran_type', 7)->where('tran_method', $req->method)->latest('tran_id')->first();
        if($req->method === 'Receive'){
            $id = ($transaction) ? 'HTR' . str_pad((intval(substr($transaction->tran_id, 3)) + 1), 9, '0', STR_PAD_LEFT) :  'HTR000000001';
        }
        else if($req->method === 'Payment'){
            $id = ($transaction) ? 'HTP' . str_pad((intval(substr($transaction->tran_id, 3)) + 1), 9, '0', STR_PAD_LEFT) :  'HTP000000001';
        }

        $data = null;

        DB::transaction(function () use ($req, $id, &$data) {
            $receive = $req->method === 'Receive' ? $req->advance : null;
            $payment = $req->method === 'Payment' ? $req->advance : null;
            $insert = Transaction_Main::on('mysql_second')->create([
                "tran_id" => $id,
                "tran_type" => 7,
                "tran_method" => $req->method,
                "ptn_id" => $req->ptn_id,
                "bill_amount" => $req->amountRP,
                "discount" => $req->discount,
                "net_amount" => $req->netAmount,
                "receive" => $receive,
                "payment" => $payment,
                "due" => $req->balance,
            ]);


            $billDiscount = $req->discount;
            $billAmount = $req->amountRP;
            $billNet = $req->netAmount;
            $billAdvance = $req->advance;
            $products = json_decode($req->products, true);
            foreach($products as $product){
                $totalAmount = $product['totAmount'];
                // Calculate Discount 
                $discount = round( ($billDiscount * $totalAmount) / $billAmount);

                $amount = $totalAmount - $discount;
                $advance = round( ($billAdvance * $amount) / $billNet );
                $due = $amount - $advance;

                $receive = $req->method === 'Receive' ? $advance : null;
                $payment = $req->method === 'Payment' ? $advance : null;

                Transaction_Detail::on('mysql_second')->create([
                    "tran_id" => $id,
                    "tran_type" => 7,
                    "tran_method" => $req->method,
                    "ptn_id" => $req->ptn_id,
                    "tran_groupe_id" => $product['groupe'],
                    "tran_head_id" => $product['product'],
                    "amount" => $product['amount'],
                    "quantity_actual" => $product['quantity'],
                    "quantity" => $product['quantity'],
                    "tot_amount" => $product['totAmount'],
                    "discount" => $discount,
                    "receive" => $receive,
                    "payment" => $payment,
                    "due" => $due,
                ]);

                $billDiscount -= $discount;
                $billAmount -= $totalAmount;
                $billAdvance -= $advance;
                $billNet -= $amount;
            }

            $data = Transaction_Main::on('mysql_second')->with('Patient')->findOrFail($insert->id);
        });
        
        return response()->json([
            'status'=> true,
            'message' => 'Services Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method



    // Update Services
    public function Update(Request $req){
        $req->validate([
            "amountRP"  => 'required|numeric',
            "totalDiscount"  => 'required|numeric',
            "netAmount"  => 'required|numeric',
            "advance"  => 'required|numeric',
            "balance"  => 'required|numeric',
        ]);


        if($req->totalDiscount > $req->amountRP){
            return response()->json([
                'errors' => [
                    'message' => ["Discount amount can't be bigger than total amount"]
                ]
            ], 422);
        }
        if($req->totalDiscount < 0){
            return response()->json([
                'errors' => [
                    'message' => ["Discount amount can't be negative"]
                ]
            ], 422);
        }
        else if($req->advance  < 0){
            return response()->json([
                'errors' => [
                    'message' => ["Advance amount can't be negative"]
                ]
            ], 422);
        }
        else if($req->advance  > $req->netAmount){
            return response()->json([
                'errors' => [
                    'message' => ["Advance amount can't be bigger than Net amount"]
                ]
            ], 422);
        }

        $transaction = Transaction_Main::on('mysql_second')->findOrFail($req->id);

        

        DB::transaction(function () use ($req, $transaction) {
            $receive = $req->method == 'Receive' ? $req->advance : null;
            $payment = $req->method == 'Payment' ? $req->advance : null;

            $transaction->update([
                "bill_amount" => $req->amountRP,
                "discount" => $req->totalDiscount,
                "net_amount" => $req->netAmount,
                "receive" => $receive,
                "payment" => $payment,
                "due" => $req->balance,
                "updated_at" => now()
            ]);


            // Delete the previous transaction details
            Transaction_Detail::on('mysql_second')->where('tran_id', $req->tranid)->delete();


            $billDiscount = $req->totalDiscount;
            $billAmount = $req->amountRP;
            $billNet = $req->netAmount;
            $billAdvance = $req->advance;
            $products = json_decode($req->products, true);
            foreach($products as $product){
                $totalAmount = $product['totAmount'];
                // Calculate Discount 
                $discount = round( ($billDiscount * $totalAmount) / $billAmount);

                $amount = $totalAmount - $discount;
                $advance = round( ($billAdvance * $amount) / $billNet );
                $due = $amount - $advance;

                $receive = $req->method == 'Receive' ? $advance : null;
                $payment = $req->method == 'Payment' ? $advance : null;

                $update = Transaction_Detail::on('mysql_second')->create([
                    "tran_id" => $req->tranid,
                    "tran_type" => 7,
                    "tran_method" => $req->method,
                    "ptn_id" => $req->ptn_id,
                    "tran_groupe_id" => $product['groupe'],
                    "tran_head_id" => $product['product'],
                    "amount" => $product['amount'],
                    "quantity_actual" => $product['quantity'],
                    "quantity" => $product['quantity'],
                    "tot_amount" => $product['totAmount'],
                    "discount" => $discount,
                    "receive" => $receive,
                    "payment" => $payment,
                    "due" => $due,
                    "tran_date" => $transaction->tran_date,
                ]);

                $billDiscount -= $discount;
                $billAmount -= $totalAmount;
                $billAdvance -= $advance;
                $billNet -= $amount;
            }
        });

        $updatedData = Transaction_Main::on('mysql_second')->with('Patient')->findOrFail($req->id);

        return response()->json([
            'status'=>true,
            'message' => 'Transaction Updated Successfully',
            "updatedData" => $updatedData,
        ], 200); 
    } // End Method



    // Delete Services
    public function Delete(Request $req){
        $transaction = Transaction_Main::on('mysql_second')->findOrFail($req->id);
        
        Transaction_Main::on('mysql_second')->where("tran_id", $transaction->tran_id)->delete();
        Transaction_Detail::on('mysql_second')->where("tran_id", $transaction->tran_id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Transaction Deleted Successfully',
        ], 200);
    } // End Method



    // Search Services
    public function Search(Request $req){
        $data = Transaction_Main::on('mysql_second')
        ->with('Patient')
        ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
        ->where('tran_method',$req->method)
        ->where('tran_type', 7)
        ->orderBy('tran_id','asc')
        ->get();
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method
}
