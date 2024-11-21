<?php

namespace App\Http\Controllers\API\Backend\HR_Setup\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Models\User_Info;
use App\Models\Transaction_With;
use App\Models\Employee_Personal_Detail;

class PersonalDetailsController extends Controller
{
    // Show All Employee Personal Details
    public function ShowAll(Request $req){
        $employee = User_Info::with('Withs','Location')->where('user_role', 6)->orderBy('added_at','asc')->paginate(15);
        $tranwith = Transaction_With::where('user_role', 6)->get();
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
            'fathers_name' => 'nullable',
            'mothers_name' => 'nullable',
            'date_of_birth' => 'required',
            'gender' => 'required|in:Male,Female,Others',
            'religion' => 'required|in:Islam,Hinduism,Christianity,Buddhism,Judaism',
            'marital_status' => 'required|in:Married,Unmarried',
            'nationality' => 'nullable',
            'nid_no' => 'nullable|numeric',
            'phn_no' =>  'required|numeric|unique:user__infos,user_phone,phone',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
            'email' => 'required|email|unique:user__infos,user_email,email',
            'location'  => 'required',
            'type'=> 'required',
            'password' => 'required|confirmed',
            'address' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
 
        
        DB::transaction(function () use ($req) {
            $NewEmployee = Employee_Personal_Detail::orderBy('employee_id','desc')->first();
            $id = ($NewEmployee) ? 'E' . str_pad((intval(substr($NewEmployee->employee_id, 1)) + 1), 9, '0', STR_PAD_LEFT) : 'E000000101';
    
            if ($req->hasFile('image') && $req->file('image')->isValid()) {
                $originalName = $req->file('image')->getClientOriginalName();
                $imageName = $id. '('. $req->name . ').' . $req->file('image')->getClientOriginalExtension();
                // dd($imageName);
                $imagePath = $req->file('image')->storeAs('profiles', $imageName);
                \Log::info("Image stored at: $imagePath");
            }
            else{
                $imageName = null;
            }

            // Insert Employee Personal Details
            Employee_Personal_Detail::insert([
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
    
            // Insert Info to User__Info 
            User_Info::insert([
                "user_id" => $id,
                "user_name" => $req->name,
                "user_email" => $req->email,
                "user_phone" => $req->phn_no,
                "gender" => $req->gender,
                "loc_id" => $req->location,
                "user_role" => 6,
                "tran_user_type" => $req->type,
                "dob" => $req->date_of_birth,
                "nid" => $req->nid_no,
                "password" => Hash::make($req->password),
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
        $employee = Employee_Personal_Detail::with('Location')->where('employee_id', $req->id)->first();
        $tranwith = Transaction_With::where('user_role', 6)->get();
        return response()->json([
            'status'=> true,
            'employee'=>$employee,
            'tranwith'=>$tranwith,
        ], 200);
    } // End Method



    // Update Employee Personal Details
    public function Update(Request $req){
        $req->validate([
            'name' => 'required',
            'fathers_name' => 'nullable',
            'mothers_name' => 'nullable',
            'date_of_birth' => 'required',
            'gender' => 'required|in:Male,Female,Others',
            'religion' => 'required',
            'marital_status' => 'required',
            'nationality' => 'nullable',
            'nid_no' => 'nullable|numeric',
            'phn_no' =>  'required|numeric',
            'blood_group' => 'nullable',
            'email' => 'required|email',
            'location'  => 'required',
            'type'=> 'required',
            // 'password' => 'required',
            // 'confirm_password' => 'required|same:password',
            'address' => 'required',
            
        ]);

        DB::transaction(function () use ($req) {
            $employee = Employee_Personal_Detail::where('employee_id', $req->employee_id)->first();
            $path = 'public/profiles/'.$employee->image;
            
            if($req->image != null){
                $req->validate([
                    "image" => 'image|mimes:jpg,jpeg,png,gif|max:2048',
                ]);

                //process the image name and store it to storage/app/public/profiles directory
                if ($req->hasFile('image') && $req->file('image')->isValid()) {
                    Storage::delete($path);
                    $imageName = $req->employee_id. '('. $req->name . ').' . $req->file('image')->getClientOriginalExtension();
                    $imagePath = $req->file('image')->storeAs('profiles', $imageName);
                }
            }
            else{
                $imageName = $employee->image;
            }

            $update1 = Employee_Personal_Detail::findOrFail($req->id)->update([
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
                // "password" => $req->password,
                // "confirm_password" => $req->confirm_password,
                "updated_at" => now()
            ]);
        
            $update2 = User_Info::where('user_id', $req->employee_id)->update([
                "user_name" => $req->name,
                "user_email" => $req->email,
                "user_phone" => $req->phn_no,
                "gender" => $req->gender,
                "loc_id" => $req->location,
                "user_role" => 6,
                "tran_user_type" => $req->type,
                "dob" => $req->date_of_birth,
                "nid" => $req->nid_no,
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
        User_Info::findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Employee Personal Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Employee Personal Details
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
