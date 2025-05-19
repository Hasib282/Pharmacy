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
        $data = Booking::on('mysql_second')->with('User','Category','List','Doctors')->get();
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
                'bed_category'=>'required',
                'bed_list'=>'required',
                'doctor'=> 'required',//|exists:mysql_second.doctor__information.id',
                'sr'=> 'required'
            ]);


            //converting age to  string to make a singe data
            $age_year = $req->age_years;
            $age_month = $req->age_months;
            $age_day = $req->age_days;
            //concatinate
            $age =$age_year . " years, " . $age_month . " months, " . $age_day . " days";
            

            User_info::on('mysql_second')->create([
                'user_id'=>$ptn_id,
                'title'=>$req->title,
                'user_name'=> $req->name,
                'address'=> $req->address,
                'user_phone'=> $req->phone,
                'user_email'=> $req->email,
                // 'age'=>$age,
                'gender'=> $req->gender,
                'nationality'=> $req->nationality,
                'religion'=> $req->religion,
            ]);

            $insert = Booking::on('mysql_second')->create([
                'reg_id'=>'R00000000001',
                'ptn_id'=>$ptn_id,
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
            $reg_id = Booking::on('mysql_second')->select('reg_id')->where('ptn_id',$req->ptn_id)->orderby('reg_id','desc')->first();
            
            if($reg_id){
                $newreg_id = intval(substr($reg_id->reg_id, 1));
                $newreg_id++;
            }
            else{
                $newreg_id = 1;
            }

            $reg_id= "R".str_pad($newreg_id,11,'0',STR_PAD_LEFT);
            //auto generate reg id ends
            
            
            $insert = Booking::on('mysql_second')->create([
                'reg_id' => $reg_id,
                'ptn_id' => $req->ptn_id,
                'bed_category' => $req->bed_category,
                'bed_list' => $req->bed_list,
                'doctor' => $req->doctor,
                'sr_id' => $req->sr
            ]);
        }

        $data = Booking::on('mysql_second')->with('User','Category','List','Doctors')->findOrFail($insert->id);
        
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
            'reg_id' => $reg_id,
            'ptn_id' => $req->ptn_id,
            'bed_category' => $req->bed_category,
            'bed_list' => $req->bed_list,
            'doctor' => $req->doctor,
            'sr_id' => $req->sr,
            "updated_at" => now()
        ]);

        $updatedData = Booking::on('mysql_second')->with('User','Category','List','Doctors')->findOrFail($req-> id);

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



    // Get Patient Information
    public function GetPatient(Request $req){
        $data = User_info::on('mysql_second')
            ->where('user_role', 6)
            ->where(function($query) use ($req) {
                $query->where('user_id', 'like', 'P%' . $req->patient . '%')
                    ->orWhere('user_phone', 'like', $req->patient . '%')
                    ->orWhere('user_name', 'like', $req->patient . '%');
            })
            ->orderBy('user_name')
            ->take(10)
            ->get();
        

        $list = '<table class="patient-table" style="overflow-x:auto; width:100%;">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>';
                        if($data->count() > 0){
                            foreach($data as $index => $item) {
                                // $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$item->ptn_id.'" data-title="'.$item->title.'" data-name="'.$item->name.'" data-phone="'.$item->phone.'" data-email="'.$item->email.'" data-gender="'.$item->gender.'" data-nationality="'.$item->nationality.'" data-religion="'.$item->religion.'" data-address="'.$item->address.'">'.$item->name. '('.$item->ptn_id.')</li>';
                                $list .= '<tr tabindex="' . ($index + 1) . '" data-id="'.$item->user_id.'" data-title="'.$item->title.'" data-name="'.$item->user_name.'" data-phone="'.$item->user_phone.'" data-email="'.$item->user_email.'" data-gender="'.$item->gender.'" data-nationality="'.$item->nationality.'" data-religion="'.$item->religion.'" data-address="'.$item->address.'">
                                            <td>' .$item->user_id. '</td>
                                            <td>' .$item->user_name. '</td>
                                            <td>' .$item->user_phone. '</td>
                                            <td>' .$item->user_email. '</td>
                                            <td>' .$item->gender. '</td>
                                            <td>' .$item->address. '</td>
                                        </tr>';
                            }
                        }
                        else{
                            $list .= '<tr>
                                        <td colspan="10">No Data Found</td>
                                    </tr>';
                        }
        $list .= '  </tbody>
                </table>';


        return $list;
    } // End Method
}
    