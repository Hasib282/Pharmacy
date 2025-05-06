<?php

namespace App\Http\Controllers\API\Backend\Reports\Account_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Transaction_Detail;
use App\Models\Transaction_Main_Head;
use App\Models\Transaction_Head;
use App\Models\Transaction_Groupe;

class AccountSummaryController extends Controller
{
    // Create a Common Function for Getting Data Easily
    public function GetAccountSummaryStatement($tranType) {
        return Transaction_Detail::on('mysql_second')
        ->with('Groupe', 'Head')
        ->select(
            'tran_date', 
            'tran_head_id', 
            'tran_groupe_id', 
            DB::raw('SUM(receive) as total_receive'), 
            DB::raw('SUM(payment) as total_payment')
        )
        ->where('tran_type', $tranType)
        ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
        ->orderBy('tran_date', 'asc')
        ->groupBy('tran_head_id','tran_groupe_id','tran_date')
        ->get();
    } // End Method




    // Show All Salary Details Report
    public function Show(Request $req){
        $general = $this->GetAccountSummaryStatement(1);
        $party = $this->GetAccountSummaryStatement(2);
        $payroll = $this->GetAccountSummaryStatement(3);
        $bank = $this->GetAccountSummaryStatement(4);
        $inventory = $this->GetAccountSummaryStatement(5);
        $pharmacy = $this->GetAccountSummaryStatement(6);
        $michellaneous = $this->GetAccountSummaryStatement(7);
        
        $opening = Transaction_Detail::on('mysql_second')
        ->select(
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
            'Michellaneous'     =>      $michellaneous,
        ];
        
        return response()->json([
            'status'=> true,
            'data' => $data,
            'type' => $type,
        ], 200);
    } // End Method



    // Create a Common Function for Getting Data Easily
    public function FindAccountSummaryStatement($tranType, $req) {
        // if($req->searchOption == 1){
        //     $groupes = Transaction_Groupe::on('mysql')
        //     ->where('tran_groupe_name', 'like', '%'.$req->search.'%')
        //     ->orderBy('tran_groupe_name','asc')
        //     ->pluck('id');

            
        // }
        // else if($req->searchOption == 2){
        //     $heads = Transaction_Head::on('mysql')
        //     ->where('tran_head_name', 'like', $req->search.'%')
        //     ->orderBy('tran_head_name','asc')
        //     ->pluck('id'); // Base query

        //     return Transaction_Detail::on('mysql_second')->with('Groupe', 'Head')
        //     // ->whereHas('Head', function ($query) use ($req) {
        //     //     $query->where('tran_head_name', 'like', '%'.$req->search.'%');
        //     //     $query->orderBy('tran_head_name','asc');
        //     // })
        //     ->whereIn('tran_head_id', $heads)
        //     ->select(
        //         'tran_date', 
        //         'tran_head_id', 
        //         'tran_groupe_id', 
        //         DB::raw('SUM(receive) as total_receive'), 
        //         DB::raw('SUM(payment) as total_payment')
        //     )
        //     ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
        //     ->where('tran_type', $tranType)
        //     ->orderBy('tran_date', 'asc')
        //     ->groupBy('tran_head_id','tran_groupe_id', 'tran_date')
        //     ->get();
        // }

        return Transaction_Detail::on('mysql_second')
        ->with('Groupe', 'Head')
        ->select(
            'tran_date', 
            'tran_head_id', 
            'tran_groupe_id', 
            DB::raw('SUM(receive) as total_receive'), 
            DB::raw('SUM(payment) as total_payment')
        )
        ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
        ->where('tran_type', $tranType)
        ->orderBy('tran_date', 'asc')
        ->groupBy('tran_head_id','tran_groupe_id','tran_date')
        ->get();
        
    } // End Method



