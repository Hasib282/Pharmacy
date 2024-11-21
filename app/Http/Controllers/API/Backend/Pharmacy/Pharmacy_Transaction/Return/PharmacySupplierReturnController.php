<?php

namespace App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Transaction\Return;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Transaction_Groupe;
use App\Models\Transaction_Head;
use App\Models\Transaction_Detail;
use App\Models\Transaction_Main;

class PharmacySupplierReturnController extends Controller
{
    // Show All Supplier Return
    public function ShowAll(Request $req){
        $return = Transaction_Main::with('User')->where('tran_method','Supplier Return')->where('tran_type','6')->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])->orderBy('tran_date','asc')->paginate(15);
        $groupes = Transaction_Groupe::where('tran_groupe_type', '6')->whereIn('tran_method',["Receive",'Both'])->orderBy('added_at','asc')->get();

        return response()->json([
            'status'=> true,
            'data' => $return,
            'groupes' => $groupes,
        ], 200);
    } // End Method



    // Insert Supplier Return
    public function Insert(Request $req){
        // Validation Part Start
        $req->validate([
            "batch" => 'required',
            "method" => 'required',
            "type" => 'required',
            "withs" => 'required',
            "user" => 'required',
            "amountRP" => 'required',
            "discount" => 'required',
            "netAmount" => 'required',
            "advance" => 'required',
            "balance" => 'required',
            "store" => 'required'
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
        $transaction = Transaction_Main::where('tran_type', $req->type)->where('tran_method', $req->method)->latest('tran_id')->first();
        $id = ($transaction) ? 'PSR' . str_pad((intval(substr($transaction->tran_id, 3)) + 1), 9, '0', STR_PAD_LEFT) :  'PSR000000001';

        DB::transaction(function () use ($req, $id) {
            Transaction_Main::insert([
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
                "store_id" => $req->store
            ]);

            $billDiscount = $req->discount;
            $billAmount = $req->amountRP;
            $products = json_decode($req->products, true);
            foreach($products as $product){
                // Update Quantity in Product Table
                $p = Transaction_Head::findOrFail($product['product']);
                $quantity = $p->quantity - $product['quantity'];
                $p->update([
                    "quantity" => $quantity
                ]);

                $discount = round( ($billDiscount * $product['totAmount']) / $billAmount);

                // Update Quantity and Return Quantity Acording to Batch Id
                $batch = Transaction_Detail::where('tran_id', $req->batch)->where('tran_head_id', $product['product'])->first();
                $rem_quantity = $batch->quantity - $product['quantity'];
                $ret_quantity = $batch->quantity_return + $product['quantity'];
                $batch->update([
                    'quantity' => $rem_quantity,
                    'quantity_return' => $ret_quantity
                ]);



                Transaction_Detail::insert([
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
                    "unit_id" => $p->unit_id,
                    "tot_amount" => $product['totAmount'],
                    "discount" => $discount,
                    "mrp" => $p->mrp,
                    "cp" => $product['cp'],
                    "expiry_date" => $p->expiry_date,
                    "store_id" => $req->store,
                    "batch_id" => $req->batch
                ]);

                $billDiscount -= $discount;
                $billAmount -= $product['totAmount'];
           }
        });
        
        return response()->json([
            'status'=> true,
            'message' => 'Supplier Return Details Added Successfully'
        ], 200);  
    } // End Method



    // // Edit Supplier Return
    // public function Edit(Request $req){
    //     $location = Location_Info::findOrFail($req->id);
    //     return response()->json([
    //         'status'=> true,
    //         'location'=> $location,
    //     ], 200);
    // } // End Method



    // // Update Supplier Return
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

    //     if($update){
    //         return response()->json([
    //             'status'=>true,
    //             'message' => 'Supplier Return Details Updated Successfully',
    //         ], 200); 
    //     }
    // } // End Method



    // Delete Supplier Return
    public function Delete(Request $req){
        $details = Transaction_Detail::where("tran_id", $req->id)->get();
        DB::transaction(function () use ($req, $details) {
            foreach($details as $item){
                $product = Transaction_Head::findOrfail($item->tran_head_id);
                if($product){
                    $quantity = $product->quantity + $item->quantity;

                    $product->update([
                        "quantity" => $quantity
                    ]);

                    // Change the Issue Quantity
                    $batch = Transaction_Detail::where("tran_id", $item->batch_id)->where("tran_head_id", $item->tran_head_id)->first();
                    $detailQty = $batch->quantity +  $item->quantity;
                    $return = $batch->quantity_return - $item->quantity;

                    Transaction_Detail::where("tran_id", $item->batch_id)->where("tran_head_id", $item->tran_head_id)->update([
                        "quantity" => $detailQty,
                        "quantity_return" => $return
                    ]);
                }
            }

            Transaction_Main::where("tran_id", $req->id)->delete();
            Transaction_Detail::where("tran_id", $req->id)->delete();
        });

        return response()->json([
            'status'=> true,
            'message' => 'Supplier Return Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Supplier Return
    public function Search(Request $req){
        if($req->searchOption == 1){
            $return = Transaction_Main::with('User')
            ->where('tran_id', "like", '%'. $req->search .'%')
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', $req->type)
            ->orderBy('tran_id','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $return = Transaction_Main::with('User')
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
            'data' => $return,
        ], 200);
    } // End Method
}
