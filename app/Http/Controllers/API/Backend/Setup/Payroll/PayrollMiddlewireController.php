<?php

namespace App\Http\Controllers\API\Backend\Setup\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Transaction_With;
use App\Models\Transaction_Head;
use App\Models\Payroll_Setup;
use App\Models\Payroll_Middlewire;

class PayrollMiddlewireController extends Controller
{
    // Show All Payroll Middlewire
    public function Show(Request $req){
        $currentYear = Carbon::now()->year; 
        $currentMonth = Carbon::now()->month;
        $data = Payroll_Middlewire::on('mysql_second')
            ->with('Employee','Head')
            ->orderBy('emp_id','asc')
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->get(); 
        $tranwith = Transaction_With::on('mysql_second')->where('user_role', 3)->get();
        $heads = Transaction_Head::on('mysql_second')->where('groupe_id','1')->get();

        return response()->json([
            'status'=> true,
            'data' => $data,
            'tranwith' => $tranwith,
            'heads' => $heads,
        ], 200);
    } // End Method



    // Insert Payroll Middlewire
    public function Insert(Request $req){
        $currentYear = $req->year;
        $currentMonth = $req->month;
        $date = $req->year."-".$req->month."-01";

        $req->validate([
            "user" => 'required|exists:mysql_second.employee__personal__details,employee_id',
            "head" => 'required|exists:mysql_second.transaction__heads,id',
            "amount" => 'required|numeric',
        ]);


        // Check If the Salary Component is Already Added or Not
        $middlewire = Payroll_Middlewire::on('mysql_second')->where('emp_id', $req->user)
                    ->where('head_id', $req->head)
                    ->where(function ($query) use ($currentYear, $currentMonth) {
                        $query->whereYear('date', $currentYear)
                            ->whereMonth('date', $currentMonth)
                            ->orWhereNull('date');
                    })
                    ->count();

        $setup = Payroll_Setup::on('mysql_second')->where('emp_id', $req->user)
                    ->where('head_id', $req->head)
                    ->count();

        // If the Salary Component is Already Added Send Error Message
        if($middlewire > 0 || $setup > 0){
            return response()->json([
                'errors' => [
                    'head' => ["You have already added this salary component for this user."]
                ]
            ], 422);
        }
        else{
            $insert = Payroll_Middlewire::on('mysql_second')->create([
                "emp_id" => $req->user,
                "head_id" => $req->head,
                "amount" => $req->amount,
                "date" => $date,
            ]);

            $data = Payroll_Middlewire::on('mysql_second')->with('Employee','Head')->findOrFail($insert->id);

            return response()->json([
                'status'=> true,
                'message' => 'Payroll Middlewire Added Successfully',
                "data" => $data,
            ], 200);
        }
    } // End Method



    // Edit Payroll Middlewire
    public function Edit(Request $req){
        $payroll = Payroll_Middlewire::on('mysql_second')->with('Employee', 'Head')->where('id',$req->id)->findOrFail($req->id);
        $tranwith = Transaction_With::on('mysql_second')->where('user_role', 3)->get();
        $heads = Transaction_Head::on('mysql_second')->where('groupe_id','1')->get();
        return response()->json([
            'status'=> true,
            'payroll'=>$payroll,
            'tranwith'=>$tranwith,
            'heads'=>$heads,
        ], 200);
    } // End Method



    // Update Payroll Middlewire
    public function Update(Request $req){
        $currentYear = $req->year;
        $currentMonth = $req->month;

        $req->validate([
            "user" => 'required|exists:mysql_second.employee__personal__details,employee_id',
            "head" => 'required|exists:mysql_second.transaction__heads,id',
            "amount" => 'required|numeric',
        ]);


        // Check If the Salary Component is Already Added or Not
        $middlewire = Payroll_Middlewire::on('mysql_second')->where('emp_id', $req->user)
                    ->where('head_id', $req->head)
                    ->where(function ($query) use ($currentYear, $currentMonth) {
                        $query->whereYear('date', $currentYear)
                            ->whereMonth('date', $currentMonth)
                            ->orWhereNull('date');
                    })
                    ->where('id', '!=', $req->id)
                    ->count();

        $setup = Payroll_Setup::on('mysql_second')->where('emp_id', $req->user)
                    ->where('head_id', $req->head)
                    ->count();

        // If the Salary Component is Already Added Send Error Message
        if($middlewire > 0 || $setup > 0){
            return response()->json([
                'errors' => [
                    'head' => ["You have already added this salary component for this user."]
                ]
            ], 422);
        }
        else{
            $update = Payroll_Middlewire::on('mysql_second')->findOrFail($req->id)->update([
                "emp_id" => $req->user,
                "head_id" => $req->head,
                "amount" => $req->amount,
                "date" => $req->date,
            ]);

            $updatedData = Payroll_Middlewire::on('mysql_second')->with('Employee','Head')->findOrFail($req->id);
    
            if($update){
                return response()->json([
                    'status'=>true,
                    'message' => 'Payroll Middlewire Updated Successfully',
                    "updatedData" => $updatedData,
                ], 200); 
            }
        }
    } // End Method



    // Delete Payroll Middlewire
    public function Delete(Request $req){
        Payroll_Middlewire::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Payroll Middlewire Deleted Successfully',
        ], 200); 
    } // End Method



    // Delete Payroll Middlewire Status
    public function DeleteStatus(Request $req){
        $data = Payroll_Middlewire::on('mysql_second')->findOrFail($req->id);
        $data->update(['status' => $data->status == 0 ? 1 : 0]);
        
        $updatedData = Payroll_Middlewire::on('mysql_second')->with('Employee','Head')->findOrFail($req->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Payroll Middlewire Deleted Successfully',
            'updatedData' => $updatedData
        ], 200);
    } // End Method



    // Search Payroll Middlewire
    public function Search(Request $req){
        $currentYear = $req->year;
        $currentMonth = $req->month;
        // $payroll = Payroll_Middlewire::on('mysql_second')->with('Employee', 'Head')
        // ->whereHas($req->searchOption == 1 ? 'Employee' : 'Head', function ($query) use ($req) {
        //     $query->where($req->searchOption == 1 ? 'user_name' : 'tran_head_name', 'like', '%'.$req->search.'%');
        //     $query->orderby($req->searchOption == 1 ? 'user_name' : 'tran_head_name');
        // })
        // ->whereYear('date', $currentYear)
        // ->whereMonth('date', $currentMonth)
        // ->orWhereNull('date')
        // ->paginate(15);


        if($req->searchOption == 1){
            $payroll = Payroll_Middlewire::on('mysql_second')
            ->with('Employee', 'Head')
            ->whereHas('Employee', function ($query) use ($req) {
                $query->where('user_name', 'like', '%'.$req->search.'%');
                $query->orderby('user_name');
            })
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->orWhereNull('date')
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $head = Transaction_Head::on('mysql_second')
            ->where('tran_head_name', 'like', '%'.$req->search.'%')
            ->orderby('tran_head_name')
            ->pluck('id');

            $payroll = Payroll_Middlewire::on('mysql_second')
            ->with('Employee', 'Head')
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->whereIn('head_id', $head)
            ->orWhereNull('date')
            ->paginate(15);
        }
        
        return response()->json([
            'status' => true,
            'data' => $payroll,
        ], 200);
    } // End Method
}