    // Search Salary Details Report
    public function Search(Request $req){
        $opening = Transaction_Detail::on('mysql_second')->select(
            DB::raw('SUM(receive) as total_receive'), 
            DB::raw('SUM(payment) as total_payment')
        )
        ->whereRaw("DATE(tran_date) < ?", [$req->startDate])
        ->first();


        $data = [
            'opening' => $opening,
        ];

        switch ($req->type) {
            case 1:
                $data['General'] = $this->FindAccountSummaryStatement(1, $req);
                break;
            case 2:
                $data['Party'] = $this->FindAccountSummaryStatement(2, $req);
                break;
            case 3:
                $data['Payroll'] = $this->FindAccountSummaryStatement(3, $req);
                break;
            case 4:
                $data['Bank'] = $this->FindAccountSummaryStatement(4, $req);
                break;
            case 5:
                $data['Inventory'] = $this->FindAccountSummaryStatement(5, $req);
                break;
            case 6:
                $data['Pharmacy'] = $this->FindAccountSummaryStatement(6, $req);
                break;
            case 7:
                $data['Michellaneous'] = $this->FindAccountSummaryStatement(7, $req);
                break;
            default:
                $data['General'] = $this->FindAccountSummaryStatement(1, $req);
                $data['Party'] = $this->FindAccountSummaryStatement(2, $req);
                $data['Payroll'] = $this->FindAccountSummaryStatement(3, $req);
                $data['Bank'] = $this->FindAccountSummaryStatement(4, $req);
                $data['Inventory'] = $this->FindAccountSummaryStatement(5, $req);
                $data['Pharmacy'] = $this->FindAccountSummaryStatement(6, $req);
                $data['Michellaneous'] = $this->FindAccountSummaryStatement(7, $req);
        }
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Print Account Summary Report
    public function Print(Request $req){
        if ($req->query()) {
            $opening = Transaction_Detail::on('mysql_second')->select(
                DB::raw('SUM(receive) as total_receive'), 
                DB::raw('SUM(payment) as total_payment')
            )
            ->whereRaw("DATE(tran_date) < ?", [$req->startDate])
            ->first();
    
    
            $data = [
                'opening' => $opening,
            ];
    
            switch ($req->type) {
                case 1:
                    $data['General'] = $this->FindAccountSummaryStatement(1, $req);
                    break;
                case 2:
                    $data['Party'] = $this->FindAccountSummaryStatement(2, $req);
                    break;
                case 3:
                    $data['Payroll'] = $this->FindAccountSummaryStatement(3, $req);
                    break;
                case 4:
                    $data['Bank'] = $this->FindAccountSummaryStatement(4, $req);
                    break;
                case 5:
                    $data['Inventory'] = $this->FindAccountSummaryStatement(5, $req);
                    break;
                case 6:
                    $data['Pharmacy'] = $this->FindAccountSummaryStatement(6, $req);
                    break;
                case 7:
                    $data['Michellaneous'] = $this->FindAccountSummaryStatement(7, $req);
                    break;
                default:
                    $data['General'] = $this->FindAccountSummaryStatement(1, $req);
                    $data['Party'] = $this->FindAccountSummaryStatement(2, $req);
                    $data['Payroll'] = $this->FindAccountSummaryStatement(3, $req);
                    $data['Bank'] = $this->FindAccountSummaryStatement(4, $req);
                    $data['Inventory'] = $this->FindAccountSummaryStatement(5, $req);
                    $data['Pharmacy'] = $this->FindAccountSummaryStatement(6, $req);
                    $data['Michellaneous'] = $this->FindAccountSummaryStatement(7, $req);
            }
        }
        else {
            $general = $this->GetAccountSummaryStatement(1);
            $party = $this->GetAccountSummaryStatement(2);
            $payroll = $this->GetAccountSummaryStatement(3);
            $bank = $this->GetAccountSummaryStatement(4);
            $inventory = $this->GetAccountSummaryStatement(5);
            $pharmacy = $this->GetAccountSummaryStatement(6);
            $michellaneous = $this->GetAccountSummaryStatement(7);
            
            $opening = Transaction_Detail::on('mysql_second')
            ->select(
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
                'Michellaneous'     =>      $michellaneous,
            ];
        }
        
        $report_name = 'Account Summary Report';
        $start_date = $req->startDate ? $req->startDate : date('d/m/Y');
        $end_date = $req->endDate ? $req->endDate : date('d/m/Y');
        $pdf = Pdf::loadView('reports.account_statement.summary.print', compact('report_name', 'start_date', 'end_date', 'data'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    } // End Method
}
