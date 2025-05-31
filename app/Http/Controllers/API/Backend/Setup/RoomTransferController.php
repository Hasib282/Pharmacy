<?php

namespace App\Http\Controllers\API\Backend\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Bed_Transfer;
use App\Models\Booking;

class RoomTransferController extends Controller
{
    // Show All Room Transfer Data
    public function Show(Request $req)
    {
        $data = Bed_Transfer::on('mysql_second')->with('FromList','ToList','User','Category')->orderBy('added_at')->get();
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    }



    // Insert Room Transfer Data
    public function Insert(Request $req)
    {
        $req->validate([
            "guest_id"      => 'required|exists:mysql_second.user__infos,user_id',
            "from_bed"      => 'required|exists:mysql_second.bed__lists,id',
            "to_bed"        => 'required|exists:mysql_second.bed__lists,id',
            "transfer"      => 'required|date',
            "booking_id"    => 'required|exists:mysql_second.bookings,booking_id',
            "category_id"    => 'required|exists:mysql_second.bed__categories,id',
        ]);

        $insert = Bed_Transfer::on('mysql_second')->create([
            'booking_id'    => $req->booking_id,
            "user_id"       => $req->guest_id,
            'category_id'   => $req->category_id,
            "from_bed"      => $req->from_bed,
            "to_bed"        => $req->to_bed,
            "transfer_date" => $req->transfer,
            "transfer_by"   => $req->transfer_by,
        ]);

        Booking::on('mysql_second')->where('booking_id', $req->booking_id)->update([
            'bed_category' => $req->category_id,
            'bed_list' => $req->to_bed,
            "updated_at" => now()
        ]);

        $data = Bed_Transfer::on('mysql_second')->with('FromList','ToList','User','Category')->findOrFail($insert->id);

        return response()->json([
            'status'  => true,
            'message' => 'Room Transfer Completed successfully',
            'data'    => $data,
        ], 200);
    }



    // Update Room Transfer Data
    public function Update(Request $req)
    {
        $data = Bed_Transfer::on('mysql_second')->findOrFail($req->id);

        $req->validate([
            "guest_id"      => 'required|exists:mysql_second.user__infos,user_id',
            "from_bed"      => 'required|exists:mysql_second.bed__lists,id',
            "to_bed"        => 'required|exists:mysql_second.bed__lists,id',
            "transfer"      => 'required|date',
            "booking_id"    => 'required|exists:mysql_second.bookings,booking_id',
            "category_id"   => 'required|exists:mysql_second.bed__categories,id',
        ]);

        $data->update([
            'booking_id'    => $req->booking_id,
            "user_id"       => $req->guest_id,
            'category_id'   => $req->category_id,
            "from_bed"      => $req->from_bed,
            "to_bed"        => $req->to_bed,
            "transfer_date" => $req->transfer,
            "updated_at"    => now(),
        ]);

        Booking::on('mysql_second')->where('booking_id', $req->booking_id)->update([
            'bed_category'  => $req->category_id,
            'bed_list'      => $req->to_bed,
            "updated_at"    => now()
        ]);

        $updatedData = Bed_Transfer::on('mysql_second')->with('FromList','ToList','User','Category')->findOrFail($req->id);

        return response()->json([
            'status'      => true,
            'message'     => 'Room Transfer updated successfully',
            "updatedData" => $updatedData,
        ], 200);
    }



    // Delete Room Transfer Data
    public function Delete(Request $req)
    {
        $data = Bed_Transfer::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'  => true,
            'message' => 'Room Transfer deleted successfully',
        ], 200);
    }
}
