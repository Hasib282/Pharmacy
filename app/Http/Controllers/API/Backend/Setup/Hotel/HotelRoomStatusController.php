<?php

namespace App\Http\Controllers\API\Backend\Setup\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Bed_List;



class HotelRoomStatusController extends Controller
{
    // Show Room Status By Room List
    public function Show(Request $req){
        $data = Bed_List::on('mysql_second')->with('bed_category','latestBooking.User')->orderBy('id')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method

}