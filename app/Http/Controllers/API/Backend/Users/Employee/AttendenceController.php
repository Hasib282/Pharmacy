<?php

namespace App\Http\Controllers\API\Backend\Users\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Attendence;

class AttendenceController extends Controller
{
    // Show All Attendence
    public function Show(Request $req){
        $data = Attendence::on('mysql_second')->with('User')->orderBy('insert_at')->whereRaw("DATE(date) = ?", [date('Y-m-d')])->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Attendence
    public function Insert(Request $req){
        $req->validate([
            "user" => 'required|exists:mysql_second.employee__personal__details,employee_id',
            "date" => 'required|date',
            "in" => 'required',
        ]);

        $insert = Attendence::create([
            "emp_id" => $req->user,
            "date" => $req->date,
            "in" => $req->in,
        ]);

        $data = Attendence::on('mysql_second')->with('User')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Attendence Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method



    // Update Attendence
    public function Update(Request $req){
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 ){
            $req->validate([
                "out" => 'required',
                "in"  => 'required',
            ]);

            $update = Attendence::findOrFail($req->id)->update([
                "in" => $req->in,
                "out" => $req->out,
                "updated_at" => now()
            ]);
        }
        else{
            $req->validate([
                "out" => 'required',
            ]);

            $update = Attendence::findOrFail($req->id)->update([
                "in" => $req->in,
                "out" => $req->out,
                "updated_at" => now()
            ]);
        }        

        $updatedData = Attendence::on('mysql_second')->with('User')->findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Attendence Updated Successfully',
                "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method



    // Delete Companies Status
    public function DeleteStatus(Request $req){
        $data = Attendence::on('mysql')->findOrFail($req->id);
        $data->update(['status' => $data->status == 0 ? 1 : 0]);
        
        $updatedData = Attendence::on('mysql')->with('Type')->findOrFail($req->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Company Details Deleted Successfully',
            'updatedData' => $updatedData
        ], 200);
    } // End Method



    // Search Attendence
    public function Search(Request $req){
        $data = Attendence::with('User')
        ->whereHas('User', function ($q) use ($req) {
            $q->where('user_name', 'like', '%' . $req->search . '%');
        })
        ->whereRaw("DATE(date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])    
        ->orderBy('date')
        ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method
}
