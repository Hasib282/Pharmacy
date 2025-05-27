<?php

namespace App\Http\Controllers\API\Backend\Setup\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Bed_Transfer;

class HotelRoomTransferController extends Controller
{
    // Show All Room Transfer Data
    public function Show(Request $req)
    {
        $data = Bed_Transfer::on('mysql_second')->orderBy('added_at')->get();
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
            "bed_list"        => 'required|exists:mysql_second.bed__lists,id',
            "transfer_date" => 'required|datetime',
        
        ]);

        $insert = Bed_Transfer::on('mysql_second')->create([
            "guest_id"      => $req->guest_id,
            "from_bed"      => $req->from_bed,
            "to_bed"        => $req->bed_list,
            "transfer_date" => $req->transfer_date,
            "transfer_by"   => $req->transfer_by,
        ]);

        $data = Bed_Transfer::on('mysql_second')->findOrFail($insert->id);

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
            "bed_list"        => 'required|exists:mysql_second.bed__lists,id',
            "transfer_date" => 'required|datetime',
        ]);

        $data->update([
            "guest_id"      => $req->guest_id,
            "from_bed"      => $req->from_bed,
            "to_bed"        => $req->bed_list,
            "transfer_date" => $req->transfer_date,
            "updated_at"    => now(),
        ]);

        $updatedData = Bed_Transfer::on('mysql_second')->findOrFail($req->id);

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
