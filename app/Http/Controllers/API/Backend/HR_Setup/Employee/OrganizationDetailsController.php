<?php

namespace App\Http\Controllers\API\Backend\HR_Setup\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User_Info;
use App\Models\Transaction_With;
use App\Models\Employee_Organization_Detail;

class OrganizationDetailsController extends Controller
{
    // Show All Employee Organization Details
    public function ShowAll(Request $req){
        $employee = User_Info::with('Withs','Location','organizationDetail')->where('user_role', 6)->orderBy('added_at','asc')->paginate(15);
        $tranwith = Transaction_With::where('user_role', 6)->get();
        return response()->json([
            'status'=> true,
            'data' => $employee,
            'tranwith' => $tranwith,
        ], 200);
    } // End Method



    // Insert Employee Organization Details
    public function Insert(Request $req){
        $req->validate([
            'user' => 'required',
            'joining_date' => 'required',
            'location' => 'required',
            'department' => 'required',
            'designation' => 'required',
        ]);

        
        Employee_Organization_Detail::insert([
            'emp_id' =>  $req->user,
            "joining_date" => $req->joining_date,
            "joining_location" =>  $req->location,
            "department" => $req->department,
            "designation" => $req->designation,
        ]);
        
        return response()->json([
            'status'=> true,
            'message' => 'Employee Organization Details Added Successfully'
        ], 200);  
    } // End Method



    // Edit Employee Organization Details
    public function Edit(Request $req){
        $employee = Employee_Organization_Detail::with('Department','Designation','Location')->where('id', $req->id)->first();
        $tranwith = Transaction_With::where('user_role', 6)->get();
        return response()->json([
            'status'=> true,
            'employee'=>$employee,
            'tranwith'=>$tranwith,
        ], 200);
    } // End Method



    // Update Employee Organization Details
    public function Update(Request $req){
        $req->validate([
            'joining_date' => 'required',
            'location' => 'required',
            'department' => 'required',
            'designation' => 'required',
        ]);

        $employee = Employee_Organization_Detail::where('emp_id', $req->emp_id)->first();
        
        $update = Employee_Organization_Detail::findOrFail($req->id)->update([
            "joining_date" => $req->joining_date,
            "joining_location" =>  $req->location,
            "department" => $req->department,
            "designation" => $req->designation,
            'updated_at' => now()
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Employee Organization Details Updated Successfully',
            ], 200); 
        }
    } // End Method



    // Delete Employee Organization Details
    public function Delete(Request $req){
        Employee_Organization_Detail::findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Employee Organization Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Employee Organization Details
    public function Search(Request $req){
        $query = User_Info::with('Withs','Location')->where('user_role', 6); // Base query

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

                case 7: // case 7
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
}
