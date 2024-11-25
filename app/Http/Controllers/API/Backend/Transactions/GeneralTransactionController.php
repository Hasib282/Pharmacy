<?php

namespace App\Http\Controllers\API\Backend\Transactions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Transaction_With;
use App\Models\Transaction_Groupe;
use App\Models\Transaction_Detail;
use App\Models\Transaction_Main;
use App\Models\Transaction_Details_Temp;
use App\Models\Transaction_Mains_Temp;
use App\Models\User_Info;

class GeneralTransactionController extends Controller
{
    // Show All General Transaction Receives
    public function ShowAllReceive(Request $req){
        $transactions = Transaction_Main::with('User')->where('tran_method','Receive')->where('tran_type','1')->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])->orderBy('tran_date','asc')->paginate(15);
        $groupes = Transaction_Groupe::where('tran_groupe_type', '1')->whereIn('tran_method',["Receive",'Both'])->orderBy('added_at','asc')->get();
        return response()->json([
            'status'=> true,
            'data' => $transactions,
            'groupes' => $groupes,
        ], 200);
    } // End Method
    
    
    
    // Show All General Transaction Payment
    public function ShowAllPayment(Request $req){
        $transactions = Transaction_Main::with('User')->where('tran_method','Payment')->where('tran_type','1')->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])->orderBy('tran_date','asc')->paginate(15);
        $groupes = Transaction_Groupe::where('tran_groupe_type', '1')->whereIn('tran_method',["Payment",'Both'])->orderBy('added_at','asc')->get();
        return response()->json([
            'status'=> true,
            'data' => $transactions,
            'groupes' => $groupes,
        ], 200);
    } // End Method



    // Insert General Transaction
    public function Insert(Request $req){
        $req->validate([
            "method" => 'required',
            "type" => 'required',
            "withs" => 'required',
            "user" => 'required',
            "locations" => 'required',
            "amountRP" => 'required',
            "discount" => 'required',
            "netAmount" => 'required',
            "advance" => 'required',
            "balance" => 'required',
            "company" => 'required'
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
        $transaction = Transaction_Main::where('tran_type', 1)->where('tran_method', $req->method)->latest('tran_id')->first();
        if($req->method === 'Receive'){
            $id = ($transaction) ? 'REC' . str_pad((intval(substr($transaction->tran_id, 3)) + 1), 9, '0', STR_PAD_LEFT) :  'REC000000001';
        }
        else if($req->method === 'Payment'){
            $id = ($transaction) ? 'PAY' . str_pad((intval(substr($transaction->tran_id, 3)) + 1), 9, '0', STR_PAD_LEFT) :  'PAY000000001';
        }
        

        DB::transaction(function () use ($req, $id) {
            $receive = $req->method === 'Receive' ? $req->advance : null;
            $payment = $req->method === 'Payment' ? $req->advance : null;
            Transaction_Main::insert([
                "tran_id" => $id,
                "tran_type" => 1,
                "tran_method" => $req->method,
                "tran_type_with" => $req->withs,
                "tran_user" => $req->user,
                "loc_id" => $req->locations,
                "bill_amount" => $req->amountRP,
                "discount" => $req->discount,
                "net_amount" => $req->netAmount,
                "receive" => $receive,
                "payment" => $payment,
                "due" => $req->balance,
                "company_id" => $req->company,
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

                Transaction_Detail::insert([
                    "tran_id" => $id,
                    "loc_id" => $req->location,
                    "tran_type" => 1,
                    "tran_method" => $req->method,
                    "tran_type_with" => $req->withs,
                    "tran_user" => $req->user,
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
                    "expiry_date" => $req->expiry == null ? null :$req->expiry,
                    "company_id" => $req->company,
                ]);

                $billDiscount -= $discount;
                $billAmount -= $totalAmount;
                $billAdvance -= $advance;
                $billNet -= $amount;
            }
        });
        
        return response()->json([
            'status'=> true,
            'message' => 'Transaction Added Successfully'
        ], 200);  
    } // End Method



    // Edit General Transaction
    public function Edit(Request $req){
        $transaction = Transaction_Main::with('Location','User','withs','Store')->where('tran_id', $req->id )->first();
        return response()->json([
            'status'=> true,
            'transaction'=> $transaction,
        ], 200);
    } // End Method



    // Update General Transaction
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

        $transaction = Transaction_Main::findOrFail($req->id);

        

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
            Transaction_Detail::where('tran_id', $req->tranid)->delete();


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

                $update = Transaction_Detail::insert([
                    "tran_id" => $req->tranid,
                    "loc_id" => $req->location,
                    "tran_type" => 1,
                    "tran_method" => $req->method,
                    "tran_type_with" => $req->withs,
                    "tran_user" => $req->user,
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

        return response()->json([
            'status'=>true,
            'message' => 'Transaction Updated Successfully',
        ], 200); 
    } // End Method



    // Delete General Transaction
    public function Delete(Request $req){
        Transaction_Main::where("tran_id", $req->id)->delete();
        Transaction_Detail::where("tran_id", $req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Transaction Deleted Successfully',
        ], 200); 
    } // End Method



    // Search General Transaction
    public function Search(Request $req){
        if($req->searchOption == 1){
            $transaction = Transaction_Main::with('User')
            ->where('tran_id', "like", '%'. $req->search .'%')
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', 1)
            ->orderBy('tran_id','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $transaction = Transaction_Main::with('User')
            ->whereHas('User', function ($query) use ($req) {
                $query->where('user_name', 'like', '%'.$req->search.'%');
                $query->orderBy('user_name','asc');
            })
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method',$req->method)
            ->where('tran_type', 1)
            ->paginate(15);
        }
        
        return response()->json([
            'status' => true,
            'data' => $transaction,
        ], 200);
    } // End Method



    // Show Transaction Invoice/Receipt
    public function Invoice(Request $req)
    {
        if($req->status == 1){
            $transactionMain = Transaction_Main::where('tran_id', $req->id)->first();
            $transDetailsInvoice = Transaction_Detail::
            select(
                'tran_head_id', 
                'amount', 
                DB::raw('SUM(quantity) as sum_quantity'), 
                DB::raw('SUM(quantity_actual) as sum_quantity_actual'), 
                DB::raw('SUM(tot_amount) as sum_tot_amount'), 
                DB::raw('COUNT(*) as count')
            )
            ->where('tran_id', $req->id)
            ->groupBy('tran_head_id','amount')
            ->get();
        }
        else if($req->status == 2){
            $transactionMain = Transaction_Mains_Temp::where('tran_id', $req->id)->first();
            $transDetailsInvoice = Transaction_Details_Temp::
            select(
                'tran_head_id', 
                'amount', 
                DB::raw('SUM(quantity) as sum_quantity'), 
                DB::raw('SUM(quantity_actual) as sum_quantity_actual'), 
                DB::raw('SUM(tot_amount) as sum_tot_amount'), 
                DB::raw('COUNT(*) as count')
            )
            ->where('tran_id', $req->id)
            ->groupBy('tran_head_id','amount')
            ->get();
        }
        
        return response()->json([
            'status' => true,
            'data' => view('transaction.invoice', compact('transactionMain', 'transDetailsInvoice'))->render(),
        ]);
    } // End Method




    // Get Inserted Transacetion Grid By Transaction Id
    public function GetTransactionGrid(Request $request){
        if($request->status == 1){
            $transaction = Transaction_Detail::with('Head')
            ->select(
                'tran_head_id',
                'mrp',
                'cp',
                'unit_id',
                'amount',
                'quantity_actual',
                DB::raw('SUM(tot_amount) as total_amount'),
                'tran_groupe_id',
                'expiry_date'
            )    
            ->where('tran_id', 'like', $request->tranId)
            ->groupBy('tran_head_id', 'tran_groupe_id', 'amount', 'quantity_actual', 'mrp', 'cp', 'unit_id', 'expiry_date')
            ->orderBy('tran_id','asc')
            ->get();
        }
        else if($request->status == 2){
            $transaction = Transaction_Details_Temp::with('Head')
            ->select(
                'tran_head_id',
                'mrp',
                'cp',
                'unit_id',
                'amount',
                'quantity_actual',
                DB::raw('SUM(tot_amount) as total_amount'),
                'tran_groupe_id',
                'expiry_date'
            )    
            ->where('tran_id', 'like', $request->tranId)
            ->groupBy('tran_head_id', 'tran_groupe_id', 'amount', 'quantity_actual', 'mrp', 'cp', 'unit_id', 'expiry_date')
            ->orderBy('tran_id','asc')
            ->get();
        }


        return response()->json([
            'status' => true,
            'transaction' => $transaction
        ]);
        // if ($transaction->isNotEmpty()) {
        //     return response()->json([
        //         'status' => true,
        //         'transaction' => $transaction
        //     ]);
        // } else {
        //     return response()->json([
        //         'status' => false
        //     ]); 
        // }
    } // End Method



    // Get User By User Type
    public function GetUser(Request $req){
        if($req->within == "1"){
            $users = User_Info::where('user_name', 'like', '%'.$req->tranUser.'%')
            ->whereIn('tran_user_type', $req->tranUserType)
            ->orderBy('user_name','asc')
            ->take(10)
            ->get();
        }
        else{
            if($req->tranUserType == ""){
                $list = '<li>Setect Type first</li>';
                return $list;
            }
            else{
                $users = User_Info::where('user_name', 'like', '%'.$req->tranUser.'%')
                ->where('tran_user_type', $req->tranUserType)
                ->orderBy('user_name','asc')
                ->take(10)
                ->get();
            }
        }

        if($users->count() > 0){
            $list = "";
            foreach($users as $index => $user) {
                $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$user->user_id.'"  data-with="'.$user->tran_user_type.'" data-name="'.$user->user_name.'" data-phone="'.$user->user_phone.'" data-address="'.$user->address.'">'.$user->user_name.'</li>';
            }
        }
        else{
            $list = '<li>No Data Found</li>';
        }
        return $list;
    } // End Method




    // Get Batch Id
    public function GetBatch(Request $req){  
        $batches = Transaction_Detail::select('tran_id')
        ->where('tran_id', 'like', '%'.$req->batch.'%')
        ->where('tran_type', $req->type)
        ->where('tran_method', $req->method)
        ->orderBy('tran_id','asc')
        ->groupby('tran_id')
        ->take(10)
        ->get();

        if($batches->count() > 0){
            $list = "";
            foreach($batches as $index => $batch) {
                $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$batch->tran_id.'">'.$batch->tran_id.'</li>';
            }
        }
        else{
            $list = '<li>No Data Found</li>';
        }
        return $list;
    } // End Method



    // Get Batch Details
    public function GetBatchDetails(Request $req){  
        $batches = Transaction_Detail::with('Head')
        ->where('tran_id', $req->batch)
        ->orderBy('tran_id','asc')
        ->get();

        if($batches->count() > 0){
            $list = "";
            foreach($batches as $index => $batch) {
                $list .= '
                <tr data-id="' . htmlspecialchars($batch->tran_head_id) . '" data-name="' . htmlspecialchars($batch->head->tran_head_name) . '" data-groupe="' . htmlspecialchars($batch->tran_groupe_id) . '" data-quantity="' . htmlspecialchars($batch->quantity) . '" data-cp="' . htmlspecialchars($batch->cp) . '" data-tot="' . htmlspecialchars($batch->tot_amount) . '" data-batch="' . htmlspecialchars($batch->batch_id) . '">
                    <td>' . htmlspecialchars($batch->head->tran_head_name) . '</td>
                    <td style="text-align: center">' . htmlspecialchars($batch->quantity) . '</td>
                    <td style="text-align: right">' . htmlspecialchars($batch->cp) . '</td>
                    <td style="text-align: right">' . htmlspecialchars($batch->tot_amount) . '</td>
                    <td style="text-align: center">' . htmlspecialchars($batch->batch_id) . '</td>
                </tr>';
            }
        }
        else{
            $list = '<tr>
                        <td>No Data Found</td>
                    </tr>';
        }
        return $list;
    } // End Method



    // Get Product Stock 
    public function GetProductStock(Request $req){
        $purchase = Transaction_Detail::where('tran_head_id', $req->product)
            ->where('quantity', '>', 0)
            ->whereIn('tran_method', ["Purchase","Positive"])
            ->get();

        $totQuantity = 0;
        foreach($purchase as $index => $pro) {
            $totQuantity = $totQuantity + $pro->quantity;
        }

        $result = $totQuantity < $req->quantity;
        
        return response()->json([
            'status' => 'success',
            'result' => $result,
            "totQuantity" => $totQuantity
        ]);
    } // End Method
}
