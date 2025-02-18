<?php

namespace App\Http\Controllers\API\Backend\Transactions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Transaction_Head;
use App\Models\Transaction_Detail;
use App\Models\Transaction_Main;

class IssueController extends Controller
{
    // Show All Pharmacy Issues
    public function ShowAll(Request $req){
        $type = GetTranType($req->segment(2));

        $issue = Transaction_Main::on('mysql_second')
        ->with('User')
        ->where('tran_method','Issue')
        ->where('tran_type', $type)
        ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
        ->orderBy('tran_date','asc')
        ->paginate(15);

        return response()->json([
            'status'=> true,
            'data' => $issue,
        ], 200);
    } // End Method



    // Insert Pharmacy Issues
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
            '5' => ['Issue' => 'IPI'],
            '6' => ['Issue' => 'PPI'],
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

                DB::transaction(function () use ($req, $id) {
                    Transaction_Main::on('mysql_second')->insert([
                        "tran_id" => $id,
                        "tran_type" => $req->type,
                        "tran_method" => $req->method,
                        "tran_type_with" => $req->withs,
                        "tran_user" => $req->user,
                        "user_name" => $req->name,
                        "user_phone" => $req->phone,
                        "user_address" => $req->address,
                        "bill_amount" => $req->amountRP,
                        "discount" => $req->discount,
                        "net_amount" => $req->netAmount,
                        "receive" => $req->advance,
                        "due" => $req->balance,
                        "store_id" => $req->store,
                    ]);
        
                    $billDiscount = $req->discount;
                    $billAmount = $req->amountRP;
                    $billNet = $req->netAmount;
                    $billAdvance = $req->advance;

                    $products = json_decode($req->products, true);
                    foreach($products as $product) {
                        if(isset($product['batch'])){ // If Batch Id is Selected
                            $purchase = Transaction_Detail::on('mysql_second')
                            ->where('tran_head_id', $product['product'])
                            ->where('tran_id', $product['batch'])
                            ->first();
                            
                            $quantity = $product['quantity'];

                            $issue =  $purchase->quantity_issue + $quantity ;
                            $dueQuantity = $purchase->quantity - $quantity;
                            // Calculate Profit
                            $totalMrp = $quantity * $product['mrp'];
                            $totalCp = $quantity * $purchase->cp;
                            // Calculate Discount
                            $discount = round( ($billDiscount * $totalMrp) / $billAmount);
                            
                            $amount = $totalMrp - $discount;
                            $advance = round( ($billAdvance * $amount) / $billNet );
                            $due = $amount - $advance;

                            Transaction_Detail::on('mysql_second')->findOrFail($purchase->id)->update([
                                "quantity_issue" => $issue,
                                "quantity" => $dueQuantity,
                                "updated_at" => now()
                            ]);

                            Transaction_Detail::on('mysql_second')->insert([
                                "tran_id" => $id,
                                "store_id" => $req->store,
                                "tran_type" => $req->type,
                                "tran_method" => $req->method,
                                "tran_groupe_id" => $product['groupe'],
                                "tran_head_id" => $product['product'],
                                "tran_type_with" => $req->withs,
                                "tran_user" => $req->user,
                                "user_name" => $req->name,
                                "user_phone" => $req->phone,
                                "user_address" => $req->address,
                                "amount" => $product['mrp'],
                                "mrp" => $product['mrp'],
                                "cp" => $purchase->cp,
                                "quantity_actual" => $quantity,
                                "quantity" => $quantity,
                                "unit_id" => $purchase->unit_id,
                                "tot_amount" => $totalMrp,
                                "discount" => $discount,
                                "receive" => $advance,
                                "due" => $due,
                                "expiry_date" => $purchase->expiry_date,
                                "batch_id" => $purchase->tran_id,
                            ]);
                            $quantity = 0;
                            $billDiscount -= $discount;
                            $billAmount -= $totalMrp;
                            $billAdvance -= $advance;
                            $billNet -= $amount;

                            $heads = Transaction_Head::on('mysql')->where('id',$product['product'])->first();
                            $remain_quantity = $heads->quantity - $product['quantity'];
                            Transaction_Head::on('mysql')->findOrFail($product['product'])->update([
                                "quantity" => $remain_quantity
                            ]);
                        }
                        else{ // If The batch id is not selected than continue with FIFO System
                            $purchase = Transaction_Detail::on('mysql_second')->where('tran_head_id', $product['product'])
                            ->where('quantity', '>', 0)
                            ->whereIn('tran_method', ["Purchase","Positive"])
                            ->orderBy('tran_date', 'asc')
                            ->get();
            
                            $quantity = $product['quantity'];
                            foreach($purchase as $index => $pro) {
                                if($quantity != 0){
                                    if($pro->quantity <= $quantity){
                                        $issue =  $pro->quantity_issue + $pro->quantity ;
                                        // Calculate Profit
                                        $totalMrp = $pro->quantity * $product['mrp'];
                                        $totalCp = $pro->quantity * $pro->cp;
                                        // Calculate Discount 
                                        $discount = round( ($billDiscount * $totalMrp) / $billAmount);
                                        
                                        $amount = $totalMrp - $discount;
                                        $advance = round( ($billAdvance * $amount) / $billNet );
                                        $due = $amount - $advance;
            
                                        Transaction_Detail::on('mysql_second')->findOrFail($pro->id)->update([
                                            "quantity_issue" => $issue,
                                            "quantity" => 0,
                                            "updated_at" => now()
                                        ]);
            
            
                                        Transaction_Detail::on('mysql_second')->insert([
                                            "tran_id" => $id,
                                            "store_id" => $req->store,
                                            "tran_type" => $req->type,
                                            "tran_method" => $req->method,
                                            "tran_groupe_id" => $product['groupe'],
                                            "tran_head_id" => $product['product'],
                                            "tran_type_with" => $req->with,
                                            "tran_user" => $req->user,
                                            "user_name" => $req->name,
                                            "user_phone" => $req->phone,
                                            "user_address" => $req->address,
                                            "amount" => $product['mrp'],
                                            "mrp" => $product['mrp'],
                                            "cp" => $pro->cp,
                                            "quantity_actual" => $pro->quantity,
                                            "quantity" => $pro->quantity,
                                            "unit_id" => $pro->unit_id,
                                            "tot_amount" => $totalMrp,
                                            "receive" => $advance,
                                            "due" => $due,
                                            "discount" => $discount,
                                            "expiry_date" => $pro->expiry_date,
                                            "batch_id" => $pro->tran_id,
                                        ]);
            
                                        $quantity = $quantity - $pro->quantity;
                                        $billDiscount -= $discount;
                                        $billAmount -= $totalMrp;
                                        $billAdvance -= $advance;
                                        $billNet -= $amount;
                                    }
                                    else if($pro->quantity > $quantity){
                                        $issue =  $pro->quantity_issue + $quantity ;
                                        $dueQuantity = $pro->quantity - $quantity;
                                        // Calculate Profit
                                        $totalMrp = $quantity * $product['mrp'];
                                        $totalCp = $quantity * $pro->cp;
                                        // Calculate Discount
                                        $discount = round( ($billDiscount * $totalMrp) / $billAmount);
                                        
                                        $amount = $totalMrp - $discount;
                                        $advance = round( ($billAdvance * $amount) / $billNet );
                                        $due = $amount - $advance;
            
                                        Transaction_Detail::on('mysql_second')->findOrFail($pro->id)->update([
                                            "quantity_issue" => $issue,
                                            "quantity" => $dueQuantity,
                                            "updated_at" => now()
                                        ]);
            
                                        Transaction_Detail::on('mysql_second')->insert([
                                            "tran_id" => $id,
                                            "store_id" => $req->store,
                                            "tran_type" => $req->type,
                                            "tran_method" => $req->method,
                                            "tran_groupe_id" => $product['groupe'],
                                            "tran_head_id" => $product['product'],
                                            "tran_type_with" => $req->withs,
                                            "tran_user" => $req->user,
                                            "user_name" => $req->name,
                                            "user_phone" => $req->phone,
                                            "user_address" => $req->address,
                                            "amount" => $product['mrp'],
                                            "mrp" => $product['mrp'],
                                            "cp" => $pro->cp,
                                            "quantity_actual" => $quantity,
                                            "quantity" => $quantity,
                                            "unit_id" => $pro->unit_id,
                                            "tot_amount" => $totalMrp,
                                            "discount" => $discount,
                                            "receive" => $advance,
                                            "due" => $due,
                                            "expiry_date" => $pro->expiry_date,
                                            "batch_id" => $pro->tran_id,
                                        ]);
                                        $quantity = 0;
                                        $billDiscount -= $discount;
                                        $billAmount -= $totalMrp;
                                        $billAdvance -= $advance;
                                        $billNet -= $amount;
                                    }
                                }
                            }
            
                            $heads = Transaction_Head::on('mysql')->where('id',$product['product'])->first();
                            $remain_quantity = $heads->quantity - $product['quantity'];
                            Transaction_Head::on('mysql')->findOrFail($product['product'])->update([
                                "quantity" => $remain_quantity
                            ]);
                        }
                    }
                });
                
