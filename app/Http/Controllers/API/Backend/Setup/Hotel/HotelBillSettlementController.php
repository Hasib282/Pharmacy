<?php

namespace App\Http\Controllers\API\Backend\Setup\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Bed_Transfer;
use App\Models\Booking;

class HotelBillSettlementController extends Controller
{
    // Show All Hotel Bill Settlement Data
    public function Show(Request $req)
    {
        $data = Booking::on('mysql_second')->with('User','Category','List','Sr','Bill')->get();

        return response()->json([
            'status'=>true,
            'data'=>$data
        ],200);
    }



    // Insert Hotel Bill Settlement Data
    public function Insert(Request $req)
    {
        $req->validate([
            "guest_id"      => 'required|exists:mysql_second.user__infos,user_id',
            "from_bed"      => 'required|exists:mysql_second.bed__lists,id',
            "to_bed"        => 'required|exists:mysql_second.bed__lists,id',
            "transfer" => 'required|date',
        
        ]);

        $insert = Bed_Transfer::on('mysql_second')->create([
            "user_id"      => $req->guest_id,
            "from_bed"      => $req->from_bed,
            "to_bed"        => $req->to_bed,
            "transfer_date" => $req->transfer,
            "transfer_by"   => $req->transfer_by,
        ]);

        $data = Bed_Transfer::on('mysql_second')->with('FromList','ToList','User')->findOrFail($insert->id);

        return response()->json([
            'status'  => true,
            'message' => 'Hotel Bill Settlement Completed successfully',
            'data'    => $data,
        ], 200);
    }



    // Update Hotel Bill Settlement Data
    public function Update(Request $req)
    {
        $data = Bed_Transfer::on('mysql_second')->findOrFail($req->id);

        $req->validate([
            "guest_id"      => 'required|exists:mysql_second.user__infos,user_id',
            "from_bed"      => 'required|exists:mysql_second.bed__lists,id',
            "to_bed"        => 'required|exists:mysql_second.bed__lists,id',
            "transfer" => 'required|date',
        ]);

        $data->update([
            "user_id"      => $req->guest_id,
            "from_bed"      => $req->from_bed,
            "to_bed"        => $req->to_bed,
            "transfer_date" => $req->transfer,
            "updated_at"    => now(),
        ]);

        $updatedData = Bed_Transfer::on('mysql_second')->with('FromList','ToList','User')->findOrFail($req->id);

        return response()->json([
            'status'      => true,
            'message'     => 'Hotel Bill Settlement updated successfully',
            "updatedData" => $updatedData,
        ], 200);
    }



    // Delete Hotel Bill Settlement Data
    public function Delete(Request $req)
    {
        $data = Bed_Transfer::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'  => true,
            'message' => 'Hotel Bill Settlement deleted successfully',
        ], 200);
    }
}
