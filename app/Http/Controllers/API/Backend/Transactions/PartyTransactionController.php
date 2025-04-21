<?php

namespace App\Http\Controllers\API\Backend\Transactions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;


use App\Models\Transaction_Groupe;
use App\Models\Transaction_Main;
use App\Models\Transaction_Detail;
use App\Models\Party_Payment_Receive;

class PartyTransactionController extends Controller
{
    // Show All Party Collection
    public function ShowAll(Request $req){
        $type = GetTranType($req->segment(2));
        $method = ucfirst($req->segment(4)); // Capitalize the first letter

        $data = Transaction_Main::on('mysql_second')
        ->with('User','Withs')
        ->whereHas('Withs', function ($query) use ($type) {
            $query->where('tran_type', $type);
        })
        ->where('tran_method', $method)
        ->where('tran_type', 2)
        ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
        ->orderBy('tran_date','asc')
        ->get();
        
        $groupes = Transaction_Groupe::on('mysql')->where('tran_groupe_type', '2')->whereIn('tran_method',["Receive",'Both'])->orderBy('added_at','asc')->get();
        
        
        if (!isset($type)) {
            return response()->json([
                'status' => false,
                'message' => 'You hit the Wrong Url',
            ], 400);
        }
        return response()->json([
            'status'=> true,
            'data' => $data,
            'groupes' => $groupes,
        ], 200);
    } // End Method



