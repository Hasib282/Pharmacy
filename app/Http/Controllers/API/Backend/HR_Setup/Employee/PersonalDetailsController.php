<?php

namespace App\Http\Controllers\API\Backend\HR_Setup\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Models\Login_User;
use App\Models\User_Info;
use App\Models\Location_Info;
use App\Models\Transaction_With;
use App\Models\Employee_Personal_Detail;

class PersonalDetailsController extends Controller
{
    // Show All Employee Personal Details
    public function ShowAll(Request $req){
        $employee = User_Info::on('mysql_second')->with('Withs','Location')->where('user_role', 3)->orderBy('added_at','asc')->paginate(15);
        $tranwith = Transaction_With::on('mysql_second')->where('user_role', 3)->get();
        return response()->json([
            'status'=> true,
            'data' => $employee,
            'tranwith' => $tranwith,
        ], 200);
    } // End Method



    // Insert Employee Personal Details
    public function Insert(Request $req){
        $req->validate([
            'name' => 'required',
            'gender' => 'in:Male,Female,Others',
            'religion' => 'in:Islam,Hinduism,Christianity,Buddhism,Judaism',
            'marital_status' => 'in:Married,Unmarried',
            'nid_no' => 'numeric',
            'phn_no' =>  'required|numeric|unique:mysql_second.user__infos,user_phone',
            'blood_group' => 'in:A+,A-,B+,B-,O+,O-,AB+,AB-',
            'email' => 'required|email|unique:mysql_second.user__infos,user_email',
            'location'  => 'required',
            'type'=> 'required',
            'password' => 'required|confirmed',
            'image' => 'mimes:jpg,jpeg,png,gif|max:2048',
            'company' => 'required'
        ]);
 
        
        DB::transaction(function () use ($req) {
            $empId = GenerateLoginUserId(3, 'EM');
            $id = GenerateUserId(3, 'EM');
            $imageName = StoreUserImage($req, $id);


            Login_User::on('mysql')->insert([
                "user_id" => $empId,
                "user_name" => $req->name,
                "user_phone" => $req->phn_no,
                "user_email" => $req->email,
                "user_role" =>  3,
                "password" => Hash::make($req->password),
                "image" => $imageName,
                "company_id" =>  $req->company,
            ]);


            // Insert Info to User__Info 
            User_Info::on('mysql_second')->insert([
                "user_id" => $id,
                "login_user_id" => $empId,
                "user_name" => $req->name,
                "user_email" => $req->email,
                "user_phone" => $req->phn_no,
                "gender" => $req->gender,
                "loc_id" => $req->location,
                "user_role" => 3,
                "tran_user_type" => $req->type,
                "dob" => $req->date_of_birth,
                "nid" => $req->nid_no,
                "password" => Hash::make($req->password),
                "address" => $req->address,
                "image" => $imageName,
            ]); 

            
            // Insert Employee Personal Details
            Employee_Personal_Detail::on('mysql_second')->insert([
                'employee_id' =>  $id,
                'name' => $req->name,
                "fathers_name" => $req->fathers_name,
                "mothers_name" => $req->mothers_name,
                "date_of_birth" => $req->date_of_birth,
                "gender" => $req->gender,
                "religion" => $req->religion,
                "marital_status" => $req->marital_status,
                "nationality" => $req->nationality,
                "nid_no" => $req->nid_no,
                "phn_no" =>  $req->phn_no,
                "blood_group" => $req->blood_group,
                "email" => $req->email,
                "location_id" => $req->location,
                "tran_user_type" => $req->type,
                "address" => $req->address,
                "image" => $imageName,
            ]);
        });
        
        return response()->json([
            'status'=> true,
            'message' => 'Employee Personal Details Added Successfully'
        ], 200);  
    } // End Method



    // Edit Employee Personal Details
    public function Edit(Request $req){
        $employee = Employee_Personal_Detail::on('mysql_second')->with('Location')->where('employee_id', $req->id)->first();
        $tranwith = Transaction_With::on('mysql_second')->where('user_role', 3)->get();
        return response()->json([
            'status'=> true,
            'employee'=>$employee,
            'tranwith'=>$tranwith,
        ], 200);
    } // End Method



    // Update Employee Personal Details
    public function Update(Request $req){
        $employee = User_Info::on('mysql_second')->where('user_id', $req->employee_id)->first();
        $req->validate([
            'name' => 'required',
            'gender' => 'in:Male,Female,Others',
            'religion' => 'in:Islam,Hinduism,Christianity,Buddhism,Judaism',
            'marital_status' => 'in:Married,Unmarried',
            'nid_no' => 'numeric',
            "phn_no" => ['required','numeric',Rule::unique('mysql_second.user__infos', 'user_phone')->ignore($employee->id)],
            "email" => ['required','email',Rule::unique('mysql_second.user__infos', 'user_email')->ignore($employee->id)],
            'location'  => 'required',
            'type'=> 'required',
        ]);

        DB::transaction(function () use ($req, $employee) {
            $login_user = Login_User::on('mysql')->where('user_id', $employee->login_user_id)->first();
            // Calling UserHelper Functions
            $imageName = UpdateUserImage($req, $employee->image, $login_user->company_id, $employee->user_id);

            Login_User::on('mysql')->where('user_id', $req->employee_id)->update([
                "user_name" => $req->name,
                "user_phone" => $req->phn_no,
                "user_email" => $req->email,
                "image" => $imageName,
                "updated_at" => now()
            ]);

            
            User_Info::on('mysql_second')->where('user_id', $req->employee_id)->update([
                "user_name" => $req->name,
                "user_email" => $req->email,
                "user_phone" => $req->phn_no,
                "gender" => $req->gender,
                "loc_id" => $req->location,
                "tran_user_type" => $req->type,
                "dob" => $req->date_of_birth,
                "nid" => $req->nid_no,
                "address" => $req->address,
                "image" => $imageName,
                "updated_at" => now()
            ]);

            Employee_Personal_Detail::on('mysql_second')->findOrFail($req->id)->update([
                'name' => $req->name,
                "fathers_name" => $req->fathers_name,
                "mothers_name" => $req->mothers_name,
                "date_of_birth" => $req->date_of_birth,
                "gender" => $req->gender,
                "religion" => $req->religion,
                "marital_status" => $req->marital_status,
                "nationality" => $req->nationality,
                "nid_no" => $req->nid_no,
                "phn_no" =>  $req->phn_no,
                "blood_group" => $req->blood_group,
                "email" => $req->email,
                "location_id" => $req->location,
                "tran_user_type" => $req->type,
                "address" => $req->address,
                "image" => $imageName,
                "updated_at" => now()
            ]);
        
            
        });

        return response()->json([
            'status'=>true,
            'message' => 'Employee Personal Details Updated Successfully',
        ], 200);
    } // End Method



    // Delete Employee Personal Details
    public function Delete(Request $req){
        $employee = User_Info::on('mysql_second')->findOrFail($req->id);
        if($employee->image){
            Storage::disk('public')->delete($employee->image);
        }
        Login_User::on('mysql')->where('user_id',$employee->login_user_id)->delete();
        $employee->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Employee Personal Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Employee Personal Details
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



    // Show Employee Personal Details
    public function Details(Request $req){
        $employeepersonal = Employee_Personal_Detail::where('employee_id', $req->id)->get();
        return response()->json([
            'status' => true,
            'data'=>view('hr.employee_info.personal_details.details', compact('employeepersonal'))->render(),
        ]);
    } // End Method
}
