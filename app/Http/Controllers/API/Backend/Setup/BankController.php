<?php

namespace App\Http\Controllers\API\Backend\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Transaction_Main;
use App\Models\Bank;

class BankController extends Controller
{
    // Show All Banks
    public function Show(Request $req){
        $data = Bank::on('mysql')->with('Location')->orderBy('added_at','asc')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Banks
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required',
            "phone" => 'required|numeric|unique:mysql.banks,phone',
            "email" => 'required|email|unique:mysql.banks,email',
            "address" => 'required',
            "location" => 'required|exists:mysql.location__infos,id',
        ]);


        // Generates Auto Increment Bank Id
        $latestId = Bank::on('mysql')->orderBy('user_id','desc')->first();
        $id = ($latestId) ? 'B' . str_pad((intval(substr($latestId->user_id, 1)) + 1), 9, '0', STR_PAD_LEFT) : 'B000000001';


        $insert = Bank::on('mysql')->create([
            "user_id" => $id,
            "name" => $req->name,
            "phone" => $req->phone,
            "email" => $req->email,
            "loc_id" => $req->location,
            "address" => $req->address,
        ]);

        $data = Bank::on('mysql')->with('Location')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Bank Details Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method



    // Update Banks
    public function Update(Request $req){
        $data = Bank::on('mysql')->findOrFail($req->id);

        $req->validate([
            "name" => 'required',
            "phone" => ['required','numeric',Rule::unique('mysql.banks', 'phone')->ignore($data->id)],
            "email" => ['required','email',Rule::unique('mysql.banks', 'email')->ignore($data->id)],
            "address" => 'required',
            "location" => 'required|exists:mysql.location__infos,id',
        ]);


        $update = $data->update([
            "name" => $req->name,
            "phone" => $req->phone,
            "email" => $req->email,
            "loc_id" => $req->location,
            "address" => $req->address,
            "updated_at" => now(),
        ]);

        $updatedData = Bank::on('mysql')->with('Location')->findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Bank Details Updated Successfully',
                "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method



    // Delete Banks
    public function Delete(Request $req){
        Bank::on('mysql')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Bank Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Delete Banks Status
    public function DeleteStatus(Request $req){
        $data = Bank::on('mysql')->findOrFail($req->id);
        $data->update(['status' => $data->status == 0 ? 1 : 0]);
        
        $updatedData = Bank::on('mysql')->with('Location')->findOrFail($req->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Banks Details Deleted Successfully',
            'updatedData' => $updatedData
        ], 200);
    } // End Method



    // Get Banks
    public function Get(Request $req){
        $banks = Bank::on('mysql')
        ->select('name','user_id')
        ->where('name', 'like', $req->bank.'%')
        ->orderBy('name')
        ->take(10)
        ->get();

        $list = "<ul>";
            if($banks->count() > 0){
                foreach($banks as $index => $bank) {
                    $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$bank->user_id.'">'.$bank->name.'</li>';
                }
            }
            else{
                $list .= '<li>No Data Found</li>';
            }
        $list .= "</ul>";

        return $list;
    } // End Method



    // Show Full Bank Details
    public function Details(Request $req){
        $bank = Bank::on('mysql')->with('Location')->where('user_id', $req->id)->first();
        $transaction = Transaction_Main::on('mysql_second')->where('tran_bank', $req->id)->get();
        return response()->json([
            'status' => true,
            'data'=>view('admin_setup.bank.details', compact('bank','transaction'))->render(),
        ]);
    } // End Method
}
