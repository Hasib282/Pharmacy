<?php

namespace App\Http\Controllers\Api\Backend\Setup\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Booking;
use App\Models\User_info;

class PatientRegistrationController extends Controller
{
    // Show All Patient Registrations
    public function Show(Request $req){
        $data = Booking::on('mysql_second')->with('User','Category','List','Doctors','Sr')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Patient Registrations
    public function Insert(Request $req){
        if($req->patient_type == "new"){
            $ptn_id = GenerateUserId(6, 'PT');

            // validation
            $req->validate([
                'title'=>'required',
                'name'=> 'required',
                'phone'=> 'required',
                'email'=> 'nullable|email',
                'gender'=> 'required',
                'bed_category' =>'required|exists:mysql_second.bed__categories,id',
                'bed_list' =>'required|exists:mysql_second.bed__lists,id',
                'doctor' => 'required|exists:mysql_second.doctor__information,id',
                'sr' => 'required|exists:mysql_second.user__infos,user_id'
            ]);


            //converting age to  string to make a singe data
            $age_year = $req->age_years;
            $age_month = $req->age_months;
            $age_day = $req->age_days;
            //concatinate
            // $age =$age_year . " years, " . $age_month . " months, " . $age_day . " days";
            $dob = now()->subYears($age_year)->subMonths($age_month)->subDays($age_day);
            

            User_info::on('mysql_second')->create([
                'user_id'=>$ptn_id,
                'title'=>$req->title,
                'user_name'=> $req->name,
                'address'=> $req->address,
                'user_phone'=> $req->phone,
                'user_email'=> $req->email,
                'user_role'=> 6,
                'dob'=>$dob,
                'gender'=> $req->gender,
                'nationality'=> $req->nationality,
                'religion'=> $req->religion,
            ]);

            $insert = Booking::on('mysql_second')->create([
                'booking_id'=>'REG000000001',
                'user_id'=>$ptn_id,
                'bed_category'=>$req->bed_category,
                'bed_list'=> $req->bed_list,
                'doctor'=> $req->doctor,
                'sr_id'=> $req->sr
            ]);
        }
        else{
            $req->validate([
                'ptn_id' =>'required|exists:mysql_second.user__infos,user_id',
                'bed_category' =>'required|exists:mysql_second.bed__categories,id',
                'bed_list' =>'required|exists:mysql_second.bed__lists,id',
                'doctor' => 'required|exists:mysql_second.doctor__information,id',
                'sr' => 'required|exists:mysql_second.user__infos,user_id'
            ]);

            //auto generate reg id
            $reg_id = Booking::on('mysql_second')->where('user_id',$req->ptn_id)->orderby('booking_id','desc')->first();
            $newreg_id = $reg_id ? 'REG' . str_pad((intval(substr($reg_id->booking_id, 3)) + 1), 9, '0', STR_PAD_LEFT) : 'REG000000001';
            
            
            $insert = Booking::on('mysql_second')->create([
                'booking_id' => $newreg_id,
                'user_id' => $req->ptn_id,
                'bed_category' => $req->bed_category,
                'bed_list' => $req->bed_list,
                'doctor' => $req->doctor,
                'sr_id' => $req->sr
            ]);
        }

        $data = Booking::on('mysql_second')->with('User','Category','List','Doctors','Sr')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Patient Registrations Added Successfully',
            "data" => $data,
        ], 200); 
    } // End Method



    // Update Patient Registrations
    public function Update(Request $req){
        $req->validate([
            'ptn_id' =>'required|exists:mysql_second.user__infos,user_id',
            'bed_category' =>'required|exists:mysql_second.bed__categories,id',
            'bed_list' =>'required|exists:mysql_second.bed__lists,id',
            'doctor' => 'required|exists:mysql_second.doctor__information,id',
            'sr' => 'required|exists:mysql_second.user__infos,user_id'
        ]);

        $update = Booking::on('mysql_second')->findOrFail($req-> id)->update([
            'user_id' => $req->ptn_id,
            'bed_category' => $req->bed_category,
            'bed_list' => $req->bed_list,
            'doctor' => $req->doctor,
            'sr_id' => $req->sr,
            "updated_at" => now()
        ]);

        $updatedData = Booking::on('mysql_second')->with('User','Category','List','Doctors','Sr')->findOrFail($req-> id);

        if($update){
            return response()->json([
                'status'=>true,
                'message'=>'Patient Registrations Updated Successfully',
                "updatedData" => $updatedData,
            ], 200);
        }
    } // End Method



    // Delete Patient Registrations
    public function Delete(Request $req){
        Booking::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message'=> 'Patient Registrations Deleted Successfully'
        ], 200);
    } // End Method
}
    