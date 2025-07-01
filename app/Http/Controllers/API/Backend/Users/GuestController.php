<?php

namespace App\Http\Controllers\Api\Backend\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User_Info;

class GuestController extends Controller
{
    // Show All Guests
    public function Show(Request $req){
        $data = User_Info::on('mysql_second')->where('user_role',7)->get();
        return response()->json([
            'status'=> true,
            'data'=> $data,
        ],200);
    } // End Method



    // Update Guests
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

        $update = User_Info::on('mysql_second')->where('user_role',7)->findOrFail($req-> id)->update([
            'title'=>$req->title,
            'name'=> $req->name,
            'email'=> $req->email,
            'phone'=> $req->phone,
            'address'=> $req->address,
            'gender'=> $req->gender,
            'nationality'=> $req->nationality,
            'religion'=> $req->religion,
            "updated_at" => now()
        ]);

        $updatedData = User_Info::on('mysql_second')->findOrFail($req-> id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Guest Details Updated Successfully',
                "updatedData" => $updatedData,
            ]);
        }
    } // End Method



    // Delete Guests
    public function Delete(Request $req){
        User_Info::on('mysql_second')->where('user_role',7)->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Guest Details Deleted Successfully',
        ], 200);
    } // End Method



    // Delete Guests Status
    public function DeleteStatus(Request $req){
        $data = User_Info::on('mysql_second')->where('user_role',7)->findOrFail($req->id);
        $data->update(['status' => $data->status == 0 ? 1 : 0]);
        
        $updatedData = User_Info::on('mysql_second')->findOrFail($req->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Guest Details Deleted Successfully',
            'updatedData' => $updatedData
        ], 200);
    } // End Method



    // Get Current Guests
    public function Get(Request $req){
        $data = User_info::on('mysql_second')
            ->with('latestBooking','earliestBooking','earliestBooking.category','earliestBooking.list')
            ->where('user_role', 7)
            ->where(function($query) use ($req) {
                $query->where('user_id', 'like', 'P%' . $req->guest . '%')
                    ->orWhere('user_phone', 'like', $req->guest . '%')
                    ->orWhere('user_name', 'like', $req->guest . '%');
            })
            ->whereHas('latestBooking', function ($q) {
                $q->where('status', 1);
            })
            ->orderBy('user_name')
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
                                $list .= '<tr tabindex="' . ($index + 1) . '" data-id="'.$item->user_id.'" data-title="'.$item->title.'" data-name="'.$item->user_name.'" data-phone="'.$item->user_phone.'" data-email="'.$item->user_email.'" data-category-id="'.$item->earliestBooking->category->id.'" data-category-name="'.$item->earliestBooking->category->name.'" data-list-id="'.$item->earliestBooking->list->id.'" data-list-name="'.$item->earliestBooking->list->name.'" data-booking="'.$item->earliestBooking->booking_id.'" data-checkin="'.$item->earliestBooking->check_in.'" data-checkout="'.$item->earliestBooking->check_out.'">
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
    
    
    
    // Get Guest Lists
    public function GetAll(Request $req){
        $data = User_info::on('mysql_second')
            ->with('latestBooking')
            ->where('user_role', 7)
            ->where(function($query) use ($req) {
                $query->where('user_id', 'like', 'P%' . $req->guest . '%')
                    ->orWhere('user_phone', 'like', $req->guest . '%')
                    ->orWhere('user_name', 'like', $req->guest . '%');
            })
            ->orderBy('user_name')
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
                                $list .= '<tr tabindex="' . ($index + 1) . '" data-id="'.$item->user_id.'" data-title="'.$item->title.'" data-name="'.$item->user_name.'" data-phone="'.$item->user_phone.'" data-email="'.$item->user_email.'" data-gender="'.$item->gender.'" data-nationality="'.$item->nationality.'" data-religion="'.$item->religion.'" data-address="'.$item->address.'" data-nid="'.$item->nid.'" data-passport="'.$item->passport.'" data-driving_license="'.$item->driving_license.'">
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