    // Insert Party Collection
    public function Insert(Request $req){
        $req->validate([
            "method" => 'required',
            "groupe" => 'required|exists:mysql.transaction__groupes,id',
            "head" => 'required|exists:mysql.transaction__heads,id',
            "with" => 'required|exists:mysql_second.transaction__withs,id',
            "user" => 'required|exists:mysql_second.user__infos,user_id',
            "amount" => 'required',
        ]);


        $transaction = Party_Payment_Receive::on('mysql_second')->where('tran_type', 2)->where('tran_method', $req->method)->latest('tran_id')->first();
        if($req->method == "Receive"){
            $id = ($transaction) ? 'PPR' . str_pad((intval(substr($transaction->tran_id, 3)) + 1), 9, '0', STR_PAD_LEFT) : 'PPR000000001';
        }
        else if($req->method == "Payment"){
            $id = ($transaction) ? 'PPP' . str_pad((intval(substr($transaction->tran_id, 3)) + 1), 9, '0', STR_PAD_LEFT) : 'PPP000000001';
        }

        // Get the Due List For Requested User
        $transaction = Transaction_Main::on('mysql_second')->where('tran_user', $req->user)
        ->where('due', '>', 0)
        ->orderBy('tran_date','asc')
        ->get();


        if($transaction){
            $totAmount = $req->amount + $req->discount;
            $billDiscount = $req->discount;
            $totDue = 0;
            foreach($transaction as $index => $tran) {
                $totDue = $totDue + $tran->due;
            }

            if($totAmount > 0){
                if($totDue < $totAmount){
                    return response()->json([
                        'errors' => [
                            'amount' => ['Amount should be less than equal to the due amount']
                        ]
                    ], 422);
                }
                else{
                    DB::transaction(function () use ($req, $id, $transaction, $totDue, $totAmount, $billDiscount) {
                        
                        $receive = $req->method === 'Receive' ? $req->amount : null;
                        $payment = $req->method === 'Payment' ? $req->amount : null;
                        Transaction_Main::on('mysql_second')->insert([
                            "tran_id" => $id,
                            "tran_type" => 2,
                            "tran_method" => $req->method,
                            "tran_type_with" => $req->withs,
                            "tran_user" => $req->user,
                            "bill_amount" => $totAmount,
                            "discount" => $req->discount,
                            "net_amount" => $req->amount,
                            "receive" => $receive,
                            "payment" => $payment,
                            "due" => 0,
                        ]);
                        

                        foreach($transaction as $index => $item) {
                            if($totAmount != 0){
                                if($item->due <= $totAmount){
                                    // Calculate and Update Main Table Transactions
                                    $discount = round( ($billDiscount * $item->due) / $totAmount);
                                    $due = $item->due - $discount;
                                    $due_col = $item->due_col + $due;
                                    $due_discount = $item->due_disc + $discount;


                                    $receive = $req->method === 'Receive' ? $due : null;
                                    $payment = $req->method === 'Payment' ? $due : null;
                                    Transaction_Main::on('mysql_second')->findOrFail($item->id)->update([
                                        "due_col" => $due_col,
                                        "due_disc" => $due_discount,
                                        "due" => 0,
                                        "updated_at" => now()
                                    ]);


                                    // Calculate and Update Details Table Transactions
                                    $details = Transaction_Detail::on('mysql_second')->where('tran_id', $item->tran_id)->get();
                                    $detailAmount = $item->due;
                                    $detailDiscount = $discount;
                                    foreach($details as $index => $detail){
                                        $detail_discount = round( ($detailDiscount * $detail->due) / $detailAmount);
                                        $detail_due = $detail->due - $detail_discount;
                                        $detail_due_col = $detail->due_col + $detail_due;
                                        $detail_due_disc = $detail->due_disc + $detail_discount;


                                        Transaction_Detail::on('mysql_second')->findOrFail($detail->id)->update([
                                            "due_col" => $detail_due_col,
                                            "due_disc" => $detail_due_disc,
                                            "due" => 0,
                                            "updated_at" => now()
                                        ]);


                                        $detail_receive = $req->method === 'Receive' ? $detail_due : null;
                                        $detail_payment = $req->method === 'Payment' ? $detail_due : null;
                                        Transaction_Detail::on('mysql_second')->insert([
                                            "tran_id" => $id,
                                            "tran_type" => 2,
                                            "tran_method" => $req->method,
                                            "tran_groupe_id" => $detail->tran_groupe_id,
                                            "tran_head_id" => $detail->tran_head_id,
                                            "tran_type_with" => $detail->tran_type_with,
                                            "tran_user" => $detail->tran_user,
                                            "discount" => $detail_discount,
                                            "receive" => $detail_receive,
                                            "payment" => $detail_payment,
                                            "batch_id" => $detail->tran_id,
                                        ]);

                                        $detailAmount = $detailAmount - $detail->due;
                                        $detailDiscount = $detailDiscount - $detail_discount;
                                    }


                                    Party_Payment_Receive::on('mysql_second')->insert([
                                        "tran_id" => $id,
                                        "tran_type" => 2,
                                        "tran_method" => $req->method,
                                        "tran_groupe_id" => $req->groupe,
                                        "tran_head_id" => $req->head,
                                        "tran_type_with" => $req->with,
                                        "tran_user" => $req->user,
                                        'bill_amount'=>$item->due,
                                        "discount" => $discount,
                                        'net_amount'=>$due,
                                        "receive" => $receive,
                                        "payment" => $payment,
                                        'due'=> 0,
                                        "party_amount" => $req->amount,
                                        "batch_id" => $item->tran_id,
                                    ]);

                                    $totAmount = $totAmount - $item->due;
                                    $billDiscount = $billDiscount - $discount;
                                }
                                else if($item->due > $totAmount){
                                    // Calculate and Update Main Table Transactions
                                    $due = $item->due - $totAmount;
                                    $due_col = $item->due_col + $totAmount - $billDiscount;
                                    $due_discount = $item->due_disc + $billDiscount;

                                    $receive = $req->method === 'Receive' ? ($totAmount - $billDiscount) : null;
                                    $payment = $req->method === 'Payment' ? ($totAmount - $billDiscount) : null;
                                    Transaction_Main::on('mysql_second')->findOrFail($item->id)->update([
                                        "due_col" => $due_col,
                                        "due_disc" => $due_discount,
                                        "due" => $due,
                                        "updated_at" => now()
                                    ]);


                                    // Calculate and Update Details Table Transactions
                                    $details = Transaction_Detail::on('mysql_second')->where('tran_id', $item->tran_id)->get();
                                    $detailAmount = $item->due;
                                    $detailPaid = $totAmount - $billDiscount;
                                    $detailDiscount = $billDiscount;
                                    foreach($details as $index => $detail){
                                        $detail_discount = round( ($detailDiscount * $detail->due) / $detailAmount);
                                        $detail_paid = round( ($detailPaid * $detail->due) / $detailAmount);
                                        $detail_due = $detail->due - $detail_paid - $detail_discount;
                                        $detail_due_col = $detail->due_col + $detail_paid;
                                        $detail_due_disc = $detail->due_disc + $detail_discount;


                                        Transaction_Detail::on('mysql_second')->findOrFail($detail->id)->update([
                                            "due_col" => $detail_due_col,
                                            "due_disc" => $detail_due_disc,
                                            "due" => $detail_due,
                                            "updated_at" => now()
                                        ]);

                                        $detail_receive = $req->method === 'Receive' ? $detail_paid : null;
                                        $detail_payment = $req->method === 'Payment' ? $detail_paid : null;

                                        Transaction_Detail::on('mysql_second')->insert([
                                            "tran_id" => $id,
                                            "tran_type" => 2,
                                            "tran_method" => $req->method,
                                            "tran_groupe_id" => $detail->tran_groupe_id,
                                            "tran_head_id" => $detail->tran_head_id,
                                            "tran_type_with" => $detail->tran_type_with,
                                            "tran_user" => $detail->tran_user,
                                            "discount" => $detail_discount,
                                            "receive" => $detail_receive,
                                            "payment" => $detail_payment,
                                            "batch_id" => $detail->tran_id,
                                        ]);

                                        $detailAmount = $detailAmount - $detail->due;
                                        $detailPaid = $detailPaid - $detail_paid;
                                        $detailDiscount = $detailDiscount - $detail_discount;
                                    }

                                    Party_Payment_Receive::on('mysql_second')->insert([
                                        "tran_id" => $id,
                                        "tran_type" => 2,
                                        "tran_method" => $req->method,
                                        "tran_groupe_id" => $req->groupe,
                                        "tran_head_id" => $req->head,
                                        "tran_type_with" => $req->with,
                                        "tran_user" => $req->user,
                                        'bill_amount'=>$item->due,
                                        "discount" => $billDiscount,
                                        'net_amount'=> $item->due - $billDiscount,
                                        "receive" => $receive,
                                        "payment" => $payment,
                                        'due'=> $due,
                                        "party_amount" => $req->amount,
                                        "batch_id" => $item->tran_id,
                                    ]);

                                    $billDiscount = 0;
                                    $totAmount = 0;
                                }
                            }
                        }
                    });

                    return response()->json([
                        'status'=> true,
                        'message' => 'Party Collection Added Successfully'
                    ], 200); 
                }
            }
        }
    } // End Method



