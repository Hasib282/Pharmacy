<?php

namespace App\Http\Controllers\API\Backend\Transactions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Transaction_Head;
use App\Models\Transaction_Detail;

class AdjustmentController extends Controller
{
    // Show All Product/Item Adjustment Data
    public function ShowAll(Request $req){
        $type = GetTranType($req->segment(2));
        $method = ucfirst($req->segment(4));

        $adjust = Transaction_Detail::on('mysql_second')
        ->with('Head','Store')
        ->where('tran_method', $method)
        ->where('tran_type', $type)
        ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
        ->orderBy('tran_date','asc')
        ->paginate(15);

        return response()->json([
            'status'=> true,
            'data' => $adjust,
        ], 200);
    } // End Method



    // Insert Product/Item Adjustment
    public function Insert(Request $req){
        $req->validate([
            "method" => 'required',
            "store" => 'required|exists:mysql_second.stores,id',
            "type" => 'required|exists:mysql.transaction__main__heads,id',
            "groupe" => 'required|exists:mysql.transaction__groupes,id',
            "product" => 'required|exists:mysql.transaction__heads,id',
        ]);

        $prefixes = [
            '5' => ['Negative' => 'INA', 'Positive' => 'IPA'],
            '6' => ['Negative' => 'PNA', 'Positive' => 'PPA'],
        ];
    
        if ($req->type && isset($prefixes[$req->type])) {
            $prefix = $prefixes[$req->type][$req->method] ?? null;
            if ($prefix) {
                $transaction = Transaction_Detail::on('mysql_second')->where('tran_type', $req->type)
                    ->where('tran_method', $req->method)
                    ->latest('tran_id')
                    ->first();
    
                $id = ($transaction) ? $prefix . str_pad((intval(substr($transaction->tran_id, 3)) + 1), 9, '0', STR_PAD_LEFT) : $prefix . '000000001';
                
                // Get Selected Product Details By Id
                $product = Transaction_Head::on('mysql')->findOrFail($req->product);
                if ($req->method === "Positive") {
                    $quantity = $product->quantity + $req->quantity;
                    $product->update([
                        "quantity" => $quantity,
                        "updated_at" => now()
                    ]);

                    Transaction_Detail::on('mysql_second')->insert([
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

                    Transaction_Detail::on('mysql_second')->insert([
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
                    ], 404);
                }
            }
        }
    } // End Method



    // Edit Product/Item Adjustment
    public function Edit(Request $req){
        $adjust = Transaction_Detail::on('mysql_second')->with('Store','Head')->findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'adjust'=> $adjust,
        ], 200);
    } // End Method



    // Update Product/Item Adjustment
    public function Update(Request $req){
        $req->validate([
            "method" => 'required',
            "store" => 'required|exists:mysql_second.stores,id',
            "type" => 'required|exists:mysql.transaction__main__heads,id',
            "groupe" => 'required|exists:mysql.transaction__groupes,id',
            "product" => 'required|exists:mysql.transaction__heads,id',
            "quantity" => 'required|numeric'
        ]);
    
        // Find the existing transaction
        $transaction = Transaction_Detail::on('mysql_second')
            ->where('tran_id', $req->tranId)
            ->where('tran_head_id', $req->product)
            ->first();
    
        if ($transaction) {
            // Find the Product
            $product = Transaction_Head::on('mysql')->findOrFail($req->product);

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



    // Delete Product/Item Adjustment
    public function Delete(Request $req){
        $transaction = Transaction_Detail::on('mysql_second')->findOrFail($req->id);

        $product = Transaction_Head::on('mysql')->findOrFail($transaction->tran_head_id);

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



    // Search Product/Item Adjustment
    public function Search(Request $req){
        if($req->searchOption == 1){
            $adjust = Transaction_Detail::on('mysql_second')
            ->with('Head','Store')
            ->where('tran_id', "like", '%'. $req->search .'%')
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', $req->type)
            ->orderBy('tran_id','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $head = Transaction_Head::on('mysql')
            ->where('tran_head_name', 'like', '%'.$req->search.'%')
            ->orderby('tran_head_name')
            ->pluck('id');

            $adjust = Transaction_Detail::on('mysql_second')
            ->with('Head','Store')
            ->whereIn('tran_head_id', $head)
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
