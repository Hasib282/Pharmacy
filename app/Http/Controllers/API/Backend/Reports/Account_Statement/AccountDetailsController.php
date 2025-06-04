<?php

namespace App\Http\Controllers\API\Backend\Reports\Account_Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Transaction_Detail;
use App\Models\Transaction_Main_Head;

class AccountDetailsController extends Controller
{
    // Create a Common Function for Getting Data Easily
    public function GetAccountDetailsStatement($tranType) {
        return Transaction_Detail::on('mysql_second')
            ->with('Groupe', 'Head')
            ->where('tran_type', $tranType)
            ->whereRaw("DATE(tran_date) = ?", [date('Y-m-d')])
            ->orderBy('tran_date', 'asc')
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
            'type' => $type,
        ], 200);
    } // End Method



    // Create a Common Function for Getting Data Easily
    public function FindAccountDetailsStatement($tranType, $req) {
        return Transaction_Detail::on('mysql_second')
        ->with('Groupe', 'Head')
        ->whereRaw("DATE(tran_date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])
        ->where('tran_type', $tranType)
        ->orderBy('tran_date', 'asc')
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
                $data['General'] = $this->FindAccountDetailsStatement(1, $req);
                break;
            case 2:
                $data['Party'] = $this->FindAccountDetailsStatement(2, $req);
                break;
            case 3:
                $data['Payroll'] = $this->FindAccountDetailsStatement(3, $req);
                break;
            case 4:
                $data['Bank'] = $this->FindAccountDetailsStatement(4, $req);
                break;
            case 5:
                $data['Inventory'] = $this->FindAccountDetailsStatement(5, $req);
                break;
            case 6:
                $data['Pharmacy'] = $this->FindAccountDetailsStatement(6, $req);
                break;
            case 7:
                $data['Hospital'] = $this->FindAccountDetailsStatement(7, $req);
                break;
            case 8:
                $data['Hotel'] = $this->FindAccountDetailsStatement(8, $req);
                break;
            default:
                $data['General'] = $this->FindAccountDetailsStatement(1, $req);
                $data['Party'] = $this->FindAccountDetailsStatement(2, $req);
                $data['Payroll'] = $this->FindAccountDetailsStatement(3, $req);
                $data['Bank'] = $this->FindAccountDetailsStatement(4, $req);
                $data['Inventory'] = $this->FindAccountDetailsStatement(5, $req);
                $data['Pharmacy'] = $this->FindAccountDetailsStatement(6, $req);
                $data['Hospital'] = $this->FindAccountDetailsStatement(7, $req);
                $data['Hotel'] = $this->FindAccountDetailsStatement(8, $req);
        }
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Print Account Details Report
    public function Print(Request $req){
        if ($req->query()) {
            $opening = Transaction_Detail::on('mysql_second')->select(
                DB::raw('SUM(receive) as total_receive'), 
                DB::raw('SUM(payment) as total_payment')
            )
            ->whereRaw("DATE(tran_date) < ?", [$req->startDate])
            ->first();
    
    
            $data = [
                'Opening' => $opening,
            ];
    
            switch ($req->type) {
                case 1:
                    $data['General'] = $this->FindAccountDetailsStatement(1, $req);
                    break;
                case 2:
                    $data['Party'] = $this->FindAccountDetailsStatement(2, $req);
                    break;
                case 3:
                    $data['Payroll'] = $this->FindAccountDetailsStatement(3, $req);
                    break;
                case 4:
                    $data['Bank'] = $this->FindAccountDetailsStatement(4, $req);
                    break;
                case 5:
                    $data['Inventory'] = $this->FindAccountDetailsStatement(5, $req);
                    break;
                case 6:
                    $data['Pharmacy'] = $this->FindAccountDetailsStatement(6, $req);
                    break;
                case 7:
                    $data['Hospital'] = $this->FindAccountDetailsStatement(7, $req);
                    break;
                case 8:
                    $data['Hotel'] = $this->FindAccountDetailsStatement(8, $req);
                    break;
                default:
                    $data['General'] = $this->FindAccountDetailsStatement(1, $req);
                    $data['Party'] = $this->FindAccountDetailsStatement(2, $req);
                    $data['Payroll'] = $this->FindAccountDetailsStatement(3, $req);
                    $data['Bank'] = $this->FindAccountDetailsStatement(4, $req);
                    $data['Inventory'] = $this->FindAccountDetailsStatement(5, $req);
                    $data['Pharmacy'] = $this->FindAccountDetailsStatement(6, $req);
                    $data['Hospital'] = $this->FindAccountDetailsStatement(7, $req);
                    $data['Hotel'] = $this->FindAccountDetailsStatement(8, $req);
            }
        }
        else {
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
                'Opening'           =>      $opening,
                'General'           =>      $general,
                'Party'             =>      $party,
                'Payroll'           =>      $payroll,
                'Bank'              =>      $bank,
                'Inventory'         =>      $inventory,
                'Pharmacy'          =>      $pharmacy,
                'Hospital'          =>      $hospital,
                'Hotel'             =>      $hotel,
            ];
        }
        
        $report_name = 'Account Details Report';
        $start_date = $req->startDate ? $req->startDate : date('d/m/Y');
        $end_date = $req->endDate ? $req->endDate : date('d/m/Y');
        $pdf = Pdf::loadView('reports.account_statement.details.print', compact('report_name', 'start_date', 'end_date', 'data'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    } // End Method
}
