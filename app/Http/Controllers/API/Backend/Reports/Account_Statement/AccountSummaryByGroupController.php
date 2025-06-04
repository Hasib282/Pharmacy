<?php

namespace App\Http\Controllers\API\Backend\Reports\Account_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Transaction_Detail;
use App\Models\Transaction_Main_Head;
use App\Models\Transaction_Groupe;

class AccountSummaryByGroupController extends Controller
{
    // Create a Common Function for Getting Data Easily
    public function GetAccountSummaryGroupeStatement($tranType) {
        return Transaction_Detail::on('mysql_second')
            ->with('Groupe')
            ->select(
                'tran_date', 
                'tran_groupe_id', 
                DB::raw('SUM(receive) as total_receive'), 
                DB::raw('SUM(payment) as total_payment')
            )
            ->where('tran_type', $tranType)
            ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
            ->orderBy('tran_date', 'asc')
            ->groupBy('tran_groupe_id', 'tran_date')
            ->get();
    } // End Method



    // Show All Salary Details Report
    public function Show(Request $req){
        $general = $this->GetAccountSummaryGroupeStatement(1);
        $party = $this->GetAccountSummaryGroupeStatement(2);
        $payroll = $this->GetAccountSummaryGroupeStatement(3);
        $bank = $this->GetAccountSummaryGroupeStatement(4);
        $inventory = $this->GetAccountSummaryGroupeStatement(5);
        $pharmacy = $this->GetAccountSummaryGroupeStatement(6);
        $hospital = $this->GetAccountSummaryGroupeStatement(7);
        $hotel = $this->GetAccountSummaryGroupeStatement(8);

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
            'type' => $type,
        ], 200);
    } // End Method



    // Create a Common Function for Getting Data Easily
    public function FindAccountSummaryGroupeStatement($tranType, $req) {
        // $groupes = Transaction_Groupe::on('mysql')
        //     ->where('tran_groupe_name', 'like', $req->search.'%')
        //     ->orderBy('tran_groupe_name','asc')
        //     ->pluck('id');

        return Transaction_Detail::on('mysql_second')
        ->with('Groupe')
        ->select(
            'tran_date', 
            'tran_groupe_id', 
            DB::raw('SUM(receive) as total_receive'), 
            DB::raw('SUM(payment) as total_payment')
        )
        // ->whereIn('tran_groupe_id', $groupes)
        ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
        ->where('tran_type', $tranType)
        ->orderBy('tran_date', 'asc')
        ->groupBy('tran_groupe_id', 'tran_date')
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
                $data['General'] = $this->FindAccountSummaryGroupeStatement(1, $req);
                break;
            case 2:
                $data['Party'] = $this->FindAccountSummaryGroupeStatement(2, $req);
                break;
            case 3:
                $data['Payroll'] = $this->FindAccountSummaryGroupeStatement(3, $req);
                break;
            case 4:
                $data['Bank'] = $this->FindAccountSummaryGroupeStatement(4, $req);
                break;
            case 5:
                $data['Inventory'] = $this->FindAccountSummaryGroupeStatement(5, $req);
                break;
            case 6:
                $data['Pharmacy'] = $this->FindAccountSummaryGroupeStatement(6, $req);
                break;
            case 7:
                $data['Hospital'] = $this->FindAccountSummaryGroupeStatement(7, $req);
                break;
            case 8:
                $data['Hotel'] = $this->FindAccountSummaryGroupeStatement(8, $req);
                break;
            default:
                $data['General'] = $this->FindAccountSummaryGroupeStatement(1, $req);
                $data['Party'] = $this->FindAccountSummaryGroupeStatement(2, $req);
                $data['Payroll'] = $this->FindAccountSummaryGroupeStatement(3, $req);
                $data['Bank'] = $this->FindAccountSummaryGroupeStatement(4, $req);
                $data['Inventory'] = $this->FindAccountSummaryGroupeStatement(5, $req);
                $data['Pharmacy'] = $this->FindAccountSummaryGroupeStatement(6, $req);
                $data['Hospital'] = $this->FindAccountSummaryGroupeStatement(7, $req);
                $data['Hotel'] = $this->FindAccountSummaryGroupeStatement(8, $req);
        }
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Print Account Summary By Group Report
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
        }
        else {
            $general = $this->GetAccountSummaryGroupeStatement(1);
            $party = $this->GetAccountSummaryGroupeStatement(2);
            $payroll = $this->GetAccountSummaryGroupeStatement(3);
            $bank = $this->GetAccountSummaryGroupeStatement(4);
            $inventory = $this->GetAccountSummaryGroupeStatement(5);
            $pharmacy = $this->GetAccountSummaryGroupeStatement(6);
            $michellaneous = $this->GetAccountSummaryGroupeStatement(7);

            $opening = Transaction_Detail::on('mysql_second')->select(
                DB::raw('SUM(receive) as total_receive'), 
                DB::raw('SUM(payment) as total_payment')
            )
            ->whereRaw("DATE(tran_date) < ?", [date('Y-m-d')])
            ->first();

            $type = Transaction_Main_Head::on('mysql')->get();

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
        }
        
        $report_name = 'Account Summary By Group Report';
        $start_date = $req->startDate ? $req->startDate : date('d/m/Y');
        $end_date = $req->endDate ? $req->endDate : date('d/m/Y');
        $pdf = Pdf::loadView('reports.account_statement.summary_groupe.print', compact('report_name', 'start_date', 'end_date', 'data'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    } // End Method
}
