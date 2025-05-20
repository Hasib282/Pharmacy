<?php

namespace App\Http\Controllers\API\Backend\Setup\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appoinment;
use App\Models\Bed_Category;
use App\Models\Bed_List;



class HotelBedStatusController extends Controller
{
    // Show Bed Status By Bed List
    public function Show(Request $req){
        $data = Bed_List::on('mysql_second')->with('category','latestBooking.User')->orderBy('id')->get();
        // $data = Bed_List::on('mysql_second')->with('category','Booking')->orderBy('added_at')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method

}