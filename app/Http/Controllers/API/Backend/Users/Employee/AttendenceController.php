<?php

namespace App\Http\Controllers\API\Backend\Users\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Models\User_Info;
use App\Models\Attendence;
use App\Models\Pay_Roll_Setup;
use App\Models\Transaction_With;
use App\Models\Employee_Personal_Detail;
use App\Models\Employee_Training_Detail;
use App\Models\Employee_Education_Detail;
use App\Models\Employee_Experience_Detail;
use App\Models\Employee_Organization_Detail;

class AttendenceController extends Controller
{
    // Show All Attendence
    public function ShowAll(Request $req){
        $attendence = Attendence::with('User')->orderBy('insert_at')->whereRaw("DATE(date) = ?", [date('Y-m-d')])->paginate(15);
        $tranwith = Transaction_With::on('mysql_second')->where('user_role', 3)->get();
        return response()->json([
            'status'=> true,
            'data' => $attendence,
            'tranwith' => $tranwith,
        ], 200);
    } // End Method



    // Insert Attendence
    public function Insert(Request $req){
        $req->validate([
            "user" => 'required|exists:mysql_second.employee__personal__details,employee_id',
            "date" => 'required|date',
            "in" => 'required',
        ]);

        $insert = Attendence::insert([
            "emp_id" => $req->user,
            "date" => $req->date,
            "in" => $req->in,
        ]);
        
        return response()->json([
            'status'=> true,
            'message' => 'Attendence Added Successfully'
        ], 200);  
    } // End Method



    // Edit Attendence
    public function Edit(Request $req){
        $attendence = Attendence::with('User')->findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'attendence'=> $attendence,
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

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Attendence Updated Successfully',
            ], 200); 
        }
    } // End Method



    // // Delete Attendence
    // public function Delete(Request $req){
    //     Attendence::findOrFail($req->id)->delete();
    //     return response()->json([
    //         'status'=> true,
    //         'message' => 'Attendence Deleted Successfully',
    //     ], 200); 
    // } // End Method



    // Search Attendence
    public function Search(Request $req){
        $attendence = Attendence::with('User')
        ->whereHas('User', function ($q) use ($req) {
            $q->where('user_name', 'like', '%' . $req->search . '%');
        })
        ->whereRaw("DATE(date) BETWEEN ? AND ?", [$req->startDate, $req->endDate])    
        ->orderBy('date')
        ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $attendence,
        ], 200);
    } // End Method
}
