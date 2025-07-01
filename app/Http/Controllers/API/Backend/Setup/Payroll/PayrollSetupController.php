<?php

namespace App\Http\Controllers\API\Backend\Setup\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transaction_With; 
use App\Models\Transaction_Head; 
use App\Models\Payroll_Setup;

class PayrollSetupController extends Controller
{
    // Show All Payroll Setup
    public function Show(Request $req){
        $data = Payroll_Setup::on('mysql_second')->with('Employee','Head')->orderBy('emp_id','asc')->get();
        $tranwith = Transaction_With::on('mysql_second')->where('user_role', 3)->get();
        $heads = Transaction_Head::on('mysql')->where('groupe_id','1')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
            'tranwith' => $tranwith,
            'heads' => $heads,
        ], 200);
    } // End Method



    // Insert Payroll Setup
    public function Insert(Request $req){
        $req->validate([
            "user" => 'required|exists:mysql_second.employee__personal__details,employee_id',
            "head" => 'required|exists:mysql.transaction__heads,id',
            "amount" => 'required|numeric',
        ]);

        // Check If the Salary Component is Already Added or Not
        $payroll = Payroll_Setup::on('mysql_second')->where('emp_id', $req->user)
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
            $insert = Payroll_Setup::on('mysql_second')->create([
                "emp_id" => $req->user,
                "head_id" => $req->head,
                "amount" => $req->amount,
            ]);

            $data = Payroll_Setup::on('mysql_second')->with('Employee','Head')->findOrFail($insert->id);
    
            return response()->json([
                'status'=> true,
                'message' => 'Payroll Setup Added Successfully',
                "data" => $data,
            ], 200);  
        }
    } // End Method



    // Edit Payroll Setup
    public function Edit(Request $req){
        $payroll = Payroll_Setup::on('mysql_second')->with('Employee')->where('id',$req->id)->findOrFail($req->id);
        $tranwith = Transaction_With::on('mysql_second')->where('user_role', 3)->get();
        $heads = Transaction_Head::on('mysql')->where('groupe_id','1')->get();
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
            "user" => 'required|exists:mysql_second.employee__personal__details,employee_id',
            "head" => 'required|exists:mysql.transaction__heads,id',
            "amount" => 'required|numeric',
        ]);

        // Check If the Salary Component is Already Added or Not
        $payroll = Payroll_Setup::on('mysql_second')->where('emp_id', $req->user)
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
            $update = Payroll_Setup::on('mysql_second')->findOrFail($req->id)->update([
                "emp_id" => $req->user,
                "head_id" => $req->head,
                "amount" => $req->amount,
            ]);

            $updatedData = Payroll_Setup::on('mysql_second')->with('Employee','Head')->findOrFail($req->id);

            if($update){
                return response()->json([
                    'status'=>true,
                    'message' => 'Payroll Setup Updated Successfully',
                    "updatedData" => $updatedData,
                ], 200); 
            }
        }
    } // End Method



    // Delete Payroll Setup
    public function Delete(Request $req){
        Payroll_Setup::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Payroll Setup Deleted Successfully',
        ], 200); 
    } // End Method



    // Delete Payroll Setup Status
    public function DeleteStatus(Request $req){
        $data = Payroll_Setup::on('mysql_second')->findOrFail($req->id);
        $data->update(['status' => $data->status == 0 ? 1 : 0]);
        
        $updatedData = Payroll_Setup::on('mysql_second')->with('Employee','Head')->findOrFail($req->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Payroll Setup Deleted Successfully',
            'updatedData' => $updatedData
        ], 200);
    } // End Method



    // Search Payroll Setup
    public function Search(Request $req){
        if($req->searchOption == 1){
            $payroll = Payroll_Setup::on('mysql_second')
            ->with('Employee','Head')
            ->whereHas('Employee', function ($query) use ($req) {
                $query->where('user_name', 'like', '%'.$req->search.'%');
                $query->orderby('user_name');
            })
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $head = Transaction_Head::on('mysql')
            ->where('tran_head_name', 'like', '%'.$req->search.'%')
            ->orderby('tran_head_name')
            ->pluck('id');

            $payroll = Payroll_Setup::on('mysql_second')
            ->with('Employee','Head')
            ->whereIn('head_id', $head)
            ->paginate(15);
        }
        
        
        return response()->json([
            'status' => true,
            'data' => $payroll,
        ], 200);
    } // End Method



    // Get Payroll Category
    public function Get(){
        $data = Transaction_Head::on('mysql')->where('groupe_id','1')->select('id','tran_head_name')->get();
        return response()->json([
            'status' => true,
            'data'=> $data,
        ],200);
    } // End Method
}
