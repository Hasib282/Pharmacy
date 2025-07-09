<?php

namespace App\Http\Controllers\API\Backend\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Transaction_Detail;
use App\Models\Transaction_Groupe;

class ItemFlowStatementController extends Controller
{
    // Show All Item Flow Statement
    public function Show(Request $req){
        $type = GetTranType($req->segment(2));

        $groupes = Transaction_Groupe::on('mysql_second')->where('tran_groupe_type', '$type')->orderBy('added_at','asc')->get();
        return response()->json([
            'status'=> true,
            'data' => [],
            'groupes' => $groupes,
        ], 200);
    } // End Method




    function getBalance($tranMethod, $startDate, $searchId, $type) {
        return Transaction_Detail::on('mysql_second')->with('Head')
            ->where('tran_type', $type)
            ->where('tran_method', $tranMethod)
            ->where('tran_date', '<', $startDate)
            ->where('tran_head_id', $searchId)
            ->sum('quantity_actual');
    }



    // Search Item Flow Statement
    public function Search(Request $req){
        $type = GetTranType($req->segment(2));

        $openingPurchaseBalance = 0;
        $openingIssueBalance = 0;
        $openingPurchaseReturnToSupplierBalance = 0;
        $openingClientReturnBalance = 0;
        $openingPositiveBalance = 0;
        $openingNegativeBalance = 0;
        $openingBalance = 0;
        

        
        $startDate = $req->startDate;
        $endDate = $req->endDate;
        $searchId = $req->search_id;
        
        $openingPurchaseBalance = $this->getBalance('Purchase', $startDate, $searchId, $type);
        $openingIssueBalance = $this->getBalance('Issue', $startDate, $searchId, $type);
        $openingPurchaseReturnToSupplierBalance = $this->getBalance('Supplier Return', $startDate, $searchId, $type);
        $openingClientReturnBalance = $this->getBalance('Client Return', $startDate, $searchId, $type);
        $openingPositiveBalance = $this->getBalance('Positive', $startDate, $searchId, $type);
        $openingNegativeBalance = $this->getBalance('Negative', $startDate, $searchId, $type);
        
        $openingBalance = $openingPurchaseBalance 
                        - $openingIssueBalance 
                        - $openingPurchaseReturnToSupplierBalance 
                        + $openingClientReturnBalance 
                        + $openingPositiveBalance 
                        - $openingNegativeBalance;
        
        if($req->search_id == ""){
            $data = [];
        }
        else{
            $data = Transaction_Detail::on('mysql_second')->with('Head')
            ->where('tran_type', $type)
            ->whereRaw("tran_date BETWEEN ? AND ?", [$req->startDate, $req->endDate . ' 23:59:59'])
            ->where('tran_head_id', $req->search_id)
            ->get();
        }
        
        return response()->json([
            'status' => true,
            'data' => $data,
            'openingBalance' => $openingBalance,
        ], 200);
    } // End Method



    // Print Item Flow Report
    public function Print(Request $req){
        $type = GetTranType($req->segment(2));

        if ($req->query()) {
            $openingPurchaseBalance = 0;
            $openingIssueBalance = 0;
            $openingPurchaseReturnToSupplierBalance = 0;
            $openingClientReturnBalance = 0;
            $openingPositiveBalance = 0;
            $openingNegativeBalance = 0;
            $openingBalance = 0;

            
            $startDate = $req->startDate;
            $endDate = $req->endDate;
            $searchId = $req->search_id;
            
            $openingPurchaseBalance = $this->getBalance('Purchase', $startDate, $searchId, $type);
            $openingIssueBalance = $this->getBalance('Issue', $startDate, $searchId, $type);
            $openingPurchaseReturnToSupplierBalance = $this->getBalance('Supplier Return', $startDate, $searchId, $type);
            $openingClientReturnBalance = $this->getBalance('Client Return', $startDate, $searchId, $type);
            $openingPositiveBalance = $this->getBalance('Positive', $startDate, $searchId, $type);
            $openingNegativeBalance = $this->getBalance('Negative', $startDate, $searchId, $type);
            
            $openingBalance = $openingPurchaseBalance 
                            - $openingIssueBalance 
                            - $openingPurchaseReturnToSupplierBalance 
                            + $openingClientReturnBalance 
                            + $openingPositiveBalance 
                            - $openingNegativeBalance;
            
            if($req->search_id == ""){
                $data = [];
            }
            else{
                $data = Transaction_Detail::on('mysql_second')->with('Head')
                ->where('tran_type', $type)
                ->whereRaw("tran_date BETWEEN ? AND ?", [$req->startDate, $req->endDate . ' 23:59:59'])
                ->where('tran_head_id', $req->search_id)
                ->get();
            }
        }
        else {
            $data = [];
            $openingBalance = 0;
        }
        
        $report_name = 'Item Flow Report';
        $start_date = $req->startDate ? $req->startDate : date('d/m/Y');
        $end_date = $req->endDate ? $req->endDate : date('d/m/Y');
        $pdf = Pdf::loadView('reports.product_reports.item_flow_statement.print', compact('report_name', 'start_date', 'end_date', 'data', 'openingBalance'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    } // End Method
}
