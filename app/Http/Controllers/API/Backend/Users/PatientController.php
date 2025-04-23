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
        $data = Patient_Information::on('mysql_second')->get();//with is used to bring data from the doctors table ->with('doctors')

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
                'message'=>'updated',
                "updatedData" => $updatedData,
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



    // Get Patient
    public function Get(Request $req){
        $data = Patient_Information::on('mysql_second')
            ->where('ptn_id', 'like', $req->patient.'%')
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
    