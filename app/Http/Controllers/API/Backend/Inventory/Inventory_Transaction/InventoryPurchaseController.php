<?php

namespace App\Http\Controllers\API\Backend\Inventory\Inventory_Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Transaction_Groupe;
use App\Models\Transaction_Head;
use App\Models\Transaction_Detail;
use App\Models\Transaction_Main;
use App\Models\Transaction_Details_Temp;
use App\Models\Transaction_Mains_Temp;

class InventoryPurchaseController extends Controller
{
    // Show All Inventory Purchase
    public function ShowAll(Request $req){
        $inventory = Transaction_Main::on('mysql_second')->with('User')->where('tran_method','Purchase')->where('tran_type','5')->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])->orderBy('tran_date','asc')->paginate(15);
        $groupes = Transaction_Groupe::on('mysql')->where('tran_groupe_type', '5')->whereIn('tran_method',["Payment",'Both'])->orderBy('added_at','asc')->get();
        return response()->json([
            'status'=> true,
            'data' => $inventory,
            'groupes' => $groupes,
        ], 200);
    } // End Method



    // Insert Inventory Purchase
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

        // Generates Auto Increment Purchase Id
        $transaction = Transaction_Mains_Temp::on('mysql_second')->where('tran_type', $req->type)->where('tran_method', $req->method)->latest('tran_id')->first();
        $id = ($transaction) ? 'IPP' . str_pad((intval(substr($transaction->tran_id, 3)) + 1), 9, '0', STR_PAD_LEFT) :  'IPP000000001';

        DB::transaction(function () use ($req, $id) {
            Transaction_Mains_Temp::on('mysql_second')->insert([
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

                Transaction_Details_Temp::on('mysql_second')->insert([
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
        });
        
        return response()->json([
            'status'=> true,
            'message' => 'Purchase Details Added Successfully'
        ], 200);  
    } // End Method



    // Edit Inventory Purchase
    public function Edit(Request $req){
        if($req->status == 1){
            $inventory = Transaction_Main::on('mysql_second')->with('Location','User','withs','Store')->where('tran_id', $req->id )->first();
            return response()->json([
                'status'=> true,
                'inventory'=> $inventory,
            ], 200);
        }
        else if($req->status == 2){
            $inventory = Transaction_Mains_Temp::on('mysql_second')->with('Location','User','withs','Store')->where('tran_id', $req->id )->first();
            return response()->json([
                'status'=> true,
                'inventory'=> $inventory,
            ], 200);
        }
    } // End Method



    // Update Inventory Purchase
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

        return response()->json([
            'status'=>true,
            'message' => 'Purchase Details Updated Successfully',
        ], 200);
    } // End Method



    // Delete Inventory Purchase
    public function Delete(Request $req){
        if($req->status == 1){
            $details = Transaction_Detail::on('mysql_second')->where("tran_id", $req->id)->get();

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

            Transaction_Main::on('mysql_second')->where("tran_id", $req->id)->delete();
            Transaction_Detail::on('mysql_second')->where("tran_id", $req->id)->delete();
        }
        else if($req->status == 2){
            $details = Transaction_Details_Temp::on('mysql_second')->where("tran_id", $req->id)->get();

            Transaction_Mains_Temp::on('mysql_second')->where("tran_id", $req->id)->delete();
            Transaction_Details_Temp::on('mysql_second')->where("tran_id", $req->id)->delete();
        }

        return response()->json([
            'status'=> true,
            'message' => 'Purchase Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Inventory Purchase
    public function Search(Request $req){
        if($req->status == 1){
            if($req->searchOption == 1){
                $inventory = Transaction_Main::on('mysql_second')->with('User')
                ->where('tran_id', "like", '%'. $req->search .'%')
                ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
                ->where('tran_method',$req->method)
                ->where('tran_type', $req->type)
                ->orderBy('tran_id','asc')
                ->paginate(15);
            }
            else if($req->searchOption == 2){
                $inventory = Transaction_Main::on('mysql_second')->with('User')
                ->whereHas('User', function ($query) use ($req) {
                    $query->where('user_name', 'like', '%'.$req->search.'%');
                    $query->orderBy('user_name','asc');
                })
                ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
                ->where('tran_method',$req->method)
                ->where('tran_type', $req->type)
                ->paginate(15);
            }
        }
        else if($req->status == 2){
            if($req->searchOption == 1){
                $inventory = Transaction_Mains_Temp::on('mysql_second')->with('User')
                ->where('tran_id', "like", '%'. $req->search .'%')
                ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
                ->where('tran_method',$req->method)
                ->where('tran_type', $req->type)
                ->orderBy('tran_id','asc')
                ->paginate(15);
            }
            else if($req->searchOption == 2){
                $inventory = Transaction_Mains_Temp::on('mysql_second')->with('User')
                ->whereHas('User', function ($query) use ($req) {
                    $query->where('user_name', 'like', '%'.$req->search.'%');
                    $query->orderBy('user_name','asc');
                })
                ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
                ->where('tran_method',$req->method)
                ->where('tran_type', $req->type)
                ->paginate(15);
            }
        }
        
        return response()->json([
            'status' => true,
            'data' => $inventory,
        ], 200);
    } // End Method



    // Verify Inventory Purchase
    public function Verify(Request $req){
        $details = Transaction_Details_Temp::on('mysql_second')->where("tran_id", $req->id)->get();
        $mains = Transaction_Mains_Temp::on('mysql_second')->where("tran_id", $req->id)->first();

        // Generates Auto Increment Purchase Id
        $transaction = Transaction_Main::on('mysql_second')->where('tran_type', $mains->tran_type)->where('tran_method', $mains->tran_method)->latest('tran_id')->first();
        $id = ($transaction) ? 'IPP' . str_pad((intval(substr($transaction->tran_id, 3)) + 1), 9, '0', STR_PAD_LEFT) :  'IPP000000001';


        Transaction_Main::on('mysql_second')->insert([
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

            Transaction_Detail::on('mysql_second')->insert([
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
    } // End Method
}
