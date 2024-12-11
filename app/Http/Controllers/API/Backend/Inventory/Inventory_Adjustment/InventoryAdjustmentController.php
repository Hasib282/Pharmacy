<?php

namespace App\Http\Controllers\API\Backend\Inventory\Inventory_Adjustment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Transaction_Groupe;
use App\Models\Transaction_Head;
use App\Models\Transaction_Detail;

class InventoryAdjustmentController extends Controller
{
    // Show All Inventory Adjustment
    public function ShowAllPositive(Request $req){
        $adjust = Transaction_Detail::on('mysql')->with('Store','Head')->where('tran_method','Positive')->where('tran_type','5')->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])->orderBy('tran_date','asc')->paginate(15);
        $groupes = Transaction_Groupe::on('mysql_second')->where('tran_groupe_type', '5')->orderBy('added_at','asc')->get();
        return response()->json([
            'status'=> true,
            'data' => $adjust,
            'groupes' => $groupes,
        ], 200);
    } // End Method
    
    
    
    // Show All Inventory Adjustment
    public function ShowAllNegative(Request $req){
        $adjust = Transaction_Detail::on('mysql')->with('Store','Head')->where('tran_method','Negative')->where('tran_type','5')->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])->orderBy('tran_date','asc')->paginate(15);
        $groupes = Transaction_Groupe::on('mysql_second')->where('tran_groupe_type', '5')->orderBy('added_at','asc')->get();
        return response()->json([
            'status'=> true,
            'data' => $adjust,
            'groupes' => $groupes,
        ], 200);
    } // End Method



    // Insert Inventory Adjustment
    public function Insert(Request $req){
        $req->validate([
            "method" => 'required',
            "store" => 'required|numeric',
            "type" => 'required',
            "groupe" => 'required',
            "product" => 'required',
        ]);

        $prefixes = [
            '5' => ['Negative' => 'INA', 'Positive' => 'IPA'],
        ];
    
        if ($req->type && isset($prefixes[$req->type])) {
            $prefix = $prefixes[$req->type][$req->method] ?? null;
            if ($prefix) {
                $transaction = Transaction_Detail::on('mysql')->where('tran_type', $req->type)
                    ->where('tran_method', $req->method)
                    ->latest('tran_id')
                    ->first();
    
                $id = ($transaction) ? $prefix . str_pad((intval(substr($transaction->tran_id, 3)) + 1), 9, '0', STR_PAD_LEFT) : $prefix . '000000001';
                
                // Get Selected Product Details By Id
                $product = Transaction_Head::on('mysql_second')->findOrFail($req->product);
                if ($req->method === "Positive") {
                    $quantity = $product->quantity + $req->quantity;
                    $product->update([
                        "quantity" => $quantity,
                        "updated_at" => now()
                    ]);

                    Transaction_Detail::on('mysql')->insert([
                        "tran_id" => $id,
                        "store_id" => $req->store,
                        "tran_type" => $req->type,
                        "tran_method" => $req->method,
                        "tran_groupe_id" => $req->groupe,
                        "tran_head_id" => $req->product,
                        "quantity_actual" => $req->quantity,
                        "quantity" => $req->quantity,
                        "cp" => $product->cp,
                        "mrp" => $product->mrp,
                    ]);

                    return response()->json([
                        'status'=> true,
                        'message' => 'Adjustment Details Added Successfully'
                    ], 200);
                }
                else if ($req->method === "Negative") {
                    $quantity = $product->quantity - $req->quantity;
                    if ($product->quantity < $req->quantity) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Invalid Item Quantity Entered !'
                        ], 422);
                    }

                    $product->update([
                        "quantity" => $quantity,
                        "updated_at" => now()
                    ]);

                    Transaction_Detail::on('mysql')->insert([
                        "tran_id" => $id,
                        "store_id" => $req->store,
                        "tran_type" => $req->type,
                        "tran_method" => $req->method,
                        "tran_groupe_id" => $req->groupe,
                        "tran_head_id" => $req->product,
                        "quantity_actual" => $req->quantity,
                        "quantity" => $req->quantity,
                        "cp" => $product->cp,
                        "mrp" => $product->mrp,
                    ]);

                    return response()->json([
                        'status'=> true,
                        'message' => 'Adjustment Details Added Successfully'
                    ], 200);
                }
                else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Invalid method'
                    ], 200);
                }
            }
        }
        
          
    } // End Method



    // Edit Inventory Adjustment
    public function Edit(Request $req){
        $adjust = Transaction_Detail::on('mysql')->with('Store','Head')->findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'adjust'=> $adjust,
        ], 200);
    } // End Method



    // Update Inventory Adjustment
    public function Update(Request $req){
        $req->validate([
            "method" => 'required',
            "store" => 'required|numeric',
            "type" => 'required',
            "groupe" => 'required',
            "product" => 'required',
            "quantity" => 'required|numeric',
        ]);
    
        // Find the existing transaction
        $transaction = Transaction_Detail::on('mysql')->where('tran_id', $req->tranId)
            ->where('tran_head_id', $req->product)
            ->first();
    
        if ($transaction) {
            // Find the Product
            $product = Transaction_Head::on('mysql_second')->findOrFail($req->product);

            // Calculate the new quantity based on the method
            $quantity = $product->quantity;
            if ($req->method === "Positive") {
                $quantity = $quantity - $transaction->quantity + $req->quantity;
            } 
            else if ($req->method === "Negative") {
                $quantity = $quantity + $transaction->quantity - $req->quantity;
            }
            else {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid method'
                ], 404);
            }

            $product->update([
                "quantity" => $quantity,
                "updated_at" => now()
            ]);

            $transaction->update([
                "store_id" => $req->store,
                "tran_groupe_id" => $req->groupe,
                "tran_head_id" => $req->product,
                "quantity_actual" => $req->quantity,
                "quantity" => $req->quantity,
                "cp" => $product->cp,
                "mrp" => $product->mrp,
                "updated_at" => now()
            ]);
    
            return response()->json([
                'status'=>true,
                'message' => 'Adjustment Details Updated Successfully',
            ], 200); 
        } 
        else {
            return response()->json([
                'status' => false,
                'message' => 'Transaction not found'
            ], 404);
        }
    } // End Method



    // Delete Inventory Adjustment
    public function Delete(Request $req){
        $transaction = Transaction_Detail::on('mysql')->findOrFail($req->id);

        $product = Transaction_Head::on('mysql_second')->findOrFail($transaction->tran_head_id);

        $quantity = $product->quantity;
        if ($transaction->tran_method === "Positive") {
            $quantity -= $transaction->quantity;

            $product->update([
                "quantity" => $quantity,
                "updated_at" => now()
            ]);

            $transaction->delete();

            return response()->json([
                'status'=> true,
                'message' => 'Adjustment Details Deleted Successfully',
            ], 200); 
        } 
        else if ($transaction->tran_method === "Negative") {
            $quantity += $transaction->quantity;

            $product->update([
                "quantity" => $quantity,
                "updated_at" => now()
            ]);

            $transaction->delete();

            return response()->json([
                'status'=> true,
                'message' => 'Adjustment Details Deleted Successfully',
            ], 200);  
        } 
        else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid method'
            ], 404);
        }
        
    } // End Method



    // Search Inventory Adjustment
    public function Search(Request $req){
        if($req->searchOption == 1){
            $adjust = Transaction_Detail::on('mysql')->with('Store','Head')
            ->where('tran_id', "like", '%'. $req->search .'%')
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', $req->type)
            ->orderBy('tran_id','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $adjust = Transaction_Detail::on('mysql')->with('Store','Head')
            ->whereHas('Head', function ($query) use ($req) {
                $query->where('tran_head_name', 'like', '%'.$req->search.'%');
                $query->orderBy('tran_head_name','asc');
            })
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', $req->type)
            ->paginate(15);
        }
        
        return response()->json([
            'status' => true,
            'data' => $adjust,
        ], 200);
    } // End Method
}
