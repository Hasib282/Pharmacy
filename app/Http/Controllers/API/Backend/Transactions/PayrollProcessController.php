<?php

namespace App\Http\Controllers\API\Backend\Transactions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\User_Info; 
use App\Models\Transaction_With;
use App\Models\Transaction_Main; 
use App\Models\Transaction_Detail; 
use App\Models\Payroll_Setup; 
use App\Models\Payroll_Middlewire;
use App\Models\Transaction_Head;

class PayrollProcessController extends Controller
{
    // Show All Payroll Process
    public function Show(Request $req){
        $currentYear = Carbon::now()->year; 
        $currentMonth = Carbon::now()->month;
        $data = Payroll_Setup::on('mysql_second')->with('Employee')
        ->select('emp_id', 'amount', \DB::raw('NULL as date'))
        ->unionall(
            Payroll_Middlewire::on('mysql_second')->select('emp_id', 'amount', 'date')
                ->whereYear('date', $currentYear)
                ->whereMonth('date', $currentMonth)
                ->orWhereNull('date')
        )
        ->orderBy('emp_id')
        ->get()
        ->groupBy('emp_id')
        ->map(function ($group) {
            return [
                'emp_id' => $group->first()->emp_id,
                'emp_name' => $group->first()->employee->user_name,
                'salary' => $group->sum('amount')
            ];
        })
        ->values();
        
        $tranwith = Transaction_With::on('mysql_second')->where('user_role', 3)->get();

        return response()->json([
            'status'=> true,
            'data' => $data,
            'tranwith' => $tranwith,
        ], 200);
    } // End Method



    // Insert Payroll Process
    public function Insert(Request $req){
        $employees = User_Info::on('mysql_second')->select('user_id','user_name','tran_user_type')->where('user_role', 3)->orderBy('added_at','asc')->get();

        if(!$employees->isEmpty()){
            $currentYear = Carbon::now()->year; 
            $currentMonth = Carbon::now()->month;

            Transaction_Main::on('mysql_second')
            ->where('tran_type', '3')
            ->where(function ($query) use ($currentYear, $currentMonth) {
                $query->whereYear('tran_date', $currentYear)
                    ->whereMonth('tran_date', $currentMonth)
                    ->orWhereNull('tran_date');
            })
            ->delete();

            Transaction_Detail::on('mysql_second')
            ->where('tran_type', '3')
            ->where(function ($query) use ($currentYear, $currentMonth) {
                $query->whereYear('tran_date', $currentYear)
                    ->whereMonth('tran_date', $currentMonth)
                    ->orWhereNull('tran_date');
            })
            ->delete();

            foreach ($employees as $employee) {
                
                $payrolls = Payroll_Setup::on('mysql_second')->select('emp_id','head_id','amount',\DB::raw('0 as date'))
                ->where('emp_id', $employee->user_id)
                ->unionall(
                    Payroll_Middlewire::on('mysql_second')->select('emp_id','head_id','amount','date')
                    ->where('emp_id', $employee->user_id)
                    ->where(function ($query) use ($currentYear, $currentMonth) {
                        $query->whereYear('date', $currentYear)
                            ->whereMonth('date', $currentMonth)
                            ->orWhereNull('date');
                    })
                )
                ->orderBy('emp_id')
                ->get();

                $transaction = Transaction_Main::on('mysql_second')->where('tran_type', '3')->latest('tran_id')->first();
                $id = ($transaction) ? 'PRP' . str_pad((intval(substr($transaction->tran_id, 3)) + 1), 9, '0', STR_PAD_LEFT) : 'PRP000000001';
                
                if($payrolls->count() > 0){
                    $salary = 0;
                    $transactionDetails = [];
                    
                    foreach ($payrolls as $payroll) {
                        $salary += $payroll->amount; 
                        
                        $transactionDetails[] = [
                            'tran_id'=>$id,
                            'tran_type'=> '3',
                            'tran_method'=> 'Payment',
                            'tran_type_with'=> $employee->tran_user_type,
                            'tran_user'=> $employee->user_id,
                            'tran_groupe_id'=> '1',
                            'tran_head_id'=> $payroll->head_id,
                            'quantity'=> '1',
                            'amount'=> $payroll->amount,
                            'tot_amount'=> $payroll->amount,
                            'payment'=> $payroll->amount,
                        ];
                    }


                    Transaction_Detail::on('mysql_second')->create($transactionDetails);


                    Transaction_Main::on('mysql_second')->create([
                        'tran_id'=>$id,
                        'tran_type'=> '3',
                        'tran_method'=> 'Payment',
                        'tran_type_with'=> $employee->tran_user_type,
                        'tran_user'=> $employee->user_id,
                        'bill_amount'=> $salary,
                        'discount'=> 0,
                        'net_amount'=> $salary,
                        'payment'=> $salary,
                        'due'=> 0,
                    ]);
                }
            }
            
            return response()->json([
                'status'=> true,
                'message' => 'Payroll Processed Successfully'
            ], 200);
        }
        else {
            return response()->json([
                'status' => false,
                'message' => 'Enter Employee Details First',
            ]);
        }
    } // End Method