                return response()->json([
                    'status'=> true,
                    'message' => 'Issue Details Added Successfully'
                ], 200);
            }
        }

        return response()->json([
            'status'=> false,
            'message' => 'Something is wrong!'
        ], 200);
    } // End Method



    // Edit Pharmacy Issues
    public function Edit(Request $req){
        $issue = Transaction_Main::on('mysql_second')->with('Location','User','withs','Store')->where('tran_id', $req->id )->first();
        return response()->json([
            'status'=> true,
            'issue'=> $issue,
        ], 200);
    } // End Method



    // Update Pharmacy Issues
    public function Update(Request $req){
        // Validation Part Start
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
        // Validation Part End


        $transaction = Transaction_Main::on('mysql_second')->findOrfail($req->id);

        DB::transaction(function () use ($req, $transaction) {
            $transaction->update([
                "user_name" => $req->name,
                "user_phone" => $req->phone,
                "user_address" => $req->address,
                "bill_amount" => $req->amountRP,
                "discount" => $req->totalDiscount,
                "net_amount" => $req->netAmount,
                "receive" => $req->advance,
                "due" => $req->balance,
                "updated_at" => now()
            ]);
            
            
            // Update the data and delete previous transaction
            $details = Transaction_Detail::on('mysql_second')->where('tran_id', $req->tranid)->get();
            foreach($details as $item){
                $product = Transaction_Head::on('mysql')->findOrfail($item->tran_head_id);
                if($product){
                    $quantity = $product->quantity + $item->quantity;

                    $product->update([
                        "quantity" => $quantity,
                        "updated_at" => now()
                    ]);
                }

                // Change the Issue Quantity
                $batch = Transaction_Detail::on('mysql_second')->where("tran_id", $item->batch_id)->where("tran_head_id", $item->tran_head_id)->first();
                $detailQty = $batch->quantity +  $item->quantity;
                $issue = $batch->quantity_issue - $item->quantity;

                Transaction_Detail::on('mysql_second')->where("tran_id", $item->batch_id)->where("tran_head_id", $item->tran_head_id)->update([
                    "quantity" => $detailQty,
                    "quantity_issue" => $issue
                ]);
            }
            Transaction_Detail::on('mysql_second')->where('tran_id', $req->tranid)->delete();


    
            $billDiscount = $req->totalDiscount;
            $billAmount = $req->amountRP;
            $billNet = $req->netAmount;
            $billAdvance = $req->advance;
            $products = json_decode($req->products, true);
            
            foreach($products as $product) {
                $purchase = Transaction_Detail::on('mysql_second')->where('tran_head_id', $product['product'])
                ->where('quantity', '>', 0)
                ->whereIn('tran_method', ["Purchase","Positive"])
                ->orderBy('tran_date', 'asc')
                ->get();

                $quantity = $product['quantity'];
                foreach($purchase as $index => $pro) {
                    if($quantity != 0){
                        if($pro->quantity <= $quantity){
                            $issue =  $pro->quantity_issue + $pro->quantity ;
                            // Calculate Profit
                            $totalMrp = $pro->quantity * $product['mrp'];
                            $totalCp = $pro->quantity * $pro->cp;
                            // Calculate Discount 
                            $discount = round( ($billDiscount * $totalMrp) / $billAmount);
                            
                            $amount = $totalMrp - $discount;
                            $advance = round( ($billAdvance * $amount) / $billNet );
                            $due = $amount - $advance;

                            Transaction_Detail::on('mysql_second')->findOrFail($pro->id)->update([
                                "quantity_issue" => $issue,
                                "quantity" => 0,
                                "updated_at" => now()
                            ]);


                            Transaction_Detail::on('mysql_second')->insert([
                                "tran_id" => $req->tranid,
                                "tran_type" => $transaction->tran_type,
                                "tran_method" => $transaction->tran_method,
                                "tran_groupe_id" => $product['groupe'],
                                "tran_head_id" => $product['product'],
                                "tran_type_with" => $transaction->tran_type_with,
                                "tran_user" => $transaction->tran_user,
                                "user_name" => $req->name,
                                "user_phone" => $req->phone,
                                "user_address" => $req->address,
                                "amount" => $product['mrp'],
                                "mrp" => $product['mrp'],
                                "cp" => $pro->cp,
                                "quantity_actual" => $pro->quantity,
                                "quantity" => $pro->quantity,
                                "unit_id" => $pro->unit_id,
                                "tot_amount" => $totalMrp,
                                "receive" => $advance,
                                "due" => $due,
                                "discount" => $discount,
                                "expiry_date" => $pro->expiry_date,
                                "batch_id" => $pro->tran_id,
                            ]);

                            $quantity = $quantity - $pro->quantity;
                            $billDiscount -= $discount;
                            $billAmount -= $totalMrp;
                            $billAdvance -= $advance;
                            $billNet -= $amount;
                        }
                        else if($pro->quantity > $quantity){
                            $issue =  $pro->quantity_issue + $quantity ;
                            $dueQuantity = $pro->quantity - $quantity;
                            // Calculate Profit
                            $totalMrp = $quantity * $product['mrp'];
                            $totalCp = $quantity * $pro->cp;
                            // Calculate Discount
                            $discount = round( ($billDiscount * $totalMrp) / $billAmount);
                            
                            $amount = $totalMrp - $discount;
                            $advance = round( ($billAdvance * $amount) / $billNet );
                            $due = $amount - $advance;

                            Transaction_Detail::on('mysql_second')->findOrFail($pro->id)->update([
                                "quantity_issue" => $issue,
                                "quantity" => $dueQuantity,
                                "updated_at" => now()
                            ]);

                            Transaction_Detail::on('mysql_second')->insert([
                                "tran_id" => $req->tranid,
                                "store_id" => $req->store,
                                "tran_type" => $transaction->tran_type,
                                "tran_method" => $transaction->tran_method,
                                "tran_groupe_id" => $product['groupe'],
                                "tran_head_id" => $product['product'],
                                "tran_type_with" => $transaction->tran_type_with,
                                "tran_user" => $transaction->tran_user,
                                "user_name" => $req->name,
                                "user_phone" => $req->phone,
                                "user_address" => $req->address,
                                "amount" => $product['mrp'],
                                "mrp" => $product['mrp'],
                                "cp" => $pro->cp,
                                "quantity_actual" => $quantity,
                                "quantity" => $quantity,
                                "unit_id" => $pro->unit_id,
                                "tot_amount" => $totalMrp,
                                "discount" => $discount,
                                "receive" => $advance,
                                "due" => $due,
                                "expiry_date" => $pro->expiry_date,
                                "batch_id" => $pro->tran_id,
                            ]);
                            $quantity = 0;
                            $billDiscount -= $discount;
                            $billAmount -= $totalMrp;
                            $billAdvance -= $advance;
                            $billNet -= $amount;
                        }
                    }
                }


                $heads = Transaction_Head::on('mysql')->findOrFail($product['product']);
                $remain_quantity = $heads->quantity - $product['quantity'];
                $heads->update([
                    "quantity" => $remain_quantity
                ]);
            }
        });

        return response()->json([
            'status'=>true,
            'message' => 'Issue Details Updated Successfully',
        ], 200); 
    } // End Method



    // Delete Pharmacy Issues
    public function Delete(Request $req){
        $details = Transaction_Detail::on('mysql_second')->where("tran_id", $req->id)->get();
        DB::transaction(function () use ($req, $details) {
            foreach($details as $item){
                $product = Transaction_Head::on('mysql')->findOrfail($item->tran_head_id);
                if($product){
                    $quantity = $product->quantity + $item->quantity;

                    $product->update([
                        "quantity" => $quantity,
                        "updated_at" => now()
                    ]);

                    // Change the Issue Quantity
                    $batch = Transaction_Detail::on('mysql_second')->where("tran_id", $item->batch_id)->where("tran_head_id", $item->tran_head_id)->first();
                    $detailQty = $batch->quantity +  $item->quantity;
                    $issue = $batch->quantity_issue - $item->quantity;

                    Transaction_Detail::on('mysql_second')->where("tran_id", $item->batch_id)->where("tran_head_id", $item->tran_head_id)->update([
                        "quantity" => $detailQty,
                        "quantity_issue" => $issue
                    ]);
                }
            }

            Transaction_Main::on('mysql_second')->where("tran_id", $req->id)->delete();
            Transaction_Detail::on('mysql_second')->where("tran_id", $req->id)->delete();
        });

        return response()->json([
            'status'=> true,
            'message' => 'Issue Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Pharmacy Issues
    public function Search(Request $req){
        if($req->searchOption == 1){
            $issue = Transaction_Main::on('mysql_second')->with('User')
            ->where('tran_id', "like", '%'. $req->search .'%')
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', $req->type)
            ->orderBy('tran_id','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $issue = Transaction_Main::on('mysql_second')->with('User')
            ->whereHas('User', function ($query) use ($req) {
                $query->where('user_name', 'like', '%'.$req->search.'%');
                $query->orderBy('user_name','asc');
            })
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', $req->type)
            ->paginate(15);
        }
        
        return response()->json([
            'status' => true,
            'data' => $issue,
        ], 200);
    } // End Method
}
