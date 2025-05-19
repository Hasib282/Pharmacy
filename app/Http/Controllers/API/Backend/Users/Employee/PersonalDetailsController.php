<?php

namespace App\Http\Controllers\API\Backend\Users\Employee;

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
    public function Show(Request $req){
        $data = User_Info::on('mysql_second')->with('Withs','Location')->where('user_role', 3)->orderBy('added_at','asc')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Employee Personal Details
    public function Insert(Request $req){
        $req->validate([
            'name' => 'required',
            'gender' => 'in:Male,Female,Others',
            'religion' => 'in:Islam,Hinduism,Christianity,Buddhism,Judaism',
            'marital_status' => 'in:Married,Unmarried',
            'nid_no' => 'nullable|numeric',
            'phn_no' =>  'required|numeric|unique:mysql.login__users,user_phone',
            'email' => 'required|email|unique:mysql.login__users,user_email',
            'location'  => 'required|exists:mysql.location__infos,id',
            'type'=> 'required|exists:mysql_second.transaction__withs,id',
            'password' => 'required|confirmed',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif|max:2048',
            'company' => 'required|exists:mysql.company__details,company_id',
            'store' => 'required|exists:mysql_second.stores,id',
        ]);
 
        $data = null;
        
        DB::transaction(function () use ($req, &$data) {
            $empId = GenerateLoginUserId(3, 'EM');
            $id = GenerateUserId(3, 'EM');
            $imageName = StoreUserImage($req, $id);


            Login_User::on('mysql')->create([
                "user_id" => $empId,
                "company_user_id" => $id,
                "user_name" => $req->name,
                "user_phone" => $req->phn_no,
                "user_email" => $req->email,
                "user_role" =>  3,
                "password" => Hash::make($req->password),
                "image" => $imageName,
                "company_id" =>  $req->company,
                "store_id" =>  $req->store,
            ]);


            // Insert Info to User__Info 
            $insert = User_Info::on('mysql_second')->create([
                "user_id" => $id,
                "login_user_id" => $empId,
                "user_name" => $req->name,
                "user_email" => $req->email,
                "user_phone" => $req->phn_no,
                "gender" => $req->gender,
                "loc_id" => $req->location,
                "user_role" => 3,
                "tran_user_type" => $req->type,
                "dob" => $req->dob,
                "nid" => $req->nid_no,
                "password" => Hash::make($req->password),
                "address" => $req->address,
                "image" => $imageName,
                "store_id" =>  $req->store,
            ]); 

            
            // Insert Employee Personal Details
            Employee_Personal_Detail::on('mysql_second')->create([
                'employee_id' =>  $id,
                'name' => $req->name,
                "fathers_name" => $req->fathers_name,
                "mothers_name" => $req->mothers_name,
                "dob" => $req->dob,
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

            $data = User_Info::on('mysql_second')->where('user_role', 3)->with('Withs','Location')->findOrFail($insert->id);
        });

        
        return response()->json([
            'status'=> true,
            'message' => 'Employee Personal Details Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method



    // Update Employee Personal Details
    public function Update(Request $req){
        $data = User_Info::on('mysql_second')->where('user_role', 3)->where('user_id', $req->employee_id)->first();
        
        $req->validate([
            'name' => 'required',
            'gender' => 'in:Male,Female,Others',
            'religion' => 'in:Islam,Hinduism,Christianity,Buddhism,Judaism',
            'marital_status' => 'in:Married,Unmarried',
            'nid_no' => 'nullable|numeric',
            "phn_no" => ['required','numeric',Rule::unique('mysql.login__users', 'user_phone')->ignore($data->login_user_id, 'user_id')],
            "email" => ['required','email',Rule::unique('mysql.login__users', 'user_email')->ignore($data->login_user_id, 'user_id')],
            'location'  => 'required|exists:mysql.location__infos,id',
            'type'=> 'required|exists:mysql_second.transaction__withs,id',
        ]);

        DB::transaction(function () use ($req, $data) {
            $login_user = Login_User::on('mysql')->where('user_id', $data->login_user_id)->first();
            // Calling UserHelper Functions
            $imageName = UpdateUserImage($req, $data->image, $login_user->company_id, $data->user_id);

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
                "dob" => $req->dob,
                "nid" => $req->nid_no,
                "address" => $req->address,
                "image" => $imageName,
                "updated_at" => now()
            ]);

            Employee_Personal_Detail::on('mysql_second')->findOrFail($req->id)->update([
                'name' => $req->name,
                "fathers_name" => $req->fathers_name,
                "mothers_name" => $req->mothers_name,
                "dob" => $req->dob,
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
            // "updatedData" => $updatedData,
        ], 200);
    } // End Method



    // Delete Employee Personal Details
    public function Delete(Request $req){
        $data = User_Info::on('mysql_second')->where('user_role', 3)->findOrFail($req->id);
        if($data->image){
            Storage::disk('public')->delete($data->image);
        }
        Login_User::on('mysql')->where('user_id',$data->login_user_id)->delete();
        $data->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Employee Personal Details Deleted Successfully',
        ], 200); 
    } // End Method
}