    // Edit Payroll Process
    public function Edit(Request $req){
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $payrolls = Payroll_Setup::on('mysql_second')->with('Employee')->select(
            'emp_id',
            'head_id',
            'amount',
            \DB::raw('0 as date'),
        )
        ->where('emp_id', $req->id)
        ->union(
            Payroll_Middlewire::on('mysql_second')->select(
                'emp_id',
                'head_id',
                'amount',
                'date',
            )
            ->where('emp_id', $req->id)
            ->where(function ($query) use ($currentYear, $currentMonth) {
                $query->whereYear('date', $currentYear)
                    ->whereMonth('date', $currentMonth)
                    ->orWhereNull('date');
            })
        )
        ->orderBy('emp_id')
        ->get();
        
        $heads = Transaction_Head::on('mysql')->where('groupe_id','1')->get();
        return response()->json([
            'status'=> 'success',
            'data'=> view('hr.payroll.details',compact('payrolls'))->render(),
            'payrolls'=> $payrolls,
            'heads' => $heads
        ]);
    } // End Method



    // // Update Payroll Process
    // public function Update(Request $req){
    //     $req->validate([
    //         "division" => 'required',
    //         "district"  => 'required',
    //         "upazila"  => 'required',
    //     ]);

    //     $update = Location_Info::findOrFail($req->id)->update([
    //         "district" => $req->district,
    //         "division" => $req->division,
    //         "upazila" => $req->upazila,
    //         "updated_at" => now()
    //     ]);

    //     $updatedData = Location_Info::findOrFail($req->id);
    
    //     if($update){
    //         return response()->json([
    //             'status'=>true,
    //             'message' => 'Location Updated Successfully',
    //             "updatedData" => $updatedData,
    //         ], 200); 
    //     }
    // } // End Method



    // // Delete Payroll Process
    // public function Delete(Request $req){
    //     Location_Info::findOrFail($req->id)->delete();
    //     return response()->json([
    //         'status'=> true,
    //         'message' => 'Location Deleted Successfully',
    //     ], 200); 
    // } // End Method



    // Search Payroll Process
    public function Search(Request $req){
        $currentYear = $req->year;
        $currentMonth = $req->month;
        $payroll = Payroll_Setup::on('mysql_second')->with('Employee')
        ->whereHas('Employee', function ($query) use ($req) {
            $query->where('user_name', 'like', '%'.$req->search.'%');
            $query->orWhere('user_id', 'like', '%'.$req->search.'%');
        })
        ->select('emp_id', 'amount', \DB::raw('NULL as date')) 
        ->unionall(
            Payroll_Middlewire::on('mysql_second')->select('emp_id', 'amount', 'date')
                ->whereYear('date', $currentYear)
                ->whereMonth('date', $currentMonth)
                ->orWhereNull('date')
        )
        ->orderBy('emp_id')
        ->get()
        ->groupBy('emp_id')
        ->map(function ($group) {
            return [
                'emp_id' => $group->first()->emp_id,
                'emp_name' => $group->first()->employee->user_name,
                'salary' => $group->sum('amount')
            ];
        })
        ->values();
        
        return response()->json([
            'status' => true,
            'data' => $payroll,
        ], 200);
    } // End Method



    // Get Payroll By User Id
    public function Get(Request $req){
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $payrolls = Payroll_Setup::on('mysql_second')->with('Head')
        ->select(
            'emp_id',
            'head_id',
            'amount',
            \DB::raw('0 as date'),
        )
        ->where('emp_id', $req->id)
        ->union(
            Payroll_Middlewire::on('mysql_second')->with('Head')
            ->select(
                'emp_id',
                'head_id',
                'amount',
                'date',
            )
            ->where('emp_id', $req->id)
            ->where(function ($query) use ($currentYear, $currentMonth) {
                $query->whereYear('date', $currentYear)
                    ->whereMonth('date', $currentMonth)
                    ->orWhereNull('date');
            })
        )
        ->orderBy('head_id')
        ->get();
        
        return response()->json([
            'status'=> true,
            'data'=> $payrolls,
        ]);
    } // End Method 




    // // Get Payroll By User And Date
    // public function GetByDate(Request $req){
    //     $currentYear = $req->year;
    //     $currentMonth = $req->month;
    //     $payrolls = Payroll_Setup::on('mysql_second')->with('Employee')->select(
    //         'emp_id',
    //         'head_id',
    //         'amount',
    //         \DB::raw('0 as date'),
    //     )
    //     ->where('emp_id', $req->id)
    //     ->union(
    //         Payroll_Middlewire::on('mysql_second')->select(
    //             'emp_id',
    //             'head_id',
    //             'amount',
    //             'date',
    //         )
    //         ->where('emp_id', $req->id)
    //         ->where(function ($query) use ($currentYear, $currentMonth) {
    //             $query->whereYear('date', $currentYear)
    //                 ->whereMonth('date', $currentMonth)
    //                 ->orWhereNull('date');
    //         })
    //     )
    //     ->orderBy('emp_id')
    //     ->get();
        
    //     $heads = Transaction_Head::on('mysql')->where('groupe_id','1')->get();
    //     return response()->json([
    //         'status'=> 'success',
    //         'data'=> view('hr.payroll.details',compact('payrolls'))->render(),
    //         'payrolls'=> $payrolls,
    //         'heads' => $heads
    //     ]);
    // } // End Method
}
