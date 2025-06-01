<?php

namespace App\Http\Controllers\API\Backend\Setup\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Booking;
use App\Models\User_Info;
use App\Models\Transaction_Main;
use App\Models\Transaction_Detail;
use App\Models\Transaction_Head;

class HotelBookingController extends Controller
{
    // Show All Booking/Reservation
    public function Show(Request $req){
        $data = Booking::on('mysql_second')->with('User','Category','List','Sr','Bill')->get();

        return response()->json([
            'status'=>true,
            'data'=>$data
        ],200);
    } // End Method


    
    // Insert Booking/Reservation
    public function Insert(Request $req){
        // common validations for both new and existing guests
        $rules = [
            'check_in' => 'required',
            'children' => 'required|numeric',
            'adult' => 'required|numeric',
            'status' => 'required',
            'bed_category' => 'required|exists:mysql_second.bed__categories,id',
            'bed_id' => 'required|exists:mysql_second.bed__lists,id',
            'sr' => 'nullable|exists:mysql_second.user__infos,user_id',
            'payment_method' => 'required|exists:mysql.payment__methods,id',
        ];

        // Conditional validation for "new" guest
        if ($req->guest_type === 'new') {
            $rules = array_merge($rules, [
                'title' => 'required',
                'name' => 'required',
                'phone' => 'required',
            ]);
        } else {
            $rules['guest'] = 'required|exists:mysql_second.user__infos,user_id';
        }

        $req->validate($rules);

        $data = null;

        DB::transaction(function () use ($req, &$data ) {
            $guest_id = $req->guest;
            $groupe = GetTranType($req->segment(2));
            $head = Transaction_Head::on('mysql')->where('groupe_id',$groupe)->where('tran_head_name','Bed-'.$req->bed_list)->first();

            //auto generate booking id
            $id = Booking::on('mysql_second')->orderby('booking_id','desc')->first();
            $booking_id = $id ? 'HBI' . str_pad((intval(substr($id->booking_id, 3)) + 1), 9, '0', STR_PAD_LEFT) : 'HBI000000001';
            
            if($req->guest_type == "new"){
                // Generate guest ID using the helper function
                $guest_id = GenerateUserId(7, 'GT');

                User_Info::on('mysql_second')->create([
                    'user_id'=>$guest_id,
                    'title'=>$req->title,
                    'user_name'=> $req->name,
                    'user_email'=> $req->email,
                    'user_phone'=> $req->phone,
                    'user_role'=> 7,
                    'nid'=> $req->nid,
                    'passport'=> $req->passport,
                    'driving_lisence'=> $req->driving_lisence,
                    'gender'=> $req->gender,
                    "nationality"=> $req->nationality,
                    'religion'=> $req->religion,
                    'address'=> $req->address,
                ]);
            }

            $tran_id = GenerateTranId(8,'Deposit','HMD');
            
            $insert = Booking::on('mysql_second')->create([
                'booking_id' => $booking_id,
                'user_id' => $guest_id,
                'bed_category' => $req->bed_category,
                'bed_list' => $req->bed_id,
                'sr_id' => $req->sr,
                'adult'=>$req->adult,
                'children'=> $req->children,
                'check_in'=> $req->check_in,
                'check_out'=> $req->check_out,
                'tran_id' => $tran_id,
                'status' => $req->status
            ]);

            Transaction_Main::on('mysql_second')->create([
                "tran_id" => $tran_id,
                "tran_type" => 8,
                "tran_method" => 'Deposit',
                "tran_user" => $guest_id,
                "bill_amount" => $req->advance,
                "discount" => 0,
                "net_amount" => $req->advance,
                "receive" => $req->advance,
                "payment" => 0,
                "due" => 0,
                "payment_mode" => $req->payment_method,
                'booking_id' => $booking_id,
            ]);

            Transaction_Detail::on('mysql_second')->create([
                "tran_id" => $tran_id,
                "tran_type" => 8,
                "tran_method" => 'Deposit',
                "tran_user" => $guest_id,
                "tran_groupe_id" => 9,
                "tran_head_id" => 9,
                "amount" => $req->advance,
                "quantity_actual" => 1,
                "quantity" => 1,
                "tot_amount" => $req->advance,
                "discount" => 0,
                "receive" => $req->advance,
                "payment" => 0,
                "due" => 0,
                "payment_mode" => $req->payment_method,
                'booking_id' => $booking_id,
            ]);

            $data = Booking::on('mysql_second')->with('User','Category','List','Sr','Bill')->findOrFail($insert->id);
        });
        
        
        return response()->json([
            'status'=> true,
            'message' => 'Booking Added Successfully',
            "data" => $data,
        ], 200); 
    } // End Method



