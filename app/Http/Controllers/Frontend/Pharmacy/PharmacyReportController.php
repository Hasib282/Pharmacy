<?php

namespace App\Http\Controllers\Frontend\Pharmacy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PharmacyReportController extends Controller
{
    /////////////////////// ----------------- Pharmacy Item Flow Statement Part Start ----------------- //////////////////////
    // Show Pharmacy Item Flow Statement
    public function ShowItemFlowStatement(Request $req){
        $name = "Pharmacy Item Flow";
        $js = 'pharmacy/report/item_flow_statement/item_flow';
        if ($req->ajax()) {
            return view('reports.product_reports.item_flow_statement.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.product_reports.item_flow_statement.itemflow', compact('name', 'js'));
        }
    } // End Method



    // Pharmacy Item Flow Statement Search
    public function SearchItemFlowStatement(Request $req){
        $name = "Pharmacy Item Flow";
        $js = 'pharmacy/report/item_flow_statement/item_flow';
        return view('reports.product_reports.item_flow_statement.itemflow', compact('name', 'js'));
    } // End Method
    
    
    
    

    /////////////////////// ----------------- Pharmacy Stock Summary Statement Part Start ----------------- //////////////////////
    // Show Pharmacy Stock Summary Statement
    public function ShowStockSummaryStatement(Request $req){
        $name = "Pharmacy Stock Summary";
        $js = 'pharmacy/report/stock_statement/stock_summary';
        if ($req->ajax()) {
            return view('reports.product_reports.stock_statement.summary.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.product_reports.stock_statement.summary.stockSummary', compact('name', 'js'));
        }
    } // End Method



    // Pharmacy Stock Summary Statement Search
    public function SearchStockSummaryStatement(Request $req){
        $name = "Pharmacy Stock Summary";
        $js = 'pharmacy/report/stock_statement/stock_summary';
        return view('reports.product_reports.stock_statement.summary.stockSummary', compact('name', 'js'));
    } // End Method

    
    
    
    
    /////////////////////// ----------------- Pharmacy Stock Details Statement Part Start ----------------- //////////////////////
    // Show Pharmacy Stock Details Statement
    public function ShowStockDetailsStatement(Request $req){
        $name = "Pharmacy Stock Summary";
        $js = 'pharmacy/report/stock_statement/stock_details';
        if ($req->ajax()) {
            return view('reports.product_reports.stock_statement.details.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.product_reports.stock_statement.details.stockDetails', compact('name', 'js'));
        }
    } // End Method



    // Search Pharmacy Stock Details Statement
    public function SearchStockDetailsStatement(Request $req){
        $name = "Pharmacy Stock Summary";
        $js = 'pharmacy/report/stock_statement/stock_details';
        return view('reports.product_reports.stock_statement.details.stockDetails', compact('name', 'js'));
    } // End Method


    
    
    
    /////////////////////// ----------------- Pharmacy Profitability Statement Part Start ----------------- //////////////////////
    // Show Pharmacy Profitability Statement
    public function ShowProfitabilityStatement(Request $req){
        $name = "Pharmacy Profitability";
        $js = 'pharmacy/report/profitibility_statement/profitability_details';
        if ($req->ajax()) {
            return view('reports.product_reports.profitability_statement.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.product_reports.profitability_statement.profitabilityDetails', compact('name', 'js'));
        }
    } // End Method



    // Search Pharmacy Profitability Statement
    public function SearchProfitabilityStatement(Request $req){
        $name = "Pharmacy Profitability";
        $js = 'pharmacy/report/profitibility_statement/profitability_details';
        return view('reports.product_reports.profitability_statement.profitabilityDetails', compact('name', 'js'));
    } // End Method

    
    
    
    
