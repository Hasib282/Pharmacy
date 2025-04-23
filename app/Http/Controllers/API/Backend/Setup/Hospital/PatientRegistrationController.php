<?php

namespace App\Http\Controllers\Api\Backend\Setup\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Patient_Registration;
use App\Models\Patient_Information;

class PatientRegistrationController extends Controller
{
    // Show All Patient Registrations
    public function ShowAll(Request $req){
        $data = Patient_Registration::on('mysql_second')->get();//with is used to bring data from the doctors table ->with('doctors')
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Patient Registrations
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
            

            Patient_Information::on('mysql_second')->create([
                'ptn_id'=>$ptn_id,
                'title'=>$req->title,
                'name'=> $req->name,
                'address'=> $req->address,
                'phone'=> $req->phone,
                'email'=> $req->email,
                'age'=>$age,
                'gender'=> $req->gender,
                'nationality'=> $req->nationality,
                'religion'=> $req->religion,
            ]);

            $insert = Patient_Registration::on('mysql_second')->create([
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
                'ptn_id' =>'required|exists:mysql_second.patient__information,ptn_id',
                'bed_category' =>'required',
                'bed_list' =>'required',
                'doctor' => 'required',//|exists:mysql_second.doctor__information.id',
                'sr' => 'required'
            ]);

            //auto generate reg id
            $reg_id = Patient_Registration::on('mysql_second')->select('reg_id')->where('ptn_id',$req->ptn_id)->orderby('reg_id','desc')->first();
            
            if($reg_id){
                $newreg_id = intval(substr($reg_id->reg_id, 1));
                $newreg_id++;
            }
            else{
                $newreg_id = 1;
            }

            $reg_id= "R".str_pad($newreg_id,11,'0',STR_PAD_LEFT);
            //auto generate reg id ends
            
            
            $insert = Patient_Registration::on('mysql_second')->create([
                'reg_id' => $reg_id,
                'ptn_id' => $req->ptn_id,
                'bed_category' => $req->bed_category,
                'bed_list' => $req->bed_list,
                'doctor' => $req->doctor,
                'sr_id' => $req->sr
            ]);
        }

        $data = Patient_Registration::on('mysql_second')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Patient Registrations Added Successfully',
            "data" => $data,
        ], 200); 
    } // End Method



    //Edit Patient Registrations
    public function Edit(Request $req){
        $data = Patient_Registration::on('mysql_second')->findOrFail($req-> id);

        return response()->json([
            'status'=> true,
            'data'=> $data,
        ], 200);
    }



    // Update Patient Registrations
    public function Update(Request $req){
        $req->validate([
            'pid'=> 'required',
            'rid'=>'required',
            'title'=>'required',
            'name'=> 'required',
            'address'=> 'required',
            'age'=> 'required',
            'gender'=> 'required',
            'nationality'=> 'required',
            'religion'=> 'required',
            'doctor'=> 'required',
            'sr'=> 'required'
        ]);

        $update = Patient_Registration::on('mysql_second')->findOrFail($req-> id)->update([
            'pid'=> $req->pid,
            'rid'=>$req->rid,
            'title'=>$req->title,
            'name'=> $req->name,
            'address'=> $req->address,
            'age'=> $req->age,
            'gender'=> $req->gender,
            'nationality'=> $req->nationality,
            'religion'=> $req->religion,
            'doctor'=> $req->doctor,
            'sr'=> $req->sr,
            "updated_at" => now()
        ]);

        $updatedData = Patient_Registration::on('mysql_second')->findOrFail($req-> id);

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
        Patient_Registration::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message'=> 'Patient Registrations Deleted Successfully'
        ], 200);
    } // End Method



    // Get Patient Information
    public function GetPatient(Request $req){
        $data = Patient_Information::on('mysql_second')
            ->where('ptn_id', 'like', 'P%'.$req->patient.'%')
            ->orWhere('phone', 'like', $req->patient.'%')
            ->orWhere('name', 'like', $req->patient.'%')
            ->orderBy('name')
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
                                $list .= '<tr tabindex="' . ($index + 1) . '" data-id="'.$item->ptn_id.'" data-title="'.$item->title.'" data-name="'.$item->name.'" data-phone="'.$item->phone.'" data-email="'.$item->email.'" data-gender="'.$item->gender.'" data-nationality="'.$item->nationality.'" data-religion="'.$item->religion.'" data-address="'.$item->address.'">
                                            <td>' .$item->ptn_id. '</td>
                                            <td>' .$item->name. '</td>
                                            <td>' .$item->phone. '</td>
                                            <td>' .$item->email. '</td>
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
    