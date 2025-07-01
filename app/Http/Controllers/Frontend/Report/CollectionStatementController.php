<?php

namespace App\Http\Controllers\Frontend\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CollectionStatementController extends Controller
{
    ///////////////////////// --------------------------- Collection Invoice Statement Summary Report Part Start -------------------- /////////////////////////
    // Show Collection Summary Statement
    public function CollectionSummary(Request $req) {
        $name = "Collection Statement Summary";
        $js = 'collection_statement/summary';
        if ($req->ajax()) {
            return view('reports.collections_statement.summary.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.collections_statement.summary.main', compact('name', 'js'));
        }
    } // End Method


    // Search Collection Details Statement
    public function CollectionDetails(Request $req) {
        $name = "Collection Statement Details";
        $js = 'collection_statement/details';
        if ($req->ajax()) {
            return view('reports.collections_statement.details.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.collections_statement.details.main', compact('name', 'js'));
        }
    } // End Method
    
    



    ///////////////////////// --------------------------- Consolidated Invoice Statement Summary Report Part Start -------------------- /////////////////////////
    // Show Invoice Collection Summary Statement
    public function CollectionInvoiceSummary(Request $req) {
        $name = "Collection Invoice Statement Summary";
        $js = 'collection_statement/invoice_summary';
        if ($req->ajax()) {
            return view('reports.collections_statement.summary.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.collections_statement.summary.main', compact('name', 'js'));
        }
    } // End Method


    // Search Invoice Collection Details Statement
    public function CollectionInvoiceDetails(Request $req) {
        $name = "Collection Invoice Statement Details";
        $js = 'collection_statement/invoice_details';
        if ($req->ajax()) {
            return view('reports.collections_statement.details.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.collections_statement.details.main', compact('name', 'js'));
        }
    } // End Method

}
