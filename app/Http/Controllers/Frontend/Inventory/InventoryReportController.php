<?php

namespace App\Http\Controllers\Frontend\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InventoryReportController extends Controller
{
    /////////////////////// ----------------- Inventory Item Flow Statement Part Start ----------------- //////////////////////
    // Show Inventory Item Flow Statement
    public function ShowItemFlowStatement(Request $req){
        $name = "Inventory Item Flow";
        $js = 'inventory/report/item_flow_statement/item_flow';
        if ($req->ajax()) {
            return view('reports.product_reports.item_flow_statement.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.product_reports.item_flow_statement.itemflow', compact('name', 'js'));
        }
    } // End Method



    // Inventory Item Flow Statement Search
    public function SearchItemFlowStatement(Request $req){
        $name = "Inventory Item Flow";
        $js = 'inventory/report/item_flow_statement/item_flow';
        return view('reports.product_reports.item_flow_statement.itemflow', compact('name', 'js'));
    } // End Method


    
    
    
    /////////////////////// ----------------- Inventory Stock Summary Statement Part Start ----------------- //////////////////////
    // Show Inventory Stock Summary Statement
    public function ShowStockSummaryStatement(Request $req){
        $name = "Inventory Stock Summary";
        $js = 'inventory/report/stock_statement/stock_summary';
        if ($req->ajax()) {
            return view('reports.product_reports.stock_statement.summary.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.product_reports.stock_statement.summary.stockSummary', compact('name', 'js'));
        }
    } // End Method



    // Inventory Stock Summary Statement Search
    public function SearchStockSummaryStatement(Request $req){
        $name = "Inventory Stock Summary";
        $js = 'inventory/report/stock_statement/stock_summary';
        return view('reports.product_reports.stock_statement.summary.stockSummary', compact('name', 'js'));
    } // End Method



    
    
    /////////////////////// ----------------- Inventory Stock Details Statement Part Start ----------------- //////////////////////
    // Show Inventory Stock Details Statement
    public function ShowStockDetailsStatement(Request $req){
        $name = "Inventory Stock Details";
        $js = 'inventory/report/stock_statement/stock_details';
        if ($req->ajax()) {
            return view('reports.product_reports.stock_statement.details.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.product_reports.stock_statement.details.stockDetails', compact('name', 'js'));
        }
    } // End Method


    
    // Search Inventory Stock Details Statement
    public function SearchStockDetailsStatement(Request $req){
        $name = "Inventory Stock Details";
        $js = 'inventory/report/stock_statement/stock_details';
        return view('reports.product_reports.stock_statement.details.stockDetails', compact('name', 'js'));
    } // End Method




    
    /////////////////////// ----------------- Inventory Profitability Statement Part Start ----------------- //////////////////////
    // Show Inventory Profitability Statement
    public function ShowProfitabilityStatement(Request $req){
        $name = "Inventory Profitability";
        $js = 'inventory/report/profitibility_statement/profitability_details';
        if ($req->ajax()) {
            return view('reports.product_reports.profitability_statement.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.product_reports.profitability_statement.profitabilityDetails', compact('name', 'js'));
        }
    } // End Method



    // Search Inventory Profitability Statement
    public function SearchProfitabilityStatement(Request $req){
        $name = "Inventory Profitability";
        $js = 'inventory/report/profitibility_statement/profitability_details';
        return view('reports.product_reports.profitability_statement.profitabilityDetails', compact('name', 'js'));
    } // End Method



    
    
    /////////////////////// ----------------- Inventory Expiry Statement Part Start ----------------- //////////////////////
    // Show Inventory Expiry Statement
    public function ShowExpiryStatement(Request $req){
        $name = "Inventory Expiry";
        $js = 'inventory/report/expiry_statement/expiry_details';
        if ($req->ajax()) {
            return view('reports.product_reports.expiry_statement.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.product_reports.expiry_statement.expiryDetails', compact('name', 'js'));
        }
    } // End Method
    
    
    
    // Search Inventory Expiry Statement
    public function SearchExpiryStatement(Request $req){
        $name = "Inventory Expiry";
        $js = 'inventory/report/expiry_statement/expiry_details';
        return view('reports.product_reports.expiry_statement.expiryDetails', compact('name', 'js'));
    } // End Method



    
    
    /////////////////////// ----------------- Inventory Purchase Summary Statement Part Start ----------------- //////////////////////
    // Show Inventory Purchase Summary Statement
    public function ShowPurchaseSummaryStatement(Request $req){
        $name = "Inventory Purchase Summary";
        $js = 'inventory/report/purchase_statement/purchase_summary';
        if ($req->ajax()) {
            return view('reports.product_reports.purchase_statement.summary.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.product_reports.purchase_statement.summary.purchaseSummary', compact('name', 'js'));
        }
    } // End Method



    // Search Inventory Purchase Summary Statement
    public function SearchPurchaseSummaryStatement(Request $req){
        $name = "Inventory Purchase Summary";
        $js = 'inventory/report/purchase_statement/purchase_summary';
        return view('reports.product_reports.purchase_statement.summary.purchaseSummary', compact('name', 'js'));
    } // End Method



    
    
    /////////////////////// ----------------- Inventory Purchase Details Statement Part Start ----------------- //////////////////////
    // Show Inventory Purchase Details Statement
    public function ShowPurchaseDetailsStatement(Request $req){
        $name = "Inventory Purchase Details";
        $js = 'inventory/report/purchase_statement/purchase_details';
        if ($req->ajax()) {
            return view('reports.product_reports.purchase_statement.details.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.product_reports.purchase_statement.details.purchaseDetails', compact('name', 'js'));
        }
    } // End Method



