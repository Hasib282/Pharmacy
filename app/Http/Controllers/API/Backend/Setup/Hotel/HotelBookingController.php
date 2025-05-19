<?php

namespace App\Http\Controllers\API\Backend\Setup\Hotel;

use Illuminate\Http\Request;

use App\Models\Appoinment;
use App\Models\User_Info;

class HotelBookingController extends Controller
{
    
    // Show appointment data


    public function Show(Request $req){
        $data = Appoinment::on('mysql_second')->with('User')->get();

        return response()->json([
            'status'=>true,
            'data'=>$data
        ],200);
    }


    
    // Insert Patient Appointment
    public function Insert(Request $req){
        if($req->guest_type == "new"){
            // Generate guest ID using the helper function
            $guest_id = GenerateUserId(7, 'GT');
        

            // validation
            $req->validate([
                'title'=>'required',
                'name'=> 'required',
                'phone'=> 'required',
                'nid'=> 'required',
                'passport'=> 'required',
                'driving_lisence'=> 'required',
            ]);


            User_Info::on('mysql_second')->create([
                'user_id'=>$guest_id,
                'title'=>$req->title,
                'user_name'=> $req->name,
                'user_email'=> $req->email,
                'user_phone'=> $req->phone,
                'nid'=> $req->nid,
                'passport'=> $req->passport,
                'driving_lisence'=> $req->driving_lisence,
                'gender'=> $req->gender,
                "nationality"=> $req->nationality,
                'religion'=> $req->religion,
                'address'=> $req->address,
            ]);

            $insert = Appoinment::on('mysql_second')->create([
                'appoinment_serial'=>'R0000000001',
                'check_in'=>$ptn_id,
                'adult'=>$req->name,
                'children'=> $req->phone,
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
