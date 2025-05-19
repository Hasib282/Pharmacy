<?php

namespace App\Http\Controllers\API\Backend\Setup\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mockery\Generator\StringManipulation\Pass\Pass;
use App\Models\Patient_Registration;
use App\Models\User_Info;
use App\Models\Appoinment;

class AppointmentController extends Controller
{
    // Show All Appointments
    public function Show(Request $req){
        $data = Appoinment::on('mysql_second')->with('Doctor','User')->get();

        return response()->json([
            'status'=>true,
            'data'=>$data
        ],200);
    } // End Method


    
    // Insert Patient Appointment
    public function Insert(Request $req){
        $appointment = Appoinment::on('mysql_second')->where('date',$req->date)->where('schedule',$req->schedule)->where('doctor',$req->doctor)->pluck('appoinment_serial')->toArray();
        if (!empty($req->appointment)) {
            if (in_array($req->appointment, $appointment)) {
                return response()->json([
                    'errors' => [
                        'appointment' => ['This appointment serial is already taken']
                    ]
                ], 422);
            } else {
                $serial = $req->appointment;
            }
        } else {
            // Get the maximum serial and increment by 1
            $lastSerial = !empty($appointment) ? max($appointment) : 0;
            $serial = $lastSerial + 1;
        }
        

        if($req->patient_type == "new"){
            $ptn_id = GenerateUserId(6, 'PT');

            // validation
            $req->validate([
                'title'=>'required',
                'name'=> 'required',
                'phone'=> 'required',
                'doctor'=> 'required|exists:mysql_second.doctor__information,id',
                'date'=> 'required',
                'appointment'=> 'required',
                'schedule'=> 'required',
            ]);

            $age_year = $req->age_years;
            $age_month = $req->age_months;
            $age_day = $req->age_days;
            
            $dob = now()->subYears($age_year)->subMonths($age_month)->subDays($age_day);
            

            User_Info::on('mysql_second')->create([
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

            $insert = Appoinment::on('mysql_second')->create([
                'appoinment_serial'=>$serial,
                'user_id'=>$ptn_id,
                'name'=>$req->name,
                'mobile'=> $req->phone,
                'doctor'=> $req->doctor,
                'date'=> $req->date,
                'schedule'=> $req->schedule
            ]);
        }
        else{
            $req->validate([
                'patient' =>'required|exists:mysql_second.user__infos,user_id',
                'doctor'=> 'required|exists:mysql_second.doctor__information,id',
                'date'=> 'required',
                'appointment'=> 'required',
                'schedule'=> 'required',
            ]);
            
            
            $insert = Appoinment::on('mysql_second')->create([
                'appoinment_serial'=>$req->appointment,
                'user_id'=>$req->patient,
                'name'=>$req->name,
                'mobile'=> $req->phone,
                'doctor'=> $req->doctor,
                'date'=> $req->date,
                'schedule'=> $req->schedule
            ]);
        }

        $data = Appoinment::on('mysql_second')->with('Doctor','User')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Patient Registrations Added Successfully',
            "data" => $data,
        ], 200); 
    } // End Method



    // Update Patient Appointment
    public function Update(Request $req){
        $req->validate([
            'patient' =>'required|exists:mysql_second.user__infos,user_id',
            'doctor'=> 'required|exists:mysql_second.doctor__information,id',
            'date'=> 'required',
            'appointment'=> 'required',
            'schedule'=> 'required',
        ]);

        $update = Appoinment::on('mysql_second')->findOrFail($req->id)->update([
            'appoinment_serial'=>$req->appointment,
            'user_id'=>$req->patient,
            'name'=>$req->name,
            'mobile'=> $req->ptn_phone,
            'doctor'=> $req->doctor,
            'date'=> $req->date,
            'schedule'=> $req->schedule,
            "updated_at" => now()
        ]);

        $updatedData = Appoinment::on('mysql_second')->with('Doctor','User')->findOrFail($req-> id);

        return response()->json([
            'status'=> true,
            'message' => 'Patient Registrations Added Successfully',
            "updatedData" => $updatedData,
        ], 200); 
    } // End Method



    // Delete Patient Appointment
    public function Delete(Request $req){
        Appoinment::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message'=> 'Patient Registrations Deleted Successfully'
        ], 200);
    } // End Method
}
