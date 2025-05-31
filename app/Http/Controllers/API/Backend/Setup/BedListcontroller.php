<?php

namespace App\Http\Controllers\API\Backend\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Transaction_Head;
use App\Models\Bed_List;

class BedListController extends Controller
{
    // Show All Bed List
    public function Show(Request $req){
        $data = Bed_List::on('mysql_second')->with('bed_category','nursing','floor')->orderBy('added_at')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Bed List
    public function Insert(Request $req){
        $req->validate([
            "bed_list" => 'required|unique:mysql_second.bed__lists,name',
            "bed_category" => 'required|exists:mysql_second.bed__categories,id',
            "nursing_station" => 'nullable|exists:mysql_second.nursing__stations,id',
            "floor" => 'nullable|exists:mysql_second.floors,id',
        ]);

        // Insert Bed List
        $insert = Bed_List::on('mysql_second')->create([
            "name" => $req->bed_list,
            "category" => $req->bed_category,
            "nursing_station" => $req->nursing_station,
            "floor" => $req->floor,
            "price" => $req->price,
            "capacity" => $req->capacity,
        ]);

        // Insert Transaction Head
        $groupe = GetTranType($req->segment(2));
        Transaction_Head::on('mysql')->create([
            "tran_head_name" => 'Bed-'.$req->bed_category_name.'-'.$req->bed_list,
            "groupe_id" => $groupe,
            "mrp" => $req->price,
            "company_id" => $req->company,
        ]);

        $data = Bed_List::on('mysql_second')->with('bed_category','nursing','floor')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Bed List Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method



    // Update Bed List
    public function Update(Request $req){
        $data = Bed_List::on('mysql_second')->with('bed_category')->findOrFail($req->id);
        // dd($data);
        $req->validate([
            "bed_list" => ['required',Rule::unique('mysql_second.bed__lists', 'name')->ignore($data->id)],
            "bed_category" => 'required|exists:mysql_second.bed__categories,id',
            "nursing_station" => 'nullable|exists:mysql_second.nursing__stations,id',
            "floor" => 'nullable|exists:mysql_second.floors,id',
        ]);

        // Update Transaction Head
        $groupe = GetTranType($req->segment(2));
        // $abc = Transaction_Head::on('mysql')->where('groupe_id',$groupe)->where('tran_head_name','Bed-'.$data->bed_category->name.'-'.$data->name)->first();
        // dd($abc);

        Transaction_Head::on('mysql')->where('groupe_id',$groupe)->where('tran_head_name','Bed-'.$data->bed_category->name.'-'.$data->name)->update([
            "tran_head_name" => 'Bed-'.$req->bed_category_name.'-'.$req->bed_list,
            "mrp" => $req->price
        ]);

        // Update Bed List
        $update = $data->update([
            "name" => $req->bed_list,
            "category" => $req->bed_category,
            "nursing_station" => $req->nursing_station,
            "floor" => $req->floor,
            "price" => $req->price,
            "capacity" => $req->capacity,
            "updated_at" => now()
        ]);


        $updatedData = Bed_List::on('mysql_second')->with('bed_category','nursing','floor')->findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Bed List Updated Successfully',
                "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method



    // Delete Bed List
    public function Delete(Request $req){
        Bed_List::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Bed List Deleted Successfully',
        ], 200); 
    } // End Method



    // Get Bed List
    public function Get(Request $req){
        $data = Bed_List::on('mysql_second')
        ->with('bed_category','nursing','floor','latestBooking')
        ->where('name', 'like', $req->bed_list.'%')
        ->where('category',  $req->bed_category)
        ->whereDoesntHave('latestBooking', function ($q) {
            $q->whereIn('status', [1, 2, 3]);
        })
        ->orderBy('name')
        ->get();

        $list = "<ul>";
            if($data->count() > 0){
                foreach($data as $index => $item) {
                    $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$item->id.'" data-price="'.$item->price.'"  data-capacity="'.$item->capacity.'">'.$item->name.'</li>';
                }
            }
            else{
                if($req->bed_category != 'undefined'){
                    $list .= '<li>Select Bed Category First</li>';
                }
                else{
                    $list .= '<li>No Data Found</li>';
                }
            }
        $list .= "</ul>";

        return $list;
    } // End Method
    
    
    
    // Get Bed List
    public function GetAll(Request $req){
        $data = Bed_List::on('mysql_second')
        ->where('category',  $req->bed_category)
        ->orderBy('name')
        ->get();

        $list = "";
        if($data->count() > 0){
            foreach($data as $index => $item) {
                $list .= '<tr tabindex="' . ($index + 1) . '" data-id="'.$item->id.'" data-price="'.$item->price.'"  data-capacity="'.$item->capacity.'">
                            <td>'.$item->name.'</td>
                            <td>'.$item->price.'</td>
                            <td>'.$item->capacity.'</td>
                        </tr>';
            }
        }
        else{
            if($req->bed_category != 'undefined' && $data->count() > 0){
                $list .= '<tr>
                            <td>Select Bed Category First</td>
                        </tr>';
            }
            else{
                $list .= '<tr>
                            <td>No Data Found</td>
                        </tr>';
            }
        }
        

        return $list;
    } // End Method
}