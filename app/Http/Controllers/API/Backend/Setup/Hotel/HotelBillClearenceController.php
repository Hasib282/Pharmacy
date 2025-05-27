<?php

namespace App\Http\Controllers\API\Backend\Setup\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Bed_Transfer;

class HotelBillClearenceController extends Controller
{
    // Show All Hotel Bill Clearence Data
    public function Show(Request $req)
    {
        $data = Bed_Transfer::on('mysql_second')->with('FromList','ToList','User')->orderBy('added_at')->get();
        // $transactionMain = Transaction_Main::on('mysql_second')->where('tran_id', $req->id)->first();
        // $transDetailsInvoice = Transaction_Detail::on('mysql_second')->
        // select(
        //     'tran_head_id', 
        //     'amount', 
        //     DB::raw('SUM(quantity) as sum_quantity'), 
        //     DB::raw('SUM(quantity_actual) as sum_quantity_actual'), 
        //     DB::raw('SUM(tot_amount) as sum_tot_amount'), 
        //     DB::raw('COUNT(*) as count')
        // )
        // ->where('tran_id', $req->id)
        // ->groupBy('tran_head_id','amount')
        // ->get();
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    }



    // Insert Hotel Bill Clearence Data
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
            'message' => 'Hotel Bill Clearence Completed successfully',
            'data'    => $data,
        ], 200);
    }



    // Update Hotel Bill Clearence Data
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
            'message'     => 'Hotel Bill Clearence updated successfully',
            "updatedData" => $updatedData,
        ], 200);
    }



    // Delete Hotel Bill Clearence Data
    public function Delete(Request $req)
    {
        $data = Bed_Transfer::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'  => true,
            'message' => 'Hotel Bill Clearence deleted successfully',
        ], 200);
    }
}