    /////////////////////// ----------------- Pharmacy Expiry Statement Part Start ----------------- //////////////////////
    // Show Pharmacy Expiry Statement
    public function ShowExpiryStatement(Request $req){
        $name = "Pharmacy Expiry";
        $js = 'pharmacy/report/expiry_statement/expiry_details';
        if ($req->ajax()) {
            return view('reports.product_reports.expiry_statement.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.product_reports.expiry_statement.expiryDetails', compact('name', 'js'));
        }
    } // End Method
    
    
    
    // Search Pharmacy Expiry Statement
    public function SearchExpiryStatement(Request $req){
        $name = "Pharmacy Expiry";
        $js = 'pharmacy/report/expiry_statement/expiry_details';
        return view('reports.product_reports.expiry_statement.expiryDetails', compact('name', 'js'));
    } // End Method

    
    
    
    
    /////////////////////// ----------------- Pharmacy Purchase Summary Statement Part Start ----------------- //////////////////////
    // Show Pharmacy Purchase Summary Statement
    public function ShowPurchaseSummaryStatement(Request $req){
        $name = "Pharmacy Purchase Summary";
        $js = 'pharmacy/report/purchase_statement/purchase_summary';
        if ($req->ajax()) {
            return view('reports.product_reports.purchase_statement.summary.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.product_reports.purchase_statement.summary.purchaseSummary', compact('name', 'js'));
        }
    } // End Method



    // Search Pharmacy Purchase Summary Statement
    public function SearchPurchaseSummaryStatement(Request $req){
        $name = "Pharmacy Purchase Summary";
        $js = 'pharmacy/report/purchase_statement/purchase_summary';
        return view('reports.product_reports.purchase_statement.summary.purchaseSummary', compact('name', 'js'));
    } // End Method

    
    
    
    
    /////////////////////// ----------------- Pharmacy Purchase Details Statement Part Start ----------------- //////////////////////
    // Show Pharmacy Purchase Details Statement
    public function ShowPurchaseDetailsStatement(Request $req){
        $name = "Pharmacy Purchase Summary";
        $js = 'pharmacy/report/purchase_statement/purchase_details';
        if ($req->ajax()) {
            return view('reports.product_reports.purchase_statement.details.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.product_reports.purchase_statement.details.purchaseDetails', compact('name', 'js'));
        }
    } // End Method



    // Search Pharmacy Purchase Details Statement
    public function SearchPurchaseDetailsStatement(Request $req){
        $name = "Pharmacy Purchase Summary";
        $js = 'pharmacy/report/purchase_statement/purchase_details';
        return view('reports.product_reports.purchase_statement.details.purchaseDetails', compact('name', 'js'));
    } // End Method

    
    
    
    
    /////////////////////// ----------------- Pharmacy Issue Summary Statement Part Start ----------------- //////////////////////
    // Show Pharmacy Issue Summary Statement
    public function ShowIssueSummaryStatement(Request $req){
        $name = "Pharmacy Issue Summary";
        $js = 'pharmacy/report/issue_statement/issue_summary';
        if ($req->ajax()) {
            return view('reports.product_reports.issue_statement.summary.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.product_reports.issue_statement.summary.issueSummary', compact('name', 'js'));
        }
    } // End Method



    // Search Pharmacy Issue Summary Statement
    public function SearchIssueSummaryStatement(Request $req){
        $name = "Pharmacy Issue Summary";
        $js = 'pharmacy/report/issue_statement/issue_summary';
        return view('reports.product_reports.issue_statement.summary.issueSummary', compact('name', 'js'));
    } // End Method

    
    
    
    
    /////////////////////// ----------------- Pharmacy Issue Details Statement Part Start ----------------- //////////////////////
    // Show Pharmacy Issue Details Statement
    public function ShowIssueDetailsStatement(Request $req){
        $name = "Pharmacy Issue Summary";
        $js = 'pharmacy/report/issue_statement/issue_details';
        if ($req->ajax()) {
            return view('reports.product_reports.issue_statement.details.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.product_reports.issue_statement.details.issueDetails', compact('name', 'js'));
        }
    } // End Method



