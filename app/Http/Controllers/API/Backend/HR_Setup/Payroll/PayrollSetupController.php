<?php

namespace App\Http\Controllers\API\Backend\HR_Setup\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transaction_With; 
use App\Models\Transaction_Head; 
use App\Models\Pay_Roll_Setup;

class PayrollSetupController extends Controller
{
    // Show All Payroll Setup
    public function ShowAll(Request $req){
        $payroll = Pay_Roll_Setup::on('mysql')->with('Employee','Head')->orderBy('emp_id','asc')->paginate(15);
        $tranwith = Transaction_With::on('mysql')->where('user_role', 3)->get();
        $heads = Transaction_Head::on('mysql_second')->where('groupe_id','1')->get();
        return response()->json([
            'status'=> true,
            'data' => $payroll,
            'tranwith' => $tranwith,
            'heads' => $heads,
        ], 200);
    } // End Method



    // Insert Payroll Setup
    public function Insert(Request $req){
        $req->validate([
            "with" => 'required',
            "user" => 'required',
            "head" => 'required',
            "amount" => 'required',
        ]);

        // Check If the Salary Component is Already Added or Not
        $payroll = Pay_Roll_Setup::on('mysql')->where('emp_id', $req->user)
                ->where('head_id', $req->head)
                ->count();

        // Check If the Salary Component is Already Added Send Error
        if($payroll > 0){
            return response()->json([
                'errors' => [
                    'head' => ["You have already added this salary component for this user."]
                ]
            ], 422);
        }
        else{
            Pay_Roll_Setup::on('mysql')->insert([
                "emp_id" => $req->user,
                "head_id" => $req->head,
                "amount" => $req->amount,
            ]);
    
            return response()->json([
                'status'=> true,
                'message' => 'Payroll Setup Added Successfully'
            ], 200);  
        }
    } // End Method



    // Edit Payroll Setup
    public function Edit(Request $req){
        $payroll = Pay_Roll_Setup::on('mysql')->with('Employee')->where('id',$req->id)->findOrFail($req->id);
        $tranwith = Transaction_With::on('mysql')->where('user_role', 3)->get();
        $heads = Transaction_Head::on('mysql_second')->where('groupe_id','1')->get();
        return response()->json([
            'status' => true,
            'payroll'=>$payroll,
            'tranwith'=>$tranwith,
            'heads'=>$heads,
        ], 200);
    } // End Method



    // Update Payroll Setup
    public function Update(Request $req){
        $req->validate([
            "with" => 'required',
            "user" => 'required',
            "head" => 'required',
            "amount" => 'required',
        ]);

        // Check If the Salary Component is Already Added or Not
        $payroll = Pay_Roll_Setup::on('mysql')->where('emp_id', $req->user)
                ->where('head_id', $req->head)
                ->where('id', '!=', $req->id)
                ->count();

        // Check If the Salary Component is Already Added Send Error
        if($payroll > 0){
            return response()->json([
                'errors' => [
                    'head' => ["You have already added this salary component for this user."]
                ]
            ], 422);
        }
        else{
            $update = Pay_Roll_Setup::on('mysql')->findOrFail($req->id)->update([
                "emp_id" => $req->user,
                "head_id" => $req->head,
                "amount" => $req->amount,
            ]);

            if($update){
                return response()->json([
                    'status'=>true,
                    'message' => 'Payroll Setup Updated Successfully',
                ], 200); 
            }
        }
    } // End Method



    // Delete Payroll Setup
    public function Delete(Request $req){
        Pay_Roll_Setup::on('mysql')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Payroll Setup Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Payroll Setup
    public function Search(Request $req){
        $payroll = Pay_Roll_Setup::on('mysql')->with('Employee','Head')
        ->whereHas($req->searchOption == 1 ? 'Employee' : 'Head', function ($query) use ($req) {
            $query->where($req->searchOption == 1 ? 'user_name' : 'tran_head_name', 'like', '%'.$req->search.'%');
            $query->orderby($req->searchOption == 1 ? 'user_name' : 'tran_head_name');
        })
        ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $payroll,
        ], 200);
    } // End Method
}
