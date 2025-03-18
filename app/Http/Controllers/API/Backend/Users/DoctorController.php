<?php

namespace App\Http\Controllers\Api\Backend\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Doctor_Information;


class DoctorController extends Controller
{
    //show data
    public function ShowAll(Request $req){
        $data = Doctor_Information::on('mysql_second')->paginate(15);
        
        return response()->json([
            'status'=>true,
            'data'=>$data,
            
        ],200);
    }



    // insert data
    public function Insert(Request $req){
        $req-> validate([
            'title'=>'required',
            'name'=>'required',
            'degree'=>'required',
            'email'=>'required',
            'phone'=>'required',
            'chamber'=>'required',
            'specialization'=>'required',
            'marketing_head'=>'required'

        ]);

        Doctor_Information::on('mysql_second')->insert([
            'title'=>$req->title,
            'name'=>$req->name,
            'degree'=>$req->degree,
            'email'=>$req->email,
            'phone'=>$req->phone,
            'chamber'=>$req->chamber,
            'specialization'=>$req->specialization,
            'marketing_head'=>$req->marketing_head
        ]);

        return response()->json([
            'status'=>true,
            'message'=>'added sussesfully'
        ]);
    }



    //edit data
    public function Edit(Request $req){
        $data = Doctor_Information::on('mysql_second')->findorfail($req->id);
        return response()->json([
            'status'=>true,
            'data'=> $data,
        ]);

    }



    //update data 
    public function Update(Request $req){
        $req-> validate([
            'title'=>'required',
            'name'=>'required',
            'degree'=>'required',
            'email'=>'required',
            'phone'=>'required',
            'chamber'=>'required',
            'specialization'=>'required',
            'marketing_head'=>'required'

        ]);

        $update = Doctor_Information::on('mysql_second')->findOrFail($req->id)->update([
            'title'=>$req->title,
            'name'=>$req->name,
            'degree'=>$req->degree,
            'email'=>$req->email,
            'phone'=>$req->phone,
            'chamber'=>$req->chamber,
            'specialization'=>$req->specialization,
            'marketing_head'=>$req->marketing_head

        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message'=>'updated sussesfully'
            ]);
        }
    }



    //delete data
    public function Delete(Request $req){
        Doctor_Information::on('mysql_second')->findOrFail($req->id)->delete();

        return response()->json([
            'status'=>true,
            'message'=> 'deleted data'
        ]);
    }

    // Get Doctors
    public function Get(Request $req){
        $doctors = Doctor_Information::on('mysql_second')
        ->where('name', 'like', $req->doctor.'%')
        ->orderBy('name')
        ->take(10)
        ->get();


        if($doctors->count() > 0){
            $list = "";
            foreach($doctors as $index => $doctor) {
                $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$doctor->id.'">'.$doctor->name.'</li>';
            }
        }
        else{
            $list = '<li>No Data Found</li>';
        }
        return $list;
    } // End Method
}


    