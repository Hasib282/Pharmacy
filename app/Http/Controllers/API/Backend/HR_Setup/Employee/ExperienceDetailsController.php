<?php

namespace App\Http\Controllers\API\Backend\HR_Setup\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User_Info;
use App\Models\Transaction_With;
use App\Models\Employee_Experience_Detail;
use App\Models\Employee_Personal_Detail;

class ExperienceDetailsController extends Controller
{
    // Show All Employee Experience Details
    public function ShowAll(Request $req){
        $employee = User_Info::on('mysql_second')->with('Withs','Location')->where('user_role', 3)->orderBy('added_at','asc')->paginate(15);
        $tranwith = Transaction_With::on('mysql_second')->where('user_role', 3)->get();
        return response()->json([
            'status'=> true,
            'data' => $employee,
            'tranwith' => $tranwith,
        ], 200);
    } // End Method



    // Insert Employee Experience Details
    public function Insert(Request $req){
        $req->validate([
            'user' => 'required',
            'company_name.*' => 'required',
            'designation.*' => 'required',
            'department.*' => 'required',
            'company_location.*' => 'required',
            'start_date.*' => 'nullable',
            'end_date.*' => 'nullable|after:start_date.*',
            
        ],
        [
            'company_name.*.required' => 'This field is required',
            'designation.*.required' => 'This field is required',
            'department.*.required' => 'This field is required',
            'company_location.*.required' => 'This field is required',
            'start_date.*.required' => 'This field is required',
            'end_date.*.required' => 'This field is required',
        ]);


        $experienceDetails = [];
        foreach ($req->company_name as $key => $value) {
            $experienceDetails[] = [
                'emp_id' =>  $req->user,
                "company_name" => $req->company_name[$key],
                "designation" =>  $req->designation[$key],
                "department" => $req->department[$key],
                "company_location" => $req->company_location[$key],
                "start_date" => $req->start_date[$key] ?? null,
                "end_date" => $req->end_date[$key] ?? null,
            ];
        }

        Employee_Experience_Detail::on('mysql_second')->insert($experienceDetails);
        
        return response()->json([
            'status'=> true,
            'message' => 'Employee Experience Details Added Successfully'
        ], 200);  
    } // End Method



    // Edit Employee Experience Details
    public function Edit(Request $req){
        $employee = Employee_Experience_Detail::on('mysql_second')->where('id', $req->id)->first();
        $tranwith = Transaction_With::on('mysql_second')->where('user_role', 3)->get();
        return response()->json([
            'status'=> true,
            'employee'=>$employee,
            'tranwith'=>$tranwith,
        ], 200);
    } // End Method



    // Update Employee Experience Details
    public function Update(Request $req){
        $req->validate([
            'company_name' => 'required',
            'designation' => 'required',
            'department' => 'required',
            'company_location' => 'required',
            'start_date' => 'nullable',
            'end_date' => 'nullable|after:start_date',
        ]);

        $employee = Employee_Experience_Detail::on('mysql_second')->findOrFail($req->id);
        

        $update = Employee_Experience_Detail::on('mysql_second')->findOrFail($req->id)->update([
            "company_name" => $req->company_name,
            "designation" =>  $req->designation,
            "department" => $req->department,
            "company_location" => $req->company_location,
            "start_date" => $req->start_date,
            "end_date" => $req->end_date,
            'updated_at' => now()
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Employee Experience Details Updated Successfully',
            ], 200); 
        }
    } // End Method



    // Delete Employee Experience Details
    public function Delete(Request $req){
        Employee_Experience_Detail::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Employee Experience Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Employee Experience Details
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
    


    // Show Employee Experience Grid
    public function Grid(Request $req){
        $employeeexperience = Employee_Experience_Detail::with('personalDetail')->where('emp_id', $req->id)->paginate(15);
        
        return response()->json([
            'status' => true,
            'data'=>view('hr.employee_info.experience_details.grid', compact('employeeexperience'))->render(),
        ]);
    } // End Method
}
