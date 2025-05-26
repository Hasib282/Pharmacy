<?php

namespace App\Http\Controllers\API\Backend\Setup\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Bed_Transfer;

class HotelTransferController extends Controller
{
    // Show All Bed Transfers
    public function Show(Request $req)
    {
        $data = Bed_Transfer::on('mysql_second')->orderBy('added_at')->get();

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    }

    // Insert Bed Transfer
    public function Insert(Request $req)
    {
        $req->validate([
            "guest_id"      => 'required|unique:mysql_second.Bed_Transfer,guest_id',
            "from_bed"      => 'required',
            "bed_list"        => 'required',
            "transfer_date" => 'required|datetime',
        
        ]);

        $insert = Bed_Transfer::on('mysql_second')->create([
            "guest_id"      => $req->guest_id,
            "from_bed"      => $req->from_bed,
            "to_bed"        => $req->bed_list,
            "transfer_date" => $req->transfer_date,
            "transfer_by"   => $req->transfer_by,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Bed Transfer added successfully',
            'data'    => $insert,
        ], 200);
    }

    // Update Bed Transfer
    public function Update(Request $req)
    {
        $data = Bed_Transfer::on('mysql_second')->findOrFail($req->id);

        $req->validate([
            "guest_id"      => ['required', Rule::unique('mysql_second.Bed_Transfer', 'guest_id')->ignore($data->id)],
            "from_bed"      => 'required',
            "bed_list"        => 'required',
            "transfer_date" => 'required|datetime',
            
        ]);

        $data->update([
            "guest_id"      => $req->guest_id,
            "from_bed"      => $req->from_bed,
            "to_bed"        => $req->bed_list,
            "transfer_date" => $req->transfer_date,
            
            "updated_at"    => now(),
        ]);

        return response()->json([
            'status'      => true,
            'message'     => 'Bed Transfer updated successfully',
            'updatedData' => $data,
        ], 200);
    }

    // Delete Bed Transfer
    public function Delete(Request $req)
    {
        $data = Bed_Transfer::on('mysql_second')->findOrFail($req->id);
        $data->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Bed Transfer deleted successfully',
        ], 200);
    }
}
