<?php

namespace App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Transaction_Detail;
use App\Models\Transaction_Groupe;

class PharmacyItemFlowStatementController extends Controller
{
    // Show All Pharmacy Item Flow Statement
    public function ShowAll(Request $req){
        $groupes = Transaction_Groupe::on('mysql_second')->where('tran_groupe_type', '6')->orderBy('added_at','asc')->get();
        return response()->json([
            'status'=> true,
            'data' => [],
            'groupes' => $groupes,
        ], 200);
    } // End Method



    // Search Pharmacy Item Flow Statement
    public function Search(Request $req){
        $openingPurchaseBalance = 0;
        $openingIssueBalance = 0;
        $openingPurchaseReturnToSupplierBalance = 0;
        $openingClientReturnBalance = 0;
        $openingPositiveBalance = 0;
        $openingNegativeBalance = 0;
        $openingBalance = 0;
        

        function getBalance($tranMethod, $startDate, $searchId) {
            return Transaction_Detail::on('mysql')->with('Head')
                ->where('tran_type', 6)
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
        
        if($req->search == ""){
            $pharmacy = [];
        }
        else{
            $pharmacy = Transaction_Detail::on('mysql')->with('Head')
            ->where('tran_type', 6)
            ->whereRaw("tran_date BETWEEN ? AND ?", [$req->startDate, $req->endDate . ' 23:59:59'])
            ->where('tran_head_id', $req->search_id)
            ->get();
        }
        
        return response()->json([
            'status' => true,
            'data' => $pharmacy,
            'openingBalance' => $openingBalance,
        ], 200);
    } // End Method
}
