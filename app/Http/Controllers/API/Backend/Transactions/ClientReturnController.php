<?php

namespace App\Http\Controllers\API\Backend\Transactions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Transaction_Head;
use App\Models\Transaction_Detail;
use App\Models\Transaction_Main;

class ClientReturnController extends Controller
{
    // Show All Client Return
    public function Show(Request $req){
        $type = GetTranType($req->segment(2));

        $data = Transaction_Main::on('mysql_second')
        ->with('User')
        ->where('tran_method','Client Return')
        ->where('tran_type', $type)
        ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
        ->orderBy('tran_date','asc')
        ->get();

        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Client Return
    public function Insert(Request $req){
        // Validation Part Start
        $req->validate([
            "batch" => 'required',
            "method" => 'required',
            "type" => 'required|exists:mysql.transaction__main__heads,id',
            "user" => 'required|exists:mysql_second.user__infos,user_id',
            "amountRP" => 'required',
            "discount" => 'required',
            "netAmount" => 'required',
            "advance" => 'required',
            "balance" => 'required',
            "store" => 'required|exists:mysql_second.stores,id',
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
        // Validation Part End

        $prefixes = [
            '5' => ['Client Return' => 'ICR'],
            '6' => ['Client Return' => 'PCR'],
        ];

        if ($req->type && isset($prefixes[$req->type])) {
            $prefix = $prefixes[$req->type][$req->method] ?? null;
            if ($prefix) {
                $transaction = Transaction_Main::on('mysql_second')
                ->where('tran_type', $req->type)
                ->where('tran_method', $req->method)
                ->latest('tran_id')
                ->first();
    
                $id = ($transaction) ? $prefix . str_pad((intval(substr($transaction->tran_id, 3)) + 1), 9, '0', STR_PAD_LEFT) : $prefix . '000000001';

                $data = null;
                
                DB::transaction(function () use ($req, $id, &$data) {
                    $batchDetails = Transaction_Main::on('mysql_second')->where('tran_id', $req->batch)->first();
                    $insert = Transaction_Main::on('mysql_second')->create([
                        "tran_id" => $id,
                        "tran_type" => $req->type,
                        "tran_method" => $req->method,
                        "tran_type_with" => $req->withs,
                        "tran_user" => $req->user,
                        "user_name" => $batchDetails->user_name,
                        "user_phone" => $batchDetails->user_phone,
                        "user_address" => $batchDetails->user_address,
                        "bill_amount" => $req->amountRP,
                        "discount" => $req->discount,
                        "net_amount" => $req->netAmount,
                        "payment" => $req->advance,
                        "due" => $req->balance,
                        "store_id" => $req->store,
                    ]);
        
                    $billDiscount = $req->discount;
                    $billAmount = $req->amountRP;
                    $billNet = $req->netAmount;
                    $billAdvance = $req->advance;
                    $products = json_decode($req->products, true);
                    foreach($products as $product){
                        $totalAmount = $product['totAmount'];
                        // Update Quantity in Product Table
                        $p = Transaction_Head::on('mysql')->findOrFail($product['product']);
                        $quantity = $p->quantity + $product['quantity'];
                        $p->update([
                            "quantity" => $quantity
                        ]);
        
                        $discount = round( ($billDiscount * $totalAmount) / $billAmount);
                        $amount = $totalAmount - $discount;
                        $advance = round( ($billAdvance * $amount) / $billNet );
                        $due = $amount - $advance;
        
                        // Update Quantity and Return Quantity Acording to Batch Id
                        $batch = Transaction_Detail::on('mysql_second')->where('tran_id', $req->batch)->where('tran_head_id', $product['product'])->where('batch_id', $product['pbatch'])->first();
                        $rem_quantity = $batch->quantity - $product['quantity'];
                        $ret_quantity = $batch->quantity_return + $product['quantity'];
                        $batch->update([
                            'quantity' => $rem_quantity,
                            'quantity_return' => $ret_quantity
                        ]);
        
        
                        // Update Purchase Quantity Acording to Batch Id
                        $batch = Transaction_Detail::on('mysql_second')->where('tran_id', $product['pbatch'])->where('tran_head_id', $product['product'])->first();
                        $rem_quantity = $batch->quantity + $product['quantity'];
                        $rem_issue = $batch->quantity_issue - $product['quantity'];
                        $batch->update([
                            'quantity' => $rem_quantity,
                            'quantity_issue' => $rem_issue,
                        ]);
        
        
        
                        Transaction_Detail::on('mysql_second')->create([
                            "tran_id" => $id,
                            "tran_type" => $req->type,
                            "tran_method" => $req->method,
                            "tran_type_with" => $req->withs,
                            "tran_user" => $req->user,
                            "user_name" => $batchDetails->user_name,
                            "user_phone" => $batchDetails->user_phone,
                            "user_address" => $batchDetails->user_address,
                            "tran_groupe_id" => $product['groupe'],
                            "tran_head_id" => $product['product'],
                            "amount" => $product['amount'],
                            "quantity_actual" => $product['quantity'],
                            "quantity" => $product['quantity'],
                            "unit_id" => $p->unit_id,
                            "tot_amount" => $product['totAmount'],
                            "discount" => $discount,
                            "mrp" => $product['amount'],
                            "cp" => $p->cp,
                            "receive" => $advance,
                            "payment" => 0,
                            "due" => $due,
                            "expiry_date" => $p->expiry_date,
                            "store_id" => $req->store,
                            "batch_id" => $req->batch,
                        ]);
        
                        $billDiscount -= $discount;
                        $billAmount -= $totalAmount;
                        $billAdvance -= $advance;
                        $billNet -= $amount;
                   }

                   $data = Transaction_Main::on('mysql_second')->with('User')->findOrFail($insert->id);
                });
                
                
                return response()->json([
                    'status'=> true,
                    'message' => 'Client Return Details Added Successfully',
                    "data" => $data,
                ], 200);
            }
        }


        return response()->json([
            'status'=> false,
            'message' => 'Something is wrong!'
        ], 200); 
    } // End Method



    // // Update Client Return
    // public function Update(Request $req){
    //     $req->validate([
    //         "division" => 'required',
    //         "district"  => 'required',
    //         "upazila"  => 'required',
    //     ]);

    //     $update = Location_Info::findOrFail($req->id)->update([
    //         "district" => $req->district,
    //         "division" => $req->division,
    //         "upazila" => $req->upazila,
    //         "updated_at" => now()
    //     ]);

    //     $updatedData = Location_Info::findOrFail($req->id);

    //     if($update){
    //         return response()->json([
    //             'status'=>true,
    //             'message' => 'Client Return Details Updated Successfully',
    //             "updatedData" => $updatedData,
    //         ], 200); 
    //     }
    // } // End Method



    // Delete Client Return
    public function Delete(Request $req){
        $data = Transaction_Main::on('mysql_second')->findOrfail($req->id);
        $details = Transaction_Detail::on('mysql_second')->where("tran_id", $data->tran_id)->get();
        DB::transaction(function () use ($req, $details, &$data) {
            foreach($details as $item){
                $product = Transaction_Head::on('mysql')->findOrfail($item->tran_head_id);
                if($product){
                    $quantity = $product->quantity - $item->quantity;

                    $product->update([
                        "quantity" => $quantity
                    ]);

                    // Change the Issue Quantity
                    $batch = Transaction_Detail::on('mysql_second')->where("tran_id", $item->batch_id)->where("tran_head_id", $item->tran_head_id)->first();
                    $detailQty = $batch->quantity +  $item->quantity;
                    $return = $batch->quantity_return - $item->quantity;

                    Transaction_Detail::on('mysql_second')->where("tran_id", $item->batch_id)->where("tran_head_id", $item->tran_head_id)->update([
                        "quantity" => $detailQty,
                        "quantity_return" => $return
                    ]);
                }
            }

            Transaction_Detail::on('mysql_second')->where("tran_id", $data->tran_id)->delete();
            $data->delete();
        });

        return response()->json([
            'status'=> true,
            'message' => 'Client Return Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Client Return
    public function Search(Request $req){
        $data = Transaction_Main::on('mysql_second')
        ->with('User')
        ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
        ->where('tran_method',$req->method)
        ->where('tran_type', $req->type)
        ->orderBy('tran_id','asc')
        ->get();
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method
}
