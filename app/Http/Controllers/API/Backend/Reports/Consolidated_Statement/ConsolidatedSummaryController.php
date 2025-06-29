<?php

namespace App\Http\Controllers\API\Backend\Reports\Consolidated_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConsolidatedSummaryController extends Controller
{
    // Create a Common Function for Getting Data Easily
    public function GetAccountDetailsStatement($tranType) {
        return Transaction_Detail::on('mysql_second')
            ->with('Groupe', 'Head','User','Bank')
            ->whereDate('tran_date', date('Y-m-d'))
            ->where(function ($query) {
                $query->where('receive', '>', 0)
                      ->orWhere('payment', '>', 0);
            })
            ->where('tran_type', $tranType)
            ->orderBy('tran_id', 'asc')
            ->get();
    } // End Method


    
    // Show All Salary Details Report
    public function Show(Request $req){
        $general = $this->GetAccountDetailsStatement(1);
        $party = $this->GetAccountDetailsStatement(2);
        $payroll = $this->GetAccountDetailsStatement(3);
        $bank = $this->GetAccountDetailsStatement(4);
        $inventory = $this->GetAccountDetailsStatement(5);
        $pharmacy = $this->GetAccountDetailsStatement(6);
        $hospital = $this->GetAccountDetailsStatement(7);
        $hotel = $this->GetAccountDetailsStatement(8);
        
        $opening = Transaction_Detail::on('mysql_second')->select(
            DB::raw('SUM(receive) as total_receive'), 
            DB::raw('SUM(payment) as total_payment')
        )
        ->whereRaw("DATE(tran_date) < ?", [date('Y-m-d')])
        ->first();

        $type = Transaction_Main_Head::on('mysql')->get();
        
        $data = [       
            'opening'           =>      $opening,
            'General'           =>      $general,
            'Party'             =>      $party,
            'Payroll'           =>      $payroll,
            'Bank'              =>      $bank,
            'Inventory'         =>      $inventory,
            'Pharmacy'          =>      $pharmacy,
            'Hospital'          =>      $hospital,
            'Hotel'             =>      $hotel,
        ];
        
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method
}