    // Search Inventory Purchase Details Statement
    public function SearchPurchaseDetailsStatement(Request $req){
        $name = "Inventory Purchase Details";
        $js = 'inventory/report/purchase_statement/purchase_details';
        return view('reports.product_reports.purchase_statement.details.purchaseDetails', compact('name', 'js'));
    } // End Method

    


    
    /////////////////////// ----------------- Inventory Issue Summary Statement Part Start ----------------- //////////////////////
    // Show Inventory Issue Summary Statement
    public function ShowIssueSummaryStatement(Request $req){
        $name = "Inventory Issue Summary";
        $js = 'inventory/report/issue_statement/issue_summary';
        if ($req->ajax()) {
            return view('reports.product_reports.issue_statement.summary.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.product_reports.issue_statement.summary.issueSummary', compact('name', 'js'));
        }
    } // End Method



    // Search Inventory Issue Summary Statement
    public function SearchIssueSummaryStatement(Request $req){
        $name = "Inventory Issue Summary";
        $js = 'inventory/report/issue_statement/issue_summary';
        return view('reports.product_reports.issue_statement.summary.issueSummary', compact('name', 'js'));
    } // End Method



    
    
    /////////////////////// ----------------- Inventory Issue Details Statement Part Start ----------------- //////////////////////
    // Show Inventory Issue Details Statement
    public function ShowIssueDetailsStatement(Request $req){
        $name = "Inventory Issue Details";
        $js = 'inventory/report/issue_statement/issue_summary';
        if ($req->ajax()) {
            return view('reports.product_reports.issue_statement.details.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.product_reports.issue_statement.details.issueDetails', compact('name', 'js'));
        }
    } // End Method



    // Search Inventory Issue Details Statement
    public function SearchIssueDetailsStatement(Request $req){
        $name = "Inventory Issue Details";
        $js = 'inventory/report/issue_statement/issue_summary';
        return view('reports.product_reports.issue_statement.details.issueDetails', compact('name', 'js'));
    } // End Method

    


    
    /////////////////////// ----------------- Inventory Supplier Return Summary Statement Part Start ----------------- //////////////////////
    // Show Inventory Supplier Return Summary Statement
    public function ShowSupplierReturnSummaryStatement(Request $req){
        $name = "Inventory Supplier Return Summary";
        $js = 'inventory/report/return_statement/supplier/return_summary';
        if ($req->ajax()) {
            return view('reports.product_reports.return_statement.summary.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.product_reports.return_statement.summary.returnSummary', compact('name', 'js'));
        }
    } // End Method



    // Search Inventory Supplier Return Summary Statement
    public function SearchSupplierReturnSummaryStatement(Request $req){
        $name = "Inventory Supplier Return Summary";
        $js = 'inventory/report/return_statement/supplier/return_summary';
        return view('reports.product_reports.return_statement.summary.returnSummary', compact('name', 'js'));
    } // End Method





    /////////////////////// ----------------- Inventory Supplier Return Details Statement Part Start ----------------- //////////////////////
    // Show Inventory Supplier Return Details Statement
    public function ShowSupplierReturnDetailsStatement(Request $req){
        $name = "Inventory Supplier Return Details";
        $js = 'inventory/report/return_statement/supplier/return_details';
        if ($req->ajax()) {
            return view('reports.product_reports.return_statement.details.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.product_reports.return_statement.details.returnDetails', compact('name', 'js'));
        }
    } // End Method



    // Search Inventory Supplier Return Details Statement
    public function SearchSupplierReturnDetailsStatement(Request $req){
        $name = "Inventory Supplier Return Details";
        $js = 'inventory/report/return_statement/supplier/return_details';
        return view('reports.product_reports.return_statement.details.returnDetails', compact('name', 'js'));
    } // End Method





    /////////////////////// ----------------- Inventory Client Return Summary Statement Part Start ----------------- //////////////////////
    // Show Inventory Client Return Summary Statement
    public function ShowClientReturnSummaryStatement(Request $req){
        $name = "Inventory Client Return Summary";
        $js = 'inventory/report/return_statement/client/return_summary';
        if ($req->ajax()) {
            return view('reports.product_reports.return_statement.summary.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.product_reports.return_statement.summary.returnSummary', compact('name', 'js'));
        }
    } // End Method



    // Search Inventory Client Return Summary Statement
    public function SearchClientReturnSummaryStatement(Request $req){
        $name = "Inventory Client Return Summary";
        $js = 'inventory/report/return_statement/client/return_summary';
        return view('reports.product_reports.return_statement.summary.returnSummary', compact('name', 'js'));
    } // End Method
    




    /////////////////////// ----------------- Inventory Client Return Details Statement Part Start ----------------- //////////////////////
    // Show Inventory Client Return Details Statement
    public function ShowClientReturnDetailsStatement(Request $req){
        $name = "Inventory Client Return Details";
        $js = 'inventory/report/return_statement/client/return_details';
        if ($req->ajax()) {
            return view('reports.product_reports.return_statement.details.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.product_reports.return_statement.details.returnDetails', compact('name', 'js'));
        }
    } // End Method



    // Search Inventory Client Return Details Statement
    public function SearchClientReturnDetailsStatement(Request $req){
        $name = "Inventory Client Return Details";
        $js = 'inventory/report/return_statement/client/return_details';
        return view('reports.product_reports.return_statement.details.returnDetails', compact('name', 'js'));
    } // End Method
}