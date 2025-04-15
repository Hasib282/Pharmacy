<?php

namespace App\Http\Controllers\API\Backend\Users\Employee;

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
        $data = User_Info::on('mysql_second')->with('Withs','Location')->where('user_role', 3)->orderBy('added_at','asc')->paginate(15);
        $tranwith = Transaction_With::on('mysql_second')->where('user_role', 3)->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
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
                    $locations = Location_Info::on('mysql')
                    ->where('upazila', 'like', $req->search.'%')
                    ->orderBy('upazila')
                    ->pluck('id');

                    $query->whereIn('loc_id', $locations);
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

        $data = $query->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Show Employee Details
    public function Details(Request $req){
        $education = $training = $experience = $organization = null;
        // Check the value of the 4th segment
        $segment = $req->segment(4);

        // Load data based on the segment value
        if ($segment === 'all' || $segment === 'education') {
            $education = Employee_Education_Detail::where('emp_id', $req->id)->orderBy('created_at', 'asc')->get();
        }
        if ($segment === 'all' || $segment === 'training') {
            $training = Employee_Training_Detail::where('emp_id', $req->id)->orderBy('created_at', 'asc')->get();
        }
        if ($segment === 'all' || $segment === 'experience') {
            $experience = Employee_Experience_Detail::where('emp_id', $req->id)->orderBy('created_at', 'asc')->get();
        }
        if ($segment === 'all' || $segment === 'organization') {
            $organization = Employee_Organization_Detail::where('emp_id', $req->id)->get();
        }

        // Fetch additional details
        $personaldetail = Employee_Personal_Detail::where('employee_id', $req->id)->get();
        $payroll = Payroll_Setup::with('Head', 'Employee')->where('emp_id', $req->id)->get();
        
        return response()->json([
            'status' => true,
            'data' => view('common_modals.employeeDetails', compact('personaldetail', 'education', 'training', 'experience', 'organization', 'payroll'))->render(),
        ]);
    } // End Method
}
