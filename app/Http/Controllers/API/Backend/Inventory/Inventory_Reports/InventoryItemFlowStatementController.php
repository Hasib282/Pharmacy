<?php

namespace App\Http\Controllers\API\Backend\Inventory\Inventory_Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Transaction_Detail;
use App\Models\Transaction_Groupe;

class InventoryItemFlowStatementController extends Controller
{
    // Show All Inventory Item Flow Statement
    public function ShowAll(Request $req){
        $groupes = Transaction_Groupe::on('mysql')->where('tran_groupe_type', '5')->orderBy('added_at','asc')->get();
        return response()->json([
            'status'=> true,
            'data' => [],
            'groupes' => $groupes,
        ], 200);
    } // End Method



    // Search Inventory Item Flow Statement
    public function Search(Request $req){
        $openingPurchaseBalance = 0;
        $openingIssueBalance = 0;
        $openingPurchaseReturnToSupplierBalance = 0;
        $openingClientReturnBalance = 0;
        $openingPositiveBalance = 0;
        $openingNegativeBalance = 0;
        $openingBalance = 0;
        

        function getBalance($tranMethod, $startDate, $searchId) {
            return Transaction_Detail::on('mysql_second')->with('Head')
                ->where('tran_type', 5)
                ->where('tran_method', $tranMethod)
                ->where('tran_date', '<', $startDate)
                ->where('tran_head_id', $searchId)
                ->sum('quantity_actual');
        }

        
        $startDate = $req->startDate;
        $endDate = $req->endDate;
        $searchId = $req->search_id;
        
        $openingPurchaseBalance = getBalance('Purchase', $startDate, $searchId);
        $openingIssueBalance = getBalance('Issue', $startDate, $searchId);
        $openingPurchaseReturnToSupplierBalance = getBalance('Supplier Return', $startDate, $searchId);
        $openingClientReturnBalance = getBalance('Client Return', $startDate, $searchId);
        $openingPositiveBalance = getBalance('Positive', $startDate, $searchId);
        $openingNegativeBalance = getBalance('Negative', $startDate, $searchId);
        
        $openingBalance = $openingPurchaseBalance 
                        - $openingIssueBalance 
                        - $openingPurchaseReturnToSupplierBalance 
                        + $openingClientReturnBalance 
                        + $openingPositiveBalance 
                        - $openingNegativeBalance;
        
        if($req->search_id == ""){
            $inventory = [];
        }
        else{
            $inventory = Transaction_Detail::on('mysql_second')->with('Head')
            ->where('tran_type', 5)
            ->whereRaw("tran_date BETWEEN ? AND ?", [$req->startDate, $req->endDate . ' 23:59:59'])
            ->where('tran_head_id', $req->search_id)
            ->get();
        }
        
        return response()->json([
            'status' => true,
            'data' => $inventory,
            'openingBalance' => $openingBalance,
        ], 200);
    } // End Method



    // Print Inventory Item Flow Report
    public function Print(Request $req){
        if ($req->query()) {
            $openingPurchaseBalance = 0;
            $openingIssueBalance = 0;
            $openingPurchaseReturnToSupplierBalance = 0;
            $openingClientReturnBalance = 0;
            $openingPositiveBalance = 0;
            $openingNegativeBalance = 0;
            $openingBalance = 0;
            

            function getBalance($tranMethod, $startDate, $searchId) {
                return Transaction_Detail::on('mysql_second')->with('Head')
                    ->where('tran_type', 5)
                    ->where('tran_method', $tranMethod)
                    ->where('tran_date', '<', $startDate)
                    ->where('tran_head_id', $searchId)
                    ->sum('quantity_actual');
            }

            
            $startDate = $req->startDate;
            $endDate = $req->endDate;
            $searchId = $req->search_id;
            
            $openingPurchaseBalance = getBalance('Purchase', $startDate, $searchId);
            $openingIssueBalance = getBalance('Issue', $startDate, $searchId);
            $openingPurchaseReturnToSupplierBalance = getBalance('Supplier Return', $startDate, $searchId);
            $openingClientReturnBalance = getBalance('Client Return', $startDate, $searchId);
            $openingPositiveBalance = getBalance('Positive', $startDate, $searchId);
            $openingNegativeBalance = getBalance('Negative', $startDate, $searchId);
            
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
                ->where('tran_type', 5)
                ->whereRaw("tran_date BETWEEN ? AND ?", [$req->startDate, $req->endDate . ' 23:59:59'])
                ->where('tran_head_id', $req->search_id)
                ->get();
            }
        }
        else {
            $data = [];
            $openingBalance = 0;
        }
        
        $report_name = 'Inventory Item Flow Report';
        $start_date = $req->startDate ? $req->startDate : date('d/m/Y');
        $end_date = $req->endDate ? $req->endDate : date('d/m/Y');
        $pdf = Pdf::loadView('reports.product_reports.item_flow_statement.print', compact('report_name', 'start_date', 'end_date', 'data', 'openingBalance'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    } // End Method
}
