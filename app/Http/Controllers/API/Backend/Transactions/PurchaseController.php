<?php

namespace App\Http\Controllers\API\Backend\Transactions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Transaction_Head;
use App\Models\Transaction_Detail;
use App\Models\Transaction_Main;
use App\Models\Transaction_Details_Temp;
use App\Models\Transaction_Mains_Temp;

class PurchaseController extends Controller
{
    // Show All Item/Product Purchase
    public function Show(Request $req){
        $type = GetTranType($req->segment(2));

        $data = Transaction_Main::on('mysql_second')
        ->with('User')
        ->where('tran_method','Purchase')
        ->where('tran_type', $type)
        ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
        ->orderBy('tran_date','asc')
        ->get();
        
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Item/Product Purchase
    public function Insert(Request $req){
        // Validation Part Start
        $req->validate([
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
            '5' => ['Purchase' => 'IIP'],
            '6' => ['Purchase' => 'PIP'],
        ];

        if ($req->type && isset($prefixes[$req->type])) {
            $prefix = $prefixes[$req->type][$req->method] ?? null;
            if ($prefix) {
                // $transaction = Transaction_Mains_Temp::on('mysql_second')
                // ->where('tran_type', $req->type)
                // ->where('tran_method', $req->method)
                // ->latest('tran_id')
                // ->first();
    
                // $id = ($transaction) ? $prefix . str_pad((intval(substr($transaction->tran_id, 3)) + 1), 9, '0', STR_PAD_LEFT) : $prefix . '000000001';

                $id = GenerateTranId($req->type, $req->method, $prefix);
                
                $data = null;

                DB::transaction(function () use ($req, $id, &$data) {
                    $insert = Transaction_Mains_Temp::on('mysql_second')->create([
                        "tran_id" => $id,
                        "tran_type" => $req->type,
                        "tran_method" => $req->method,
                        "tran_type_with" => $req->withs,
                        "tran_user" => $req->user,
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
                        $p = Transaction_Head::on('mysql')->findOrFail($product['product']);
                        // Calculate Profit
                        $totalMrp = $product['quantity'] * $product['mrp'];
                        $totalCp = $product['quantity'] * $product['cp'];
                        // Calculate Discount 
                        $discount = round( ($billDiscount * $totalCp) / $billAmount);
        
                        $amount = $totalCp - $discount;
                        $advance = round( ($billAdvance * $amount) / $billNet );
                        $due = $amount - $advance;
                        $p->update([
                            "cp" => $product['cp'],
                            "mrp" => $product['mrp'],
                            "expiry_date" => $product['expiry'],
                            "updated_at" => now()
                        ]);
        
                        Transaction_Details_Temp::on('mysql_second')->create([
                            "tran_id" => $id,
                            "tran_type" => $req->type,
                            "tran_method" => $req->method,
                            "tran_type_with" => $req->withs,
                            "tran_user" => $req->user,
                            "tran_groupe_id" => $product['groupe'],
                            "tran_head_id" => $product['product'],
                            "amount" => $product['cp'],
                            "quantity_actual" => $product['quantity'],
                            "quantity" => $product['quantity'],
                            "unit_id" => $product['unit'],
                            "tot_amount" => $product['totAmount'],
                            "discount" => $discount,
                            "mrp" => $product['mrp'],
                            "cp" => $product['cp'],
                            "payment" => $advance,
                            "due" => $due,
                            "expiry_date" => $product['expiry'] == null ? null : $product['expiry'],
                            "store_id" => $req->store,
                        ]);
        
                        $billDiscount -= $discount;
                        $billAmount -= $totalCp;
                        $billAdvance -= $advance;
                        $billNet -= $amount;
                    }
                    
                    $data = Transaction_Mains_Temp::on('mysql_second')->with('User')->findOrFail($insert->id);
                });


                return response()->json([
                    'status'=> true,
                    'message' => 'Purchase Details Added Successfully',
                    "data" => $data,
                ], 200); 
            }
        }

        return response()->json([
            'status'=> false,
            'message' => 'Something is wrong!'
        ], 200); 
    } // End Method



    // Update Item/Product Purchase
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



        if($req->status == 1){
            $transaction = Transaction_Main::on('mysql_second')->findOrfail($req->id);
        }
        else if($req->status == 2){
            $transaction = Transaction_Mains_Temp::on('mysql_second')->findOrfail($req->id);
        }

        DB::transaction(function () use ($req, $transaction) {
            $transaction->update([
                "bill_amount" => $req->amountRP,
                "discount" => $req->totalDiscount,
                "net_amount" => $req->netAmount,
                "receive" => 0,
                "payment" => $req->advance,
                "due" => $req->balance,
                "updated_at" => now()
            ]);
            
            
            if($req->status == 1){
                $details = Transaction_Detail::on('mysql_second')->where('tran_id', $req->tranid)->get();
                foreach($details as $item){
                    $product = Transaction_Head::on('mysql')->findOrfail($item->tran_head_id);
                    if($product){
                        $quantity = $product->quantity - $item->quantity;

                        $product->update([
                            "quantity" => $quantity,
                            "updated_at" => now()
                        ]);
                    }
                }
                Transaction_Detail::on('mysql_second')->where('tran_id', $req->tranid)->delete();
            }
            else if($req->status == 2){
                Transaction_Details_Temp::on('mysql_second')->where('tran_id', $req->tranid)->delete();
            }

    
            $billDiscount = $req->totalDiscount;
            $billAmount = $req->amountRP;
            $billNet = $req->netAmount;
            $billAdvance = $req->advance;
            $products = json_decode($req->products, true);
            
            foreach($products as $product) {
                $p = Transaction_Head::on('mysql')->findOrFail($product['product']);
                $quantity = $p->quantity + $product['quantity'];
                // Calculate Profit
                $totalMrp = $product['quantity'] * $product['mrp'];
                $totalCp = $product['quantity'] * $product['cp'];
                // Calculate Discount 
                $discount = round(($billDiscount * $totalCp) / $billAmount);

                $amount = $totalCp - $discount;
                $advance = round( ($billAdvance * $amount) / $billNet );
                $due = $amount - $advance;

                $p->update([
                    "cp" => $product['cp'],
                    "mrp" => $product['mrp'],
                    "expiry_date" => $product['expiry'],
                    "updated_at" => now()
                ]);
                
                
                $commonData = [
                    "tran_id" => $req->tranid,
                    "tran_type" => $transaction->tran_type,
                    "tran_method" => $transaction->tran_method,
                    "tran_type_with" => $transaction->tran_type_with,
                    "tran_user" => $transaction->tran_user,
                    "tran_groupe_id" => $product['groupe'],
                    "tran_head_id" => $product['product'],
                    "amount" => $product['cp'],
                    "quantity_actual" => $product['quantity'],
                    "quantity" => $product['quantity'],
                    "unit_id" => $product['unit'],
                    "tot_amount" => $product['totAmount'],
                    "discount" => $discount,
                    "mrp" => $product['mrp'],
                    "cp" => $product['cp'],
                    "payment" => $advance,
                    "due" => $due,
                    "expiry_date" => $product['expiry'] ?? null,
                    "store_id" => $transaction->store_id,
                    "tran_date" => $transaction->tran_date,
                ];
    
                // Update Product Details
                if ($req->status == 1) {
                    Transaction_Detail::on('mysql_second')->create($commonData);
                    $p->update([
                        "quantity" => $quantity,
                    ]);
                } 
                else if ($req->status == 2) {
                    Transaction_Details_Temp::on('mysql_second')->create($commonData);
                }
                
    
                $billDiscount -= $discount;
                $billAmount -= $totalCp;
                $billAdvance -= $advance;
                $billNet -= $amount;
            }
        });

        if($req->status == 1){
            $updatedData = Transaction_Main::on('mysql_second')->with('User')->findOrfail($req->id);
        }
        else if($req->status == 2){
            $updatedData = Transaction_Mains_Temp::on('mysql_second')->with('User')->findOrfail($req->id);
        }

        return response()->json([
            'status'=>true,
            'message' => 'Purchase Details Updated Successfully',
            "updatedData" => $updatedData,
        ], 200);
    } // End Method



    // Delete Item/Product Purchase
    public function Delete(Request $req){
        if($req->status == 1){
            $data = Transaction_Main::on('mysql_second')->findOrfail($req->id);
            $details = Transaction_Detail::on('mysql_second')->where("tran_id", $data->tran_id)->get();

            foreach($details as $item){
                $product = Transaction_Head::on('mysql')->findOrfail($item->tran_head_id);
                if($product){
                    $quantity = $product->quantity - $item->quantity;

                    $product->update([
                        "quantity" => $quantity,
                        "updated_at" => now()
                    ]);
                }
            }

            Transaction_Detail::on('mysql_second')->where("tran_id", $data)->delete();
            $data->delete();
        }
        else if($req->status == 2){
            $data = Transaction_Mains_Temp::on('mysql_second')->findOrfail($req->id);
            $details = Transaction_Details_Temp::on('mysql_second')->where("tran_id", $data->tran_id)->get();

            Transaction_Details_Temp::on('mysql_second')->where("tran_id", $data->tran_id)->delete();
            $data->delete();
        }

        return response()->json([
            'status'=> true,
            'message' => 'Purchase Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Item/Product Purchase
    public function Search(Request $req){
        if($req->status == 1){
            $data = Transaction_Main::on('mysql_second')
            ->with('User')
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', $req->type)
            ->orderBy('tran_id','asc')
            ->get();
        }
        else if($req->status == 2){
            $data = Transaction_Mains_Temp::on('mysql_second')
            ->with('User')
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', $req->type)
            ->orderBy('tran_id','asc')
            ->get();
        }
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Verify Item/Product Purchase
    public function Verify(Request $req){
        $details = Transaction_Details_Temp::on('mysql_second')->where("tran_id", $req->id)->get();
        $mains = Transaction_Mains_Temp::on('mysql_second')->where("tran_id", $req->id)->first();


        $prefixes = [
            '5' => ['Purchase' => 'IIP'],
            '6' => ['Purchase' => 'PIP'],
        ];

        if ($mains->tran_type && isset($prefixes[$mains->tran_type])) {
            $prefix = $prefixes[$mains->tran_type][$mains->tran_method] ?? null;
            if ($prefix) {
                $transaction = Transaction_Main::on('mysql_second')
                ->where('tran_type', $mains->tran_type)
                ->where('tran_method', $mains->tran_method)
                ->latest('tran_id')
                ->first();
                
    
                $id = ($transaction) ? $prefix . str_pad((intval(substr($transaction->tran_id, 3)) + 1), 9, '0', STR_PAD_LEFT) : $prefix . '000000001';
                
                Transaction_Main::on('mysql_second')->create([
                    "tran_id" => $id,
                    "tran_type" => $mains->tran_type,
                    "tran_method" => $mains->tran_method,
                    "tran_type_with" => $mains->tran_type_with,
                    "tran_user" => $mains->tran_user,
                    "user_name" => $mains->user_name,
                    "user_phone" => $mains->user_phone,
                    "user_address" => $mains->user_address,
                    "bill_amount" => $mains->bill_amount,
                    "discount" => $mains->discount,
                    "net_amount" => $mains->net_amount,
                    "payment" => $mains->payment,
                    "due" => $mains->due,
                    "store_id" => $mains->store_id,
                ]);
        
                
                
                foreach($details as $detail){
                    $p = Transaction_Head::on('mysql')->findOrFail($detail->tran_head_id);
                    $quantity = $p->quantity + $detail->quantity;
                    $p->update([
                        "quantity" => $quantity, 
                        "cp" => $detail->cp,
                        "mrp" => $detail->mrp,
                        "expiry_date" => $detail->expiry_date,
                        "updated_at" => now()
                    ]);
        
                    Transaction_Detail::on('mysql_second')->create([
                        "tran_id" => $id,
                        "tran_type" => $detail->tran_type,
                        "tran_method" => $detail->tran_method,
                        "tran_type_with" => $detail->tran_type_with,
                        "tran_user" => $detail->tran_user,
                        "user_name" => $mains->user_name,
                        "user_phone" => $mains->user_phone,
                        "user_address" => $mains->user_address,
                        "tran_groupe_id" => $detail->tran_groupe_id,
                        "tran_head_id" => $detail->tran_head_id,
                        "amount" => $detail->amount,
                        "quantity_actual" => $detail->quantity,
                        "quantity" => $detail->quantity,
                        "unit_id" => $detail->unit_id,
                        "discount" => $detail->discount,
                        "tot_amount" => $detail->tot_amount,
                        "mrp" => $detail->mrp,
                        "cp" => $detail->cp,
                        "payment" => $detail->payment,
                        "due" => $detail->due,
                        "expiry_date" => $detail->expiry_date == null ? null : $detail->expiry_date,
                        "store_id" => $detail->store_id,
                    ]);
                }
        
        
                Transaction_Details_Temp::on('mysql_second')->where("tran_id", $req->id)->delete();
                Transaction_Mains_Temp::on('mysql_second')->where("tran_id", $req->id)->delete();
        
                return response()->json([
                    'status'=> true,
                    'message' => 'Purchase Verified Successfully',
                ], 200); 
            }
        }
        
        return response()->json([
            'status'=> false,
            'message' => 'Something is wrong!'
        ], 200); 
    } // End Method
}
