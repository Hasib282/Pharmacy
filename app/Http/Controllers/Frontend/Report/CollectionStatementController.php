<?php

namespace App\Http\Controllers\Frontend\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CollectionStatementController extends Controller
{
    //collection summery
      public function CollectionSummary(Request $req) {
        $name = "Collection Summary Statement";
        $js = 'report/account_statement/summary';
        if ($req->ajax()) {
            return view('reports.collections_statement.summary.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.collections_statement.summary.main', compact('name', 'js'));
        }
    } // End Method


    //collection details
      public function CollectionDetails(Request $req) {
        $name = "Collection Details Statement";
        $js = 'report/account_statement/summary';
        if ($req->ajax()) {
            return view('reports.collections_statement.details.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('reports.collections_statement.details.main', compact('name', 'js'));
        }
    } // End Method

}
