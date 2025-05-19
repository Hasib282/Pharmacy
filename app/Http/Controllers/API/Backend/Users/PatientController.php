<?php

namespace App\Http\Controllers\Api\Backend\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User_Info;

class PatientController extends Controller
{
    // Show All Patients
    public function Show(Request $req){
        $data = User_Info::on('mysql_second')->where('user_role',6)->get();
        return response()->json([
            'status'=> true,
            'data'=> $data,
        ],200);
    } // End Method



    // Update Patients
    public function Update(Request $req){
        $req->validate([
            'title'=>'required',
            'name'=> 'required',
            'address'=> 'required',
            'email'=>'required',
            'phone'=> 'required',
            'gender'=> 'required',
            'nationality'=> 'required',
            'religion'=> 'required',
        ]);


        $age_year = $req->age_years;
        $age_month = $req->age_months;
        $age_day = $req->age_days;
        
        $dob = now()->subYears($age_year)->subMonths($age_month)->subDays($age_day);

        $update = User_Info::on('mysql_second')->where('user_role',6)->findOrFail($req-> id)->update([
            'title'=>$req->title,
            'name'=> $req->name,
            'email'=> $req->email,
            'phone'=> $req->phone,
            'address'=> $req->address,
            'gender'=> $req->gender,
            'dob'=> $dob,
            'nationality'=> $req->nationality,
            'religion'=> $req->religion,
            "updated_at" => now()
        ]);

        $updatedData = User_Info::on('mysql_second')->findOrFail($req-> id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Patient Details Updated Successfully',
                "updatedData" => $updatedData,
            ]);
        }
    } // End Method



    // Delete Patients
    public function Delete(Request $req){
        User_Info::on('mysql_second')->where('user_role',6)->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Patient Details Deleted Successfully',
        ], 200);
    } // End Method



    // Get Patients
    public function Get(Request $req){
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
                                $list .= '<tr tabindex="' . ($index + 1) . '" data-id="'.$item->user_id.'" data-title="'.$item->title.'" data-name="'.$item->user_name.'" data-phone="'.$item->user_phone.'" data-email="'.$item->user_email.'" data-gender="'.$item->gender.'" data-nationality="'.$item->nationality.'" data-religion="'.$item->religion.'" data-address="'.$item->address.'" data-dob="'.$item->dob.'">
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