    // Edit Party Collection
    public function Edit(Request $req){
        $data = Transaction_Main::on('mysql_second')->with('Location','User','withs','Store')->where('tran_id', $req->id )->first();
        return response()->json([
            'status'=> true,
            'data'=>$data,
        ], 200);
    } // End Method



    // // Update Party Collection
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
    //             'message' => 'Location Updated Successfully',
    //         ], 200); 
    //     }
    // } // End Method



    // // Delete Party Collection
    // public function Delete(Request $req){
    //     Location_Info::findOrFail($req->id)->delete();
    //     return response()->json([
    //         'status'=> true,
    //         'message' => 'Location Deleted Successfully',
    //     ], 200); 
    // } // End Method



    // Search Party Collection
    public function Search(Request $req){
        $type = GetTranType($req->segment(2));
        $method = ucfirst($req->segment(4)); // Capitalize the first letter

        $transaction = Transaction_Main::on('mysql_second')
        ->with('User', 'Withs')
        ->whereHas('Withs', function ($query) use ($req, $type) {
            $query->where('tran_type', $type);
        })
        ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
        ->where('tran_method', $method)
        ->where('tran_type', 2);

        if ($req->searchOption == 1) {
            $transaction->where('tran_id', 'like', '%' . $req->search . '%')->orderBy('tran_id');
        } 
        else if ($req->searchOption == 2) {
            $transaction->whereHas('User', function ($query) use ($req) {
                $query->where('user_name', 'like', '%' . $req->search . '%')->orderBy('user_name');
            });
        }

        $data = $transaction->paginate(15);
        
        if (!isset($type)) {
            return response()->json([
                'status' => false,
                'message' => 'You hit the Wrong Url',
            ], 400);
        }
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Get Transacetion Due List By User Id
    public function GetDueList(Request $req){
        if($req->id != ""){
            $data = Transaction_Main::on('mysql_second')->where('tran_user', 'like', '%'.$req->id.'%')
            ->where('due', '>', 0)
            ->orderBy('tran_date','asc')
            ->get();

            return response()->json([
                'status' => true,
                'data' => $data,
            ]);
        }
    } // End Method
}
