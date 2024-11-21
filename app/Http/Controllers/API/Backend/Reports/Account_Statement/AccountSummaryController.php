<?php

namespace App\Http\Controllers\API\Backend\Reports\Account_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Transaction_Detail;
use App\Models\Transaction_Main_Head;

class AccountSummaryController extends Controller
{
    // Create a Common Function for Getting Data Easily
    public function GetAccountSummaryStatement($tranType) {
        return Transaction_Detail::select(
                'tran_head_id', 
                'tran_groupe_id', 
                DB::raw('SUM(receive) as total_receive'), 
                DB::raw('SUM(payment) as total_payment')
            )
            ->where('tran_type', $tranType)
            ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
            ->orderBy('tran_groupe_id', 'asc')
            ->groupBy('tran_head_id','tran_groupe_id')
            ->get();
    } // End Method




    // Show All Salary Details Report
    public function ShowAll(Request $req){
        $general = $this->GetAccountSummaryStatement(1);
        $party = $this->GetAccountSummaryStatement(2);
        $payroll = $this->GetAccountSummaryStatement(3);
        $bank = $this->GetAccountSummaryStatement(4);
        $inventory = $this->GetAccountSummaryStatement(5);
        $pharmacy = $this->GetAccountSummaryStatement(6);
        $michellaneous = $this->GetAccountSummaryStatement(7);
        
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
    public function FindAccountSummaryStatement($tranType, $req) {
        if($req->searchOption == 1){
            return Transaction_Detail::with('Groupe')
            ->whereHas('Groupe', function ($query) use ($req) {
                $query->where('tran_groupe_name', 'like', '%'.$req->search.'%');
                $query->orderBy('tran_groupe_name','asc');
            })
            ->select(
                'tran_head_id', 
                'tran_groupe_id', 
                DB::raw('SUM(receive) as total_receive'), 
                DB::raw('SUM(payment) as total_payment')
            )
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_type', $tranType)
            ->orderBy('tran_groupe_id', 'asc')
            ->groupBy('tran_head_id','tran_groupe_id')
            ->get();
        }
        else if($req->searchOption == 2){
            return Transaction_Detail::with('Head')
            ->whereHas('Head', function ($query) use ($req) {
                $query->where('tran_head_name', 'like', '%'.$req->search.'%');
                $query->orderBy('tran_head_name','asc');
            })
            ->select(
                'tran_head_id', 
                'tran_groupe_id', 
                DB::raw('SUM(receive) as total_receive'), 
                DB::raw('SUM(payment) as total_payment')
            )
            ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
            ->where('tran_type', $tranType)
            ->orderBy('tran_groupe_id', 'asc')
            ->groupBy('tran_head_id','tran_groupe_id')
            ->get();
        }
        
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
                $data['general'] = $this->FindAccountSummaryStatement(1, $req);
                break;
            case 2:
                $data['party'] = $this->FindAccountSummaryStatement(2, $req);
                break;
            case 3:
                $data['payroll'] = $this->FindAccountSummaryStatement(3, $req);
                break;
            case 4:
                $data['bank'] = $this->FindAccountSummaryStatement(4, $req);
                break;
            case 5:
                $data['inventory'] = $this->FindAccountSummaryStatement(5, $req);
                break;
            case 6:
                $data['pharmacy'] = $this->FindAccountSummaryStatement(6, $req);
                break;
            case 7:
                $data['michellaneous'] = $this->FindAccountSummaryStatement(7, $req);
                break;
            default:
                $data['general'] = $this->FindAccountSummaryStatement(1, $req);
                $data['party'] = $this->FindAccountSummaryStatement(2, $req);
                $data['payroll'] = $this->FindAccountSummaryStatement(3, $req);
                $data['bank'] = $this->FindAccountSummaryStatement(4, $req);
                $data['inventory'] = $this->FindAccountSummaryStatement(5, $req);
                $data['pharmacy'] = $this->FindAccountSummaryStatement(6, $req);
                $data['michellaneous'] = $this->FindAccountSummaryStatement(7, $req);
        }
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method
}
