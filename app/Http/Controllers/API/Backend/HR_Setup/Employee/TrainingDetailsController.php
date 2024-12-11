<?php

namespace App\Http\Controllers\API\Backend\HR_Setup\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User_Info;
use App\Models\Transaction_With;
use App\Models\Employee_Training_Detail;
use App\Models\Employee_Personal_Detail;

class TrainingDetailsController extends Controller
{
    // Show All Employee Training Details
    public function ShowAll(Request $req){
        $employee = User_Info::on('mysql')->with('Withs','Location')->where('user_role', 3)->orderBy('added_at','asc')->paginate(15);
        $tranwith = Transaction_With::on('mysql')->where('user_role', 3)->get();
        return response()->json([
            'status'=> true,
            'data' => $employee,
            'tranwith' => $tranwith,
        ], 200);
    } // End Method



    // Insert Employee Training Details
    public function Insert(Request $req){
        $req->validate([
            'user' => 'required',
            'training_title' => 'required',
            'country' => 'nullable',
            'topic' => 'required',
            'institution_name' => 'required',
            'training_year' => 'required|numeric',
        ]);


        Employee_Training_Detail::on('mysql')->insert([
            'emp_id' => $req->user,
            'training_title' => $req->training_title,
            'country' => $req->country,
            'topic' => $req->topic,
            'institution_name' => $req->institution_name,
            'start_date' => $req->start_date,
            'end_date' => $req->end_date,
            'training_year' => $req->training_year,
        ]);
        
        return response()->json([
            'status'=> true,
            'message' => 'Employee Training Details Added Successfully'
        ], 200);  
    } // End Method



    // Edit Employee Training Details
    public function Edit(Request $req){
        $employee = Employee_Training_Detail::on('mysql')->where('id', $req->id)->first();
        $tranwith = Transaction_With::on('mysql')->where('user_role', 3)->get();
        return response()->json([
            'status'=> true,
            'employee'=>$employee,
            'tranwith'=>$tranwith,
        ], 200);
    } // End Method



    // Update Employee Training Details
    public function Update(Request $req){
        $req->validate([
            'training_title' => 'required',
            'country' => 'nullable',
            'topic' => 'required',
            'institution_name' => 'required',
            'training_year' => 'required|numeric',
        ]);

        $employee = Employee_Training_Detail::on('mysql')->findOrFail($req->id);
        

        $update = Employee_Training_Detail::on('mysql')->findOrFail($req->id)->update([
            'training_title' => $req->training_title,
            'country' => $req->country,
            'topic' => $req->topic,
            'institution_name' => $req->institution_name,
            'start_date' => $req->start_date,
            'end_date' => $req->end_date,
            'training_year' => $req->training_year,
            'updated_at' => now()
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Employee Training Details Updated Successfully',
            ], 200); 
        }
    } // End Method



    // Delete Employee Training Details
    public function Delete(Request $req){
        Employee_Training_Detail::on('mysql')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Employee Training Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Employee Training Details
    public function Search(Request $req){
        $query = User_Info::on('mysql')->with('Withs','Location')->where('user_role', 3); // Base query

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



    // Show Employee Training Details
    public function Details(Request $req){
        $employeetraining = Employee_Training_Detail::with('personalDetail')->where('emp_id', "=", $req->id)->get();
        $personaldetail = Employee_Personal_Detail::where('employee_id', $req->id)->get();

        return response()->json([
            'status' => true,
            'data'=>view('hr.employee_info.training_details.details', compact('employeetraining', 'personaldetail'))->render(),
        ]);
    } // End Method



    // Show Employee Training Details Grid
    public function Grid(Request $req){
        $employeetraining = Employee_Training_Detail::with('personalDetail')->where('emp_id', $req->id)->paginate(15);
        
        return response()->json([
            'status' => true,
            'data'=>view('hr.employee_info.training_details.detailsTraining', compact('employeetraining'))->render(),
        ]);
    } // End Method
}
