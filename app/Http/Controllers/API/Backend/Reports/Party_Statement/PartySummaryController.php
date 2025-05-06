<?php

namespace App\Http\Controllers\API\Backend\Reports\Party_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Transaction_Main;

class PartySummaryController extends Controller
{
    // Show All Salary Details Report
    public function Show(Request $req){
        $data = Transaction_Main::on('mysql_second')
        ->with('User', 'Bank', 'Withs', 'Type')
        ->whereNotIn('tran_type',['2','4'])
        ->select(
            'tran_type',
            'tran_method',
            'tran_type_with',
            'tran_user',
            'tran_bank',
            DB::raw('SUM(bill_amount) as total_bill_amount'),
            DB::raw('SUM(discount) as total_discount'),
            DB::raw('SUM(net_amount) as total_net_amount'),
            DB::raw('SUM(receive) as total_receive'),
            DB::raw('SUM(payment) as total_payment'),
            DB::raw('SUM(due) as total_due'),
            DB::raw('SUM(due_disc) as total_due_disc'),
            DB::raw('SUM(due_col) as total_due_col')
        )
        ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
        ->groupBy('tran_type', 'tran_method', 'tran_type_with', 'tran_user', 'tran_bank')
        ->orderBy('tran_id','asc')
        ->get();
        
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Search Salary Details Report
    public function Search(Request $req){
        $data = Transaction_Main::on('mysql_second')
        ->with('User', 'Bank', 'Withs', 'Type')
        ->whereNotIn('tran_type',['2','4'])
        ->select(
            'tran_type',
            'tran_method',
            'tran_type_with',
            'tran_user',
            'tran_bank',
            DB::raw('SUM(bill_amount) as total_bill_amount'),
            DB::raw('SUM(discount) as total_discount'),
            DB::raw('SUM(net_amount) as total_net_amount'),
            DB::raw('SUM(receive) as total_receive'),
            DB::raw('SUM(payment) as total_payment'),
            DB::raw('SUM(due) as total_due'),
            DB::raw('SUM(due_disc) as total_due_disc'),
            DB::raw('SUM(due_col) as total_due_col')
        )
        ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
        ->when($req->method !== null, function ($query) use ($req) {
            return $query->where('tran_method', $req->method);
        })
        ->groupBy('tran_type', 'tran_method', 'tran_type_with', 'tran_user', 'tran_bank')
        ->orderBy('tran_id','asc')
        ->get();
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Print Party Summary Report
    public function Print(Request $req){
        if ($req->query()) {
            $data = Transaction_Main::on('mysql_second')
            ->with('User', 'Bank', 'Withs', 'Type')
            ->whereHas($req->searchOption == 1 ? 'User' : 'Withs', function ($query) use ($req) {
                $query->where($req->searchOption == 1 ? 'user_name' : 'tran_with_name', 'like', $req->search.'%');
            })
            ->whereNotIn('tran_type',['2','4'])
            ->select(
                'tran_type',
                'tran_method',
                'tran_type_with',
                'tran_user',
                'tran_bank',
                DB::raw('SUM(bill_amount) as total_bill_amount'),
                DB::raw('SUM(discount) as total_discount'),
                DB::raw('SUM(net_amount) as total_net_amount'),
                DB::raw('SUM(receive) as total_receive'),
                DB::raw('SUM(payment) as total_payment'),
                DB::raw('SUM(due) as total_due'),
                DB::raw('SUM(due_disc) as total_due_disc'),
                DB::raw('SUM(due_col) as total_due_col')
            )
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->when($req->method !== null, function ($query) use ($req) {
                return $query->where('tran_method', $req->method);
            })
            ->groupBy('tran_type', 'tran_method', 'tran_type_with', 'tran_user', 'tran_bank')
            ->orderBy('tran_date','asc')
            ->get();
        }
        else {
            $data = Transaction_Main::on('mysql_second')
            ->with('User', 'Bank', 'Withs', 'Type')
            ->whereNotIn('tran_type',['2','4'])
            ->select(
                'tran_type',
                'tran_method',
                'tran_type_with',
                'tran_user',
                'tran_bank',
                DB::raw('SUM(bill_amount) as total_bill_amount'),
                DB::raw('SUM(discount) as total_discount'),
                DB::raw('SUM(net_amount) as total_net_amount'),
                DB::raw('SUM(receive) as total_receive'),
                DB::raw('SUM(payment) as total_payment'),
                DB::raw('SUM(due) as total_due'),
                DB::raw('SUM(due_disc) as total_due_disc'),
                DB::raw('SUM(due_col) as total_due_col')
            )
            ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
            ->groupBy('tran_type', 'tran_method', 'tran_type_with', 'tran_user', 'tran_bank')
            ->orderBy('tran_id','asc')
            ->get();
        }
        
        $report_name = 'Party Summary Report';
        $start_date = $req->startDate ? $req->startDate : date('d/m/Y');
        $end_date = $req->endDate ? $req->endDate : date('d/m/Y');
        $pdf = Pdf::loadView('reports.party_statement.party_summary.print', compact('report_name', 'start_date', 'end_date', 'data'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    } // End Method
}