    // Search Pharmacy Issue Details Statement
    public function SearchIssueDetailsStatement(Request $req){
        $name = "Pharmacy Issue Summary";
        $js = 'pharmacy/report/issue_statement/issue_details';
        return view('reports.product_reports.issue_statement.details.issueDetails', compact('name', 'js'));
    } // End Method

    
    
    
    
    /////////////////////// ----------------- Pharmacy Supplier Return Summary Statement Part Start ----------------- //////////////////////
    // Show Pharmacy Supplier Return Summary Statement
    public function ShowSupplierReturnSummaryStatement(Request $req){
        $name = "Pharmacy Supplier Return Summary";
        $js = 'pharmacy/report/return_statement/supplier/return_summary';
        if ($req->ajax()) {
            return view('reports.product_reports.return_statement.summary.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.product_reports.return_statement.summary.returnSummary', compact('name', 'js'));
        }
    } // End Method



    // Search Pharmacy Supplier Return Summary Statement
    public function SearchSupplierReturnSummaryStatement(Request $req){
        $name = "Pharmacy Supplier Return Summary";
        $js = 'pharmacy/report/return_statement/supplier/return_summary';
        return view('reports.product_reports.return_statement.summary.returnSummary', compact('name', 'js'));
    } // End Method

    
    
    
    
    /////////////////////// ----------------- Pharmacy Supplier Return Details Statement Part Start ----------------- //////////////////////
    // Show Pharmacy Supplier Return Details Statement
    public function ShowSupplierReturnDetailsStatement(Request $req){
        $name = "Pharmacy Supplier Return Details";
        $js = 'pharmacy/report/return_statement/supplier/return_details';
        if ($req->ajax()) {
            return view('reports.product_reports.return_statement.details.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.product_reports.return_statement.details.returnDetails', compact('name', 'js'));
        }
    } // End Method



    // Search Pharmacy Supplier Return Details Statement
    public function SearchSupplierReturnDetailsStatement(Request $req){
        $name = "Pharmacy Supplier Return Details";
        $js = 'pharmacy/report/return_statement/supplier/return_details';
        return view('reports.product_reports.return_statement.details.returnDetails', compact('name', 'js'));
    } // End Method

    
    
    
    
    /////////////////////// ----------------- Pharmacy Client Return Summary Statement Part Start ----------------- //////////////////////
    // Show Pharmacy Client Return Summary Statement
    public function ShowClientReturnSummaryStatement(Request $req){
        $name = "Pharmacy Client Return Summary";
        $js = 'pharmacy/report/return_statement/client/return_summary';
        if ($req->ajax()) {
            return view('reports.product_reports.return_statement.summary.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.product_reports.return_statement.summary.returnSummary', compact('name', 'js'));
        }
    } // End Method



    // Search Pharmacy Client Return Summary Statement
    public function SearchClientReturnSummaryStatement(Request $req){
        $name = "Pharmacy Client Return Summary";
        $js = 'pharmacy/report/return_statement/client/return_summary';
        return view('reports.product_reports.return_statement.summary.returnSummary', compact('name', 'js'));
    } // End Method

    
    


    /////////////////////// ----------------- Pharmacy Client Return Details Statement Part Start ----------------- //////////////////////
    // Show Pharmacy Client Return Details Statement
    public function ShowClientReturnDetailsStatement(Request $req){
        $name = "Pharmacy Client Return Details";
        $js = 'pharmacy/report/return_statement/client/return_details';
        if ($req->ajax()) {
            return view('reports.product_reports.return_statement.details.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.product_reports.return_statement.details.returnDetails', compact('name', 'js'));
        }
    } // End Method



    // Search Pharmacy Client Return Details Statement
    public function SearchClientReturnDetailsStatement(Request $req){
        $name = "Pharmacy Client Return Details";
        $js = 'pharmacy/report/return_statement/client/return_details';
        return view('reports.product_reports.return_statement.details.returnDetails', compact('name', 'js'));
    } // End Method
}
