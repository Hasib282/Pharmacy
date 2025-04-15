<?php

namespace App\Http\Controllers\Api\Backend\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Patient_Registration;
use App\Models\Patient_Information;

class PatientController extends Controller
{
    public function ShowAll(Request $req){
        $data = Patient_Information::on('mysql_second')->paginate(15);//with is used to bring data from the doctors table ->with('doctors')

        return response()->json([
            'data'=> $data,
            'status'=> true,

        ],200);
    }

    

    //Edit 
    public function Edit(Request $req){
        $data = Patient_Information::on('mysql_second')->findOrFail($req-> id);

        return response()->json([
            'status'=> true,
            'data'=> $data,
        ]);
    }

    //Update
    public function Update(Request $req){
        $req->validate([
            //'pid'=> 'required',
            //'rid'=>'required',
            'title'=>'required',
            'name'=> 'required',
            'address'=> 'required',
            'email'=>'required',
            'phone'=> 'required',
            //'age'=> 'required',
            'gender'=> 'required',
            'nationality'=> 'required',
            'religion'=> 'required',
            //'doctor'=> 'required',
            //'sr'=> 'required'
        ]);

        $update = Patient_Information::on('mysql_second')->findOrFail($req-> id)->update([
            //'pid'=> $req->pid,
            //'rid'=>$req->rid,
            'title'=>$req->title,
            'name'=> $req->name,
            'email'=> $req->email,
            'phone'=> $req->phone,
            'address'=> $req->address,
            // 'age'=> $req->age,
            'gender'=> $req->gender,
            'nationality'=> $req->nationality,
            'religion'=> $req->religion,
            //'doctor'=> $req->doctor,
            //'sr'=> $req->sr,
            "updated_at" => now()
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message'=>'updated'
            ]);
        }


    }

    //delete
    public function Delete(Request $req){
        Patient_Information::on('mysql_second')->findOrFail($req->id)->delete();

        return response()->json([
            'status'=> true,
            'message'=> 'Deleted'
        ]);
    }
}
    