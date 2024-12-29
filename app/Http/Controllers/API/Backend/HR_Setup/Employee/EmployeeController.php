<?php

namespace App\Http\Controllers\API\Backend\HR_Setup\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User_Info;
use App\Models\Payroll_Setup;
use App\Models\Transaction_With;
use App\Models\Employee_Personal_Detail;
use App\Models\Employee_Training_Detail;
use App\Models\Employee_Education_Detail;
use App\Models\Employee_Experience_Detail;
use App\Models\Employee_Organization_Detail;

class EmployeeController extends Controller
{
    // Show All Employee Details
    public function ShowAll(Request $req){
        $employee = User_Info::on('mysql_second')->with('Withs','Location')->where('user_role', 3)->orderBy('added_at','asc')->paginate(15);
        $tranwith = Transaction_With::on('mysql_second')->where('user_role', 3)->get();
        return response()->json([
            'status'=> true,
            'data' => $employee,
            'tranwith' => $tranwith,
        ], 200);
    } // End Method



    // // Insert Employee Details
    // public function Insert(Request $req){
    //     $req->validate([
    //         "division" => 'required',
    //         "district" => 'required',
    //         "upazila" => 'required',
    //     ]);

    //     $insert = Location_Info::insert([
    //         "division" => $req->division,
    //         "district" => $req->district,
    //         "upazila" => $req->upazila,
    //     ]);
        
    //     return response()->json([
    //         'status'=> true,
    //         'message' => 'Employee Details Added Successfully'
    //     ], 200);  
    // } // End Method



    // // Edit Employee Details
    // public function Edit(Request $req){
    //     $location = Location_Info::findOrFail($req->id);
    //     return response()->json([
    //         'status'=> true,
    //         'location'=> $location,
    //     ], 200);
    // } // End Method



    // // Update Employee Details
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

    //     if($update){
    //         return response()->json([
    //             'status'=>true,
    //             'message' => 'Employee Details Updated Successfully',
    //         ], 200); 
    //     }
    // } // End Method



    // Delete Employee Details
    public function Delete(Request $req){
        User_Info::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Employee Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Employee Details
    public function Search(Request $req){
        $query = User_Info::on('mysql_second')->with('Withs','Location')->where('user_role', 3); // Base query

        if ($req->filled('search') && $req->searchOption) {
            switch ($req->searchOption) {
                case 1: // Search By Employee Name Or Id
                    $query->where('user_name', 'like', '%' . $req->search . '%')
                        ->orWhere('id', 'like', '%' . $req->search . '%')
                        ->orderBy('user_name');
                    break;

                case 2: // Search By Email
                    $query->where('user_email', 'like', '%' . $req->search . '%')
                        ->orderBy('user_email');
                    break;

                case 3: // Search By Phone
                    $query->where('user_phone', 'like', '%' . $req->search . '%')
                        ->orderBy('user_phone');
                    break;

                case 4: // Search By Location
                    $query->whereHas('Location', function ($q) use ($req) {
                            $q->where('upazila', 'like', '%' . $req->search . '%');
                            $q->orderBy('upazila');
                        });
                    break;

                case 5: // Search By Address
                    $query->where('address', 'like', '%' . $req->search . '%')
                        ->orderBy('address');
                    break;

                case 6: // Search By Date Of Birth
                    $query->where('dob', 'like', '%' . $req->search . '%')
                        ->orderBy('dob');
                    break;

                case 7: // Search By NID
                    $query->where('nid', 'like', '%' . $req->search . '%')
                        ->orderBy('nid');
                    break;

                case 8: // Search By Employee Type
                    $query->whereHas('Withs', function ($q) use ($req) {
                            $q->where('tran_with_name', 'like', '%' . $req->search . '%');
                            $q->orderBy('tran_with_name');
                        });
                    break;
            }
        }

        $employee = $query->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $employee,
        ], 200);
    } // End Method



    // Show Employee Details
    public function Details(Request $req){
        $employee = User_Info::with('Designation','Department','Location','Withs','personalDetail','educationDetail','trainingDetail','experienceDetail','organizationDetail')->where('user_id', "=", $req->id)->first();
        $education = Employee_Education_Detail::where('emp_id', $req->id)->orderBy('created_at','asc')->get();
        $training = Employee_Training_Detail::where('emp_id', $req->id)->orderBy('created_at','asc')->get();
        $experience = Employee_Experience_Detail::where('emp_id', $req->id)->orderBy('created_at','asc')->get();
        $payroll = Payroll_Setup::with('Head','Employee')->where('emp_id', $employee->user_id)->get();
        
        return response()->json([
            'status' => true,
            'data'=>view('hr.employee_info.employees.details', compact('employee','education','training','experience','payroll'))->render(),
        ]);
    } // End Method
}
