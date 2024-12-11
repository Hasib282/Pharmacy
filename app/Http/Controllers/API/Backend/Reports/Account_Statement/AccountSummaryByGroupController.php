<?php

namespace App\Http\Controllers\API\Backend\Reports\Account_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Transaction_Detail;
use App\Models\Transaction_Main_Head;

class AccountSummaryByGroupController extends Controller
{
    // Create a Common Function for Getting Data Easily
    public function GetAccountSummaryGroupeStatement($tranType) {
        return Transaction_Detail::on('mysql')->select(
                'tran_groupe_id', 
                DB::raw('SUM(receive) as total_receive'), 
                DB::raw('SUM(payment) as total_payment')
            )
            ->where('tran_type', $tranType)
            ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
            ->orderBy('tran_groupe_id', 'asc')
            ->groupBy('tran_groupe_id')
            ->get();
    } // End Method



    // Show All Salary Details Report
    public function ShowAll(Request $req){
        $general = $this->GetAccountSummaryGroupeStatement(1);
        $party = $this->GetAccountSummaryGroupeStatement(2);
        $payroll = $this->GetAccountSummaryGroupeStatement(3);
        $bank = $this->GetAccountSummaryGroupeStatement(4);
        $inventory = $this->GetAccountSummaryGroupeStatement(5);
        $pharmacy = $this->GetAccountSummaryGroupeStatement(6);
        $michellaneous = $this->GetAccountSummaryGroupeStatement(7);

        $opening = Transaction_Detail::on('mysql')->select(
            DB::raw('SUM(receive) as total_receive'), 
            DB::raw('SUM(payment) as total_payment')
        )
        ->whereRaw("DATE(tran_date) < ?", [date('Y-m-d')])
        ->first();

        $type = Transaction_Main_Head::on('mysql_second')->get();

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
    public function FindAccountSummaryGroupeStatement($tranType, $req) {
        return Transaction_Detail::on('mysql')->with('Groupe')
        ->whereHas('Groupe', function ($query) use ($req) {
            $query->where('tran_groupe_name', 'like', '%'.$req->search.'%');
            $query->orderBy('tran_groupe_name','asc');
        })
        ->select(
            'tran_groupe_id', 
            DB::raw('SUM(receive) as total_receive'), 
            DB::raw('SUM(payment) as total_payment')
        )
        ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
        ->where('tran_type', $tranType)
        ->orderBy('tran_groupe_id', 'asc')
        ->groupBy('tran_groupe_id')
        ->get();
    } // End Method



    // Search Salary Details Report
    public function Search(Request $req){
        $opening = Transaction_Detail::on('mysql')->select(
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
                $data['general'] = $this->FindAccountSummaryGroupeStatement(1, $req);
                break;
            case 2:
                $data['party'] = $this->FindAccountSummaryGroupeStatement(2, $req);
                break;
            case 3:
                $data['payroll'] = $this->FindAccountSummaryGroupeStatement(3, $req);
                break;
            case 4:
                $data['bank'] = $this->FindAccountSummaryGroupeStatement(4, $req);
                break;
            case 5:
                $data['inventory'] = $this->FindAccountSummaryGroupeStatement(5, $req);
                break;
            case 6:
                $data['pharmacy'] = $this->FindAccountSummaryGroupeStatement(6, $req);
                break;
            case 7:
                $data['michellaneous'] = $this->FindAccountSummaryGroupeStatement(7, $req);
                break;
            default:
                $data['general'] = $this->FindAccountSummaryGroupeStatement(1, $req);
                $data['party'] = $this->FindAccountSummaryGroupeStatement(2, $req);
                $data['payroll'] = $this->FindAccountSummaryGroupeStatement(3, $req);
                $data['bank'] = $this->FindAccountSummaryGroupeStatement(4, $req);
                $data['inventory'] = $this->FindAccountSummaryGroupeStatement(5, $req);
                $data['pharmacy'] = $this->FindAccountSummaryGroupeStatement(6, $req);
                $data['michellaneous'] = $this->FindAccountSummaryGroupeStatement(7, $req);
        }
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method
}
