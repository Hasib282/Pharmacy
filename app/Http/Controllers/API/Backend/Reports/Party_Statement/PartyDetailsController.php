<?php

namespace App\Http\Controllers\API\Backend\Reports\Party_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Transaction_Main;
use App\Models\Party_Payment_Receive;

class PartyDetailsController extends Controller
{
    // Show All Salary Details Report
    public function Show(Request $req){
        $transactions = Transaction_Main::on('mysql_second')
        ->with('User', 'Bank', 'Withs', 'Type')
        ->whereNotIn('tran_type',['2','4'])
        ->select(
            'tran_id',
            'tran_method',
            'tran_type',
            'tran_user',
            'tran_bank',
            'bill_amount',
            'discount as main_discount',
            'net_amount',
            'receive as main_receive',
            'payment as main_payment',
            DB::raw('null as due_discount'),
            DB::raw('null as due_receive'),
            DB::raw('null as due_payment'),
            'due',
            'tran_date',
            DB::raw('1 as source')
        )
        ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
        ->union(
            Party_Payment_Receive::on('mysql_second')
            ->select(
                'batch_id as tran_id',
                'tran_method',
                'tran_type',
                'tran_user',
                DB::raw('null as tran_bank'),
                'bill_amount',
                DB::raw('null as main_discount'),
                DB::raw('null as net_amount'),
                DB::raw('null as main_receive'),
                DB::raw('null as main_payment'),
                DB::raw('discount as due_discount'),
                DB::raw('receive as due_receive'),
                DB::raw('payment as due_payment'),
                'due',
                'tran_date',
                DB::raw('2 as source')
            )
            ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
        )
        ->orderBy('tran_id')
        ->orderBy('tran_date')
        ->paginate(15);
        
        return response()->json([
            'status'=> true,
            'data' => $transactions,
        ], 200);
    } // End Method



    // Search Salary Details Report
    public function Search(Request $req){
        $transactions = Transaction_Main::on('mysql_second')
        ->with('User', 'Bank', 'Withs', 'Type')
        ->whereNotIn('tran_type',['2','4'])
        ->select(
            'tran_id',
            'tran_method',
            'tran_type',
            'tran_user',
            'tran_bank',
            'bill_amount',
            'discount as main_discount',
            'net_amount',
            'receive as main_receive',
            'payment as main_payment',
            DB::raw('null as due_discount'),
            DB::raw('null as due_receive'),
            DB::raw('null as due_payment'),
            'due',
            'tran_date',
            DB::raw('null as batch_id'),
            DB::raw('1 as source')
        )
        ->with('User')
        ->whereHas('User', function ($query) use ($req) {
            $query->where('user_name', 'like', '%'.$req->search.'%');
        })
        ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
        ->where('tran_method', 'like', '%'.$req->method.'%')
        ->union(
            Party_Payment_Receive::on('mysql_second')
            ->select(
                'batch_id as tran_id',
                'tran_method',
                'tran_type',
                'tran_user',
                DB::raw('null as tran_bank'),
                'bill_amount',
                DB::raw('null as main_discount'),
                DB::raw('null as net_amount'),
                DB::raw('null as main_receive'),
                DB::raw('null as main_payment'),
                DB::raw('discount as due_discount'),
                DB::raw('receive as due_receive'),
                DB::raw('payment as due_payment'),
                'due',
                'tran_date',
                'tran_id as batch_id',
                DB::raw('2 as source')
            )
            ->with('User')
            ->whereHas('User', function ($query) use ($req) {
                $query->where('user_name', 'like', '%'.$req->search.'%');
            })
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method', 'like', '%'.$req->method.'%')
        )
        ->orderBy('tran_id')
        ->orderBy('tran_date')
        ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $transactions,
        ], 200);
    } // End Method



    // Print Party Details Report
    public function Print(Request $req){
        if ($req->query()) {
            $data = Transaction_Main::on('mysql_second')
            ->with('User', 'Bank', 'Withs', 'Type')
            ->whereNotIn('tran_type',['2','4'])
            ->select(
                'tran_id',
                'tran_method',
                'tran_type',
                'tran_user',
                'tran_bank',
                'bill_amount',
                'discount as main_discount',
                'net_amount',
                'receive as main_receive',
                'payment as main_payment',
                DB::raw('null as due_discount'),
                DB::raw('null as due_receive'),
                DB::raw('null as due_payment'),
                'due',
                'tran_date',
                DB::raw('null as batch_id'),
                DB::raw('1 as source')
            )
            ->with('User')
            ->whereHas('User', function ($query) use ($req) {
                $query->where('user_name', 'like', '%'.$req->search.'%');
            })
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_method', 'like', '%'.$req->method.'%')
            ->union(
                Party_Payment_Receive::on('mysql_second')
                ->select(
                    'batch_id as tran_id',
                    'tran_method',
                    'tran_type',
                    'tran_user',
                    DB::raw('null as tran_bank'),
                    'bill_amount',
                    DB::raw('null as main_discount'),
                    DB::raw('null as net_amount'),
                    DB::raw('null as main_receive'),
                    DB::raw('null as main_payment'),
                    DB::raw('discount as due_discount'),
                    DB::raw('receive as due_receive'),
                    DB::raw('payment as due_payment'),
                    'due',
                    'tran_date',
                    'tran_id as batch_id',
                    DB::raw('2 as source')
                )
                ->with('User')
                ->whereHas('User', function ($query) use ($req) {
                    $query->where('user_name', 'like', '%'.$req->search.'%');
                })
                ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
                ->where('tran_method', 'like', '%'.$req->method.'%')
            )
            ->orderBy('tran_id')
            ->orderBy('tran_date')
            ->get();
        }
        else {
            $data = Transaction_Main::on('mysql_second')
            ->with('User', 'Bank', 'Withs', 'Type')
            ->whereNotIn('tran_type',['2','4'])
            ->select(
                'tran_id',
                'tran_method',
                'tran_type',
                'tran_user',
                'tran_bank',
                'bill_amount',
                'discount as main_discount',
                'net_amount',
                'receive as main_receive',
                'payment as main_payment',
                DB::raw('null as due_discount'),
                DB::raw('null as due_receive'),
                DB::raw('null as due_payment'),
                'due',
                'tran_date',
                DB::raw('1 as source')
            )
            ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
            ->union(
                Party_Payment_Receive::on('mysql_second')
                ->select(
                    'batch_id as tran_id',
                    'tran_method',
                    'tran_type',
                    'tran_user',
                    DB::raw('null as tran_bank'),
                    'bill_amount',
                    DB::raw('null as main_discount'),
                    DB::raw('null as net_amount'),
                    DB::raw('null as main_receive'),
                    DB::raw('null as main_payment'),
                    DB::raw('discount as due_discount'),
                    DB::raw('receive as due_receive'),
                    DB::raw('payment as due_payment'),
                    'due',
                    'tran_date',
                    DB::raw('2 as source')
                )
                ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
            )
            ->orderBy('tran_id')
            ->orderBy('tran_date')
            ->get();
        }
        
        $report_name = 'Party Details Report';
        $start_date = $req->startDate ? $req->startDate : date('d/m/Y');
        $end_date = $req->endDate ? $req->endDate : date('d/m/Y');
        $pdf = Pdf::loadView('reports.party_statement.party_details.print', compact('report_name', 'start_date', 'end_date', 'data'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    } // End Method
}
