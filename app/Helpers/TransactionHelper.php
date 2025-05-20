<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Transaction_Main;


// --------------------------------------- Get Transaction Type Data -------------------------------- //
// This Helper Function is for Getting Transaction Type Data 
if (!function_exists('GenarateTranId')) {
    function GenerateTranId($type, $method, $prefix) {
        // Generates Auto Increment Purchase Id
        $transaction = Transaction_Main::on('mysql_second')->where('tran_type', $type)->where('tran_method', $method)->latest('tran_id')->first();
        return $id = $transaction ? $prefix . str_pad((intval(substr($transaction->tran_id, 3)) + 1), 9, '0', STR_PAD_LEFT) : $prefix .'000000001';
    }
}