    // Update Booking/Reservation
    public function Update(Request $req){
        $req->validate([
            'guest' => 'required|exists:mysql_second.user__infos,user_id',
            'check_in' => 'required',
            'children' => 'required',
            'adult' => 'required',
            'status' => 'required',
            'bed_category' =>'required|exists:mysql_second.bed__categories,id',
            'bed_id' =>'required|exists:mysql_second.bed__lists,id',
            'sr' =>'nullable|exists:mysql_second.user__infos,user_id',
            'payment_method' =>'required|exists:mysql.payment__methods,id',
        ]);

        $data = Booking::on('mysql_second')->findOrFail($req->id);

        DB::transaction(function () use ($req, &$data ) {
            $update = Booking::on('mysql_second')->findOrFail($req->id)->update([
                'user_id' => $req->guest,
                'bed_category' => $req->bed_category,
                'bed_list' => $req->bed_id,
                'sr_id' => $req->sr,
                'adult'=>$req->adult,
                'children'=> $req->children,
                'check_in'=> $req->check_in,
                'check_out'=> $req->check_out,
                'status' => $req->status,
                "updated_at" => now()
            ]);

            Transaction_Main::on('mysql_second')->where('tran_id',$data->tran_id)->Update([
                "bill_amount" => $req->advance,
                "net_amount" => $req->advance,
                "receive" => $req->advance,
                "payment_mode" => $req->payment_method,
            ]);

            Transaction_Detail::on('mysql_second')->where('tran_id',$data->tran_id)->Update([
                "amount" => $req->advance,
                "tot_amount" => $req->advance,
                "receive" => $req->advance,
                "payment_mode" => $req->payment_method,
            ]);
        });

        $updatedData = Booking::on('mysql_second')->with('User','Category','List','Sr','Bill')->findOrFail($req-> id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Booking Added Successfully',
            "updatedData" => $updatedData,
        ], 200);
    } // End Method



    // Delete Booking/Reservation
    public function Delete(Request $req){
        Booking::on('mysql_second')->findOrFail($req->id)->delete();

        return response()->json([
            'status'=> true,
            'message'=> 'Booking Deleted Successfully'
        ], 200);
    } // End Method
    
    
    
    // Get Booking/Reservation Id
    public function Get(Request $req){
        $data = Booking::on('mysql_second')
        ->where('user_id', $req->user_id)
        ->where('booking_id', 'like', $req->booking_id.'%')
        ->where('status', 1)
        ->get();
        
        $list = "<ul>";
            if($data->count() > 0){
                foreach($data as $index => $item) {
                    $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$item->booking_id.'" data-checkin="'.$item->check_in.'" data-checkout="'.$item->check_out.'">'.$item->booking_id.'</li>';
                }
            }
            else{
                if($req->user_id != 'undefined' && $data->count() > 0){
                    $list .= '<li>Select User First</li>';
                }
                else{
                    $list .= '<li>No Data Found</li>';
                }
            }
        $list .= "</ul>";

        return $list;
    } // End Method



    // Show Booking Clearence Invoice/Receipt
    public function Invoice(Request $req)
    {
        $booking = Booking::on('mysql_second')->with('User','Category','List','Sr','Bill')->where('booking_id', $req->id)->first();
        $deposit = Transaction_Main::on('mysql_second')->where('tran_method', 'Deposit')->where('booking_id', $req->id)->sum('bill_amount');
        $refund = Transaction_Main::on('mysql_second')->where('tran_method', 'Refund')->where('booking_id', $req->id)->sum('bill_amount');
        
        $transactionMain = Transaction_Main::on('mysql_second')
        ->select(
            DB::raw('SUM(bill_amount) as sum_bill_amount'), 
            DB::raw('SUM(discount) as sum_discount'), 
            DB::raw('SUM(net_amount) as sum_net_amount'), 
            DB::raw('SUM(receive) as sum_receive'), 
            DB::raw('SUM(payment) as sum_payment'), 
            DB::raw('SUM(due) as sum_due')
        )
        ->where('tran_method', 'Receive')
        ->where('booking_id', $req->id)
        ->first();

        
        
        $transDetailsInvoice = Transaction_Detail::on('mysql_second')->
        select(
            'tran_head_id', 
            'amount', 
            DB::raw('SUM(quantity) as sum_quantity'), 
            DB::raw('SUM(quantity_actual) as sum_quantity_actual'), 
            DB::raw('SUM(tot_amount) as sum_tot_amount'), 
            DB::raw('COUNT(*) as count'),
            'tran_id',
            'tran_date'
        )
        ->where('booking_id', $req->id)
        ->where('tran_method', 'Receive')
        ->groupBy('tran_head_id','amount', 'tran_id', 'tran_date')
        ->get();
        
        $pdf = Pdf::loadView('common_modals.billclearence', compact('transactionMain', 'transDetailsInvoice', 'booking','deposit','refund'));
        return $pdf->stream();
    } // End Method
}
