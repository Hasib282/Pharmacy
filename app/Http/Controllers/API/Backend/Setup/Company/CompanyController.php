<?php

namespace App\Http\Controllers\API\Backend\Setup\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\Company_Details;
use App\Models\Company_Type;

class CompanyController extends Controller
{
    // Show All Companies
    public function Show(Request $req){
        $data = Company_Details::on('mysql')->with('Type')->orderBy('added_at','asc')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Companies
    public function Insert(Request $req){
        $req->validate([
            "type" => 'required|exists:mysql.company__types,id',
            "name" => 'required',
            "phone" => 'required|numeric|unique:mysql.company__details,company_phone',
            "email" => 'required|email|unique:mysql.company__details,company_email',
            'image' => 'mimes:jpg,jpeg,png,gif|max:2048',
            "domain" => 'required',
        ]);

        $data = null;

        DB::transaction(function () use ($req, &$data) {
            // Generates Auto Increment Company Id
            $latestId = Company_Details::on('mysql')->orderBy('company_id','desc')->first();
            $id = ($latestId) ? 'CO' . str_pad((intval(substr($latestId->company_id, 2)) + 1), 9, '0', STR_PAD_LEFT) : 'CO000000001';
            $imageName = StoreUserImage($req, $id);

            $insert = Company_Details::on('mysql')->create([
                "company_id" => $id,
                "company_type" => $req->type,
                "company_name" => $req->name,
                "company_phone" => $req->phone,
                "company_email" => $req->email,
                "address" => $req->address,
                "website" => $req->website,
                "domain" => $req->domain,
                "logo" => $imageName,
            ]);
            
            $data = Company_Details::on('mysql')->findOrFail($insert->id);
        });
        
        return response()->json([
            'status'=> true,
            'message' => 'Company Details Added Successfully',
            "data" => $data,
        ], 200);
    } // End Method



    // Update Companies
    public function Update(Request $req){
        $data = Company_Details::on('mysql')->findOrFail($req->id);

        $req->validate([
            "type" => 'required|exists:mysql.company__types,id',
            "name" => 'required',
            "phone" => ['required','numeric',Rule::unique('mysql.company__details', 'company_phone')->ignore($data->id)],
            "email" => ['required','email',Rule::unique('mysql.company__details', 'company_email')->ignore($data->id)],
            "domain" => 'required',
        ]);

        DB::transaction(function () use ($req, $data) {
            $imageName = UpdateUserImage($req, $data->logo, null, $data->company_id);

            $data->update([
                "company_type" => $req->type,
                "company_name" => $req->name,
                "company_phone" => $req->phone,
                "company_email" => $req->email,
                "address" => $req->address,
                "website" => $req->website,
                "domain" => $req->domain,
                "logo" => $imageName,
                "updated_at" => now(),
            ]);
        });

        $updatedData = Company_Details::on('mysql')->with('Type')->findOrFail($req->id);
        
        return response()->json([
            'status'=>true,
            'message' => 'Company Details Updated Successfully',
            "updatedData" => $updatedData,
        ], 200); 
    } // End Method



    // Delete Companies
    public function Delete(Request $req){
        $company = Company_Details::on('mysql')->findOrFail($req->id);
        if($company->logo){
            Storage::disk('public')->delete($company->logo);
        }
        $company->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Company Details Deleted Successfully',
        ], 200);
    } // End Method



    // Delete Companies Status
    public function DeleteStatus(Request $req){
        $data = Company_Details::on('mysql')->findOrFail($req->id);
        $data->update(['status' => $data->status == 0 ? 1 : 0]);

        $updatedData = Company_Details::on('mysql')->with('Type')->findOrFail($req->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Company Details Deleted Successfully',
            'updatedData' => $updatedData
        ], 200);
    } // End Method



    // Get Companies
    public function Get(Request $req){
        $data = Company_Details::on('mysql')
        ->select('company_name','company_id')
        ->where('company_name', 'like', $req->company.'%')
        ->orderBy('company_name')
        ->take(10)
        ->get();

        $list = "<ul>";
            if($data->count() > 0){
                foreach($data as $index => $item) {
                    $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$item->company_id.'">'.$item->company_name.'</li>';
                }
            }
            else{
                $list .= '<li>No Data Found</li>';
            }
        $list .= "</ul>";

        return $list;
    } // End Method



    // Show Companies Details
    public function Details(Request $req){
        $apiUrl = Str::replaceLast('/api', '', env('API_URL'));
        $company = Company_Details::on('mysql')->with('Type')->findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'data'=> view('admin_setup.company.details', compact('company','apiUrl'))->render(),
        ]);
    } // End Method
}
