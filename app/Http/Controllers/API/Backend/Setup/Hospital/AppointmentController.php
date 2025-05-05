<?php

namespace App\Http\Controllers\API\Backend\Setup\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mockery\Generator\StringManipulation\Pass\Pass;
use App\Models\Patient_Registration;
use App\Models\Patient_Information;
use App\Models\Appoinment;

class AppointmentController extends Controller
{

    // Show appointment data


    public function Show(Request $req){
        $data = Appoinment::on('mysql_second')->with('Doctor','Patient')->get();

        return response()->json([
            'status'=>true,
            'data'=>$data
        ],200);
    }


    
    // Insert Patient Appointment
    public function Insert(Request $req){
        if($req->patient_type == "new"){
            //Patient id auto generate
            $patient_id = Patient_Information::on('mysql_second')->select('ptn_id')->orderby('ptn_id','desc')->first();
            if($patient_id){
                $newptn_id = intval(substr($patient_id->ptn_id,1));
                $newptn_id++;
            }
            else{
                $newptn_id = 1;
            }
            $ptn_id= "P".str_pad($newptn_id,11,'0',STR_PAD_LEFT);
            //Patient id auto generation ends

            // validation
            $req->validate([
                'title'=>'required',
                'name'=> 'required',
                'phone'=> 'required',
                'doctor'=> 'required',//|exists:mysql_second.
                'date'=> 'required',
                'appointment'=> 'required',
                'schedule'=> 'required',
            ]);


            // //converting age to  string to make a singe data
            // $age_year = $req->age_years;
            // $age_month = $req->age_months;
            // $age_day = $req->age_days;
            // //concatinate
            // $age =$age_year . " years, " . $age_month . " months, " . $age_day . " days";
            

            Patient_Information::on('mysql_second')->create([
                'ptn_id'=>$ptn_id,
                'title'=>$req->title,
                'name'=> $req->name,
                'address'=> $req->address,
                'phone'=> $req->phone,
                'email'=> $req->email,
                // 'age'=>$age,
                'gender'=> $req->gender,
                'nationality'=> $req->nationality,
                'religion'=> $req->religion,
            ]);

            $insert = Appoinment::on('mysql_second')->create([
                'appoinment_serial'=>$req->appointment,
                'ptn_id'=>$ptn_id,
                'name'=>$req->name,
                'mobile'=> $req->phone,
                'doctor'=> $req->doctor,
                'date'=> $req->date,
                'schedule'=> $req->schedule
            ]);
        }
        else{
            $req->validate([
                'patient' =>'required|exists:mysql_second.patient__information,ptn_id',
                'doctor'=> 'required',//|exists:mysql_second.
                'date'=> 'required',
                'appointment'=> 'required',
                'schedule'=> 'required',
            ]);

            
            //auto generate reg id ends
            
            
            $insert = Appoinment::on('mysql_second')->create([
                'appoinment_serial'=>$req->appointment,
                'ptn_id'=>$req->patient,
                'name'=>$req->name,
                'mobile'=> $req->phone,
                'doctor'=> $req->doctor,
                'date'=> $req->date,
                'schedule'=> $req->schedule
            ]);
        }

        $data = Appoinment::on('mysql_second')->with('Doctor','Patient')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Patient Registrations Added Successfully',
            "data" => $data,
        ], 200); 
    } // End Method



    // update Patient Appointment


    public function Update(Request $req){
        $req->validate([
            'patient' =>'required|exists:mysql_second.patient__information,ptn_id',
            'doctor'=> 'required|exists:mysql_second.doctor__information,id',//|exists:mysql_second.
            'date'=> 'required',
            'appointment'=> 'required',
            'schedule'=> 'required',
        ]);

        $update = Appoinment::on('mysql_second')->findOrFail($req->id)->update([
                'appoinment_serial'=>$req->appointment,
                'ptn_id'=>$req->patient,
                'name'=>$req->name,
                'mobile'=> $req->ptn_phone,
                'doctor'=> $req->doctor,
                'date'=> $req->date,
                'schedule'=> $req->schedule,
                "updated_at" => now()
        ]);

        $updatedData = Appoinment::on('mysql_second')->with('Doctor','Patient')->findOrFail($req-> id);
        return response()->json([
            'status'=> true,
            'message' => 'Patient Registrations Added Successfully',
            "updatedData" => $updatedData,
        ], 200); 

        
    }


    // Delete Patient Registrations
    public function Delete(Request $req){
        Appoinment::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message'=> 'Patient Registrations Deleted Successfully'
        ], 200);
    } // End Method
}
