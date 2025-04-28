<?php

namespace App\Http\Controllers\Api\Backend\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Doctor_Information;


class DoctorController extends Controller
{
    // Show All Doctors
    public function Show(Request $req){
        $data = Doctor_Information::on('mysql_second')->get();
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Doctors
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

        $insert = Doctor_Information::on('mysql_second')->create([
            'title'=>$req->title,
            'name'=>$req->name,
            'degree'=>$req->degree,
            'email'=>$req->email,
            'phone'=>$req->phone,
            'chamber'=>$req->chamber,
            'specialization'=>$req->specialization,
            'marketing_head'=>$req->marketing_head
        ]);

        $data = Doctor_Information::on('mysql_second')->findOrFail($insert->id);

        return response()->json([
            'status'=>true,
            'message'=>'Doctors information Added Successfully',
            "data" => $data,
        ], 200);
    } // End Method



    // Update Doctors 
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

        $updatedData = Doctor_Information::on('mysql_second')->findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message'=>'Doctors Information Updated Successfully',
                "updatedData" => $updatedData,
            ], 200);
        }
    } // End Method



    // Delete Doctors
    public function Delete(Request $req){
        Doctor_Information::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=>true,
            'message'=> 'Doctors Information Deleted Successfully'
        ], 200);
    } // End Method

    

    // Get Doctors
    public function Get(Request $req){
        $data = Doctor_Information::on('mysql_second')
        ->where('name', 'like', $req->doctor.'%')
        ->orderBy('name')
        ->take(10)
        ->get();

        $list = '<table class="patient-table" style="overflow-x:auto; width:100%;">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Degree</th>
                            <th>Specialization</th>
                        </tr>
                    </thead>
                    <tbody>';
                        if($data->count() > 0){
                            foreach($data as $index => $item) {
                                $list .= '<tr tabindex="' . ($index + 1) . '" data-id="'.$item->id.'" data-title="'.$item->title.'" data-name="'.$item->name.'" data-phone="'.$item->phone.'" data-email="'.$item->email.'" data-degree="'.$item->degree.'" data-chamber="'.$item->chamber.'" data-specialization="'.$item->specialization.'">
                                            <td>' .$item->name. '</td>
                                            <td>' .$item->degree. '</td>
                                            <td>' .$item->specialization. '</td>
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


    