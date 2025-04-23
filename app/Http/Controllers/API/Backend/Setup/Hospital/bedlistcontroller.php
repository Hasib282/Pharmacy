<?php

namespace App\Http\Controllers\API\Backend\Setup\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Bed_List;

class BedListController extends Controller
{
    // Show All Bed List
    public function ShowAll(Request $req){
        $data = Bed_List::on('mysql_second')->with('category','nursing')->orderBy('added_at')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Bed List
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required|unique:mysql_second.bed__lists,name',
            "bed_category" => 'required|exists:mysql_second.bed__categories,id',
            "nursing_station" => 'required|exists:mysql_second.nursing__stations,id',
        ]);

        $insert = Bed_List::on('mysql_second')->create([
            "name" => $req->name,
            "category" => $req->bed_category,
            "nursing_station" => $req->nursing_station,
        ]);

        $data = Bed_List::on('mysql_second')->with('category','nursing')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Bed List Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method



    // Edit Bed List
    public function Edit(Request $req){
        $data = Bed_List::on('mysql_second')
        ->with('category','nursing')
        ->findOrFail($req->id);

        return response()->json([
            'status'=> true,
            'data'=> $data,
        ], 200);
    } // End Method



    // Update Bed List
    public function Update(Request $req){
        $data = Bed_List::on('mysql_second')->findOrFail($req->id);
        
        $req->validate([
            "name" => ['required',Rule::unique('mysql_second.bed__lists', 'name')->ignore($data->id)],
            "bed_category" => 'required|exists:mysql_second.bed__categories,id',
            "nursing_station" => 'required|exists:mysql_second.nursing__stations,id',
        ]);

        $update = $data->update([
            "name" => $req->name,
            "category" => $req->bed_category,
            "nursing_station" => $req->nursing_station,
            "updated_at" => now()
        ]);

        $updatedData = Bed_List::on('mysql_second')->with('category','nursing')->findOrFail($req->id);

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



    // Search Bed List
    public function Search(Request $req){
        if($req->searchOption == 1){ // Search By Name
            $data = Bed_List::on('mysql_second')
            ->with('category','nursing')
            ->where('name', 'like', $req->search.'%')
            ->orderBy('name')
            ->paginate(15);
        }
        else if($req->searchOption == 2){ // Search By Bed Category
            $data = Bed_List::on('mysql_second')
            ->with('category','nursing')
            ->whereHas('category', function ($query) use ($req) {
                $query->where('name', 'like', $req->search.'%');
                $query->orderBy('name','asc');
            })
            ->paginate(15);
        }
        else if($req->searchOption == 3){ // Search By Nursing Station
            $data = Bed_List::on('mysql_second')
            ->with('category','nursing')
            ->whereHas('nursing', function ($query) use ($req) {
                $query->where('name', 'like', $req->search.'%');
                $query->orderBy('name','asc');
            })
            ->paginate(15);
        }
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method



    // Get Bed List
    public function Get(Request $req){
        $data = Bed_List::on('mysql_second')
        ->where('name', 'like', $req->bed_list.'%')
        ->where('category',  $req->bed_category)
        ->orderBy('name')
        ->get();

        $list = "<ul>";
            if($data->count() > 0){
                foreach($data as $index => $item) {
                    $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$item->id.'">'.$item->name.'</li>';
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
}