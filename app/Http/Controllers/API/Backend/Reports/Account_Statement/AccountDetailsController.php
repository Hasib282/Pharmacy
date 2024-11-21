<?php

namespace App\Http\Controllers\API\Backend\Reports\Account_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Transaction_Detail;
use App\Models\Transaction_Main_Head;

class AccountDetailsController extends Controller
{
    // Create a Common Function for Getting Data Easily
    public function GetAccountDetailsStatement($tranType) {
        return Transaction_Detail::where('tran_type', $tranType)
            ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
            ->orderBy('tran_id', 'asc')
            ->get();
    } // End Method


    
    // Show All Salary Details Report
    public function ShowAll(Request $req){
        $general = $this->GetAccountDetailsStatement(1);
        $party = $this->GetAccountDetailsStatement(2);
        $payroll = $this->GetAccountDetailsStatement(3);
        $bank = $this->GetAccountDetailsStatement(4);
        $inventory = $this->GetAccountDetailsStatement(5);
        $pharmacy = $this->GetAccountDetailsStatement(6);
        $michellaneous = $this->GetAccountDetailsStatement(7);
        
        $opening = Transaction_Detail::select(
            DB::raw('SUM(receive) as total_receive'), 
            DB::raw('SUM(payment) as total_payment')
        )
        ->whereRaw("DATE(tran_date) < ?", [date('Y-m-d')])
        ->first();

        $type = Transaction_Main_Head::get();
        
        $data = [       
            'opening'           =>      $opening,
            'general'           =>      $general,
            'party'             =>      $party,
            'payroll'           =>      $payroll,
            'bank'              =>      $bank,
            'inventory'         =>      $inventory,
            'pharmacy'          =>      $pharmacy,
            'michellaneous'     =>      $michellaneous,
        ];
        
        return response()->json([
            'status'=> true,
            'data' => $data,
            'type' => $type,
        ], 200);
    } // End Method



    // Create a Common Function for Getting Data Easily
    public function FindAccountDetailsStatement($tranType, $req) {
        return Transaction_Detail::whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
        ->where('tran_type', $tranType)
        ->orderBy('tran_id', 'asc')
        ->get();
    } // End Method



    // Search Salary Details Report
    public function Search(Request $req){
        $opening = Transaction_Detail::select(
            DB::raw('SUM(receive) as total_receive'), 
            DB::raw('SUM(payment) as total_payment')
        )
        ->whereRaw("DATE(tran_date) < ?", [$req->startDate])
        ->first();


        $data = [
            'opening' => $opening,
        ];

        switch ($req->typeOption) {
            case 1:
                $data['general'] = $this->FindAccountDetailsStatement(1, $req);
                break;
            case 2:
                $data['party'] = $this->FindAccountDetailsStatement(2, $req);
                break;
            case 3:
                $data['payroll'] = $this->FindAccountDetailsStatement(3, $req);
                break;
            case 4:
                $data['bank'] = $this->FindAccountDetailsStatement(4, $req);
                break;
            case 5:
                $data['inventory'] = $this->FindAccountDetailsStatement(5, $req);
                break;
            case 6:
                $data['pharmacy'] = $this->FindAccountDetailsStatement(6, $req);
                break;
            case 7:
                $data['michellaneous'] = $this->FindAccountDetailsStatement(7, $req);
                break;
            default:
                $data['general'] = $this->FindAccountDetailsStatement(1, $req);
                $data['party'] = $this->FindAccountDetailsStatement(2, $req);
                $data['payroll'] = $this->FindAccountDetailsStatement(3, $req);
                $data['bank'] = $this->FindAccountDetailsStatement(4, $req);
                $data['inventory'] = $this->FindAccountDetailsStatement(5, $req);
                $data['pharmacy'] = $this->FindAccountDetailsStatement(6, $req);
                $data['michellaneous'] = $this->FindAccountDetailsStatement(7, $req);
        }
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method
}
