<?php

namespace App\Http\Controllers\API\Backend\Admin_Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\Company_Details;
use App\Models\Company_Type;
use App\Models\Transaction_Main;

class CompanyController extends Controller
{
    // Show All Companies
    public function ShowAll(Request $req){
        $company = Company_Details::with('Type')->orderBy('added_at','asc')->paginate(15);
        $type = Company_Type::get();
        return response()->json([
            'status'=> true,
            'data' => $company,
            'type' => $type,
        ], 200);
    } // End Method



    // Insert Companies
    public function Insert(Request $req){
        $req->validate([
            "name" => 'required',
            "phone" => 'required|numeric|unique:company__details,company_phone',
            "email" => 'required|email|unique:company__details,company_email',
            'image' => 'mimes:jpg,jpeg,png,gif|max:2048',
        ]);


        DB::transaction(function () use ($req) {
            // Generates Auto Increment Company Id
            $latestId = Company_Details::orderBy('company_id','desc')->first();
            $id = ($latestId) ? 'CO' . str_pad((intval(substr($latestId->company_id, 2)) + 1), 9, '0', STR_PAD_LEFT) : 'CO000000001';

            if ($req->hasFile('image') && $req->file('image')->isValid()) {
                $originalName = $req->file('image')->getClientOriginalName();
                $logoName = $id. '('. $req->name . ').' . $req->file('image')->getClientOriginalExtension();
                $imagePath = $req->file('image')->storeAs('logos', $logoName);
                \Log::info("Image stored at: $imagePath");
            }
            else{
                $logoName = null;
            }

            $company = Company_Details::insert([
                "company_id" => $id,
                "company_type" => $req->type,
                "company_name" => $req->name,
                "company_phone" => $req->phone,
                "company_email" => $req->email,
                "address" => $req->address,
                "logo" => $logoName,
            ]);
        });
        
        return response()->json([
            'status'=> true,
            'message' => 'Company Details Added Successfully'
        ], 200);
    } // End Method



    // Edit Companies
    public function Edit(Request $req){
        $company = Company_Details::with('Type')->findOrFail($req->id);
        $type = Company_Type::get();
        return response()->json([
            'status'=> true,
            'company'=> $company,
            'type'=> $type,
        ], 200);
    } // End Method



    // Update Companies
    public function Update(Request $req){
        $company = Company_Details::findOrFail($req->id);

        $req->validate([
            "name" => 'required',
            "phone" => ['required','numeric',Rule::unique('company__details', 'company_phone')->ignore($company->id)],
            "email" => ['required','email',Rule::unique('company__details', 'company_email')->ignore($company->id)],
        ]);

        DB::transaction(function () use ($req) {
            $company = Company_Details::findOrFail($req->id);
            $path = 'public/logos/'.$company->logo;
            
            if($req->image != null){
                $req->validate([
                    "image" => 'image|mimes:jpg,jpeg,png,gif|max:2048',
                ]);

                //process the image name and store it to storage/app/public/profiles directory
                if ($req->hasFile('image') && $req->file('image')->isValid()) {
                    Storage::delete($path);
                    $logoName = $req->company_id. '('. $req->name . ').' . $req->file('image')->getClientOriginalExtension();
                    $imagePath = $req->file('image')->storeAs('logos', $logoName);
                }
            }
            else{
                $logoName = $company->logo;
            }


            $update = Company_Details::findOrFail($req->id)->update([
                "company_type" => $req->type,
                "company_name" => $req->name,
                "company_phone" => $req->phone,
                "company_email" => $req->email,
                "address" => $req->address,
                "logo" => $logoName,
                "updated_at" => now(),
            ]);
        });
        
        return response()->json([
            'status'=>true,
            'message' => 'Company Details Updated Successfully',
        ], 200); 
    } // End Method



    // Delete Companies
    public function Delete(Request $req){
        $company = Company_Details::findOrFail($req->id);
        $path = 'public/logos/'.$company->logo;
        Storage::delete($path);
        $company->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Company Details Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Companies
    public function Search(Request $req){
        if($req->searchOption == 1){
            $company = Company_Details::with('Type')
            ->where('company_name', 'like', '%'.$req->search.'%')
            ->orderBy('company_name','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 2){
            $company = Company_Details::with('Type')
            ->where('company_email', 'like', '%'.$req->search.'%')
            ->orderBy('company_email','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 3){
            $company = Company_Details::with('Type')
            ->where('company_phone', 'like', '%'.$req->search.'%')
            ->orderBy('company_phone','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 4){
            $company = Company_Details::with('Type')
            ->where('address', 'like', '%'.$req->search.'%')
            ->orderBy('address','asc')
            ->paginate(15);
        }
        else if($req->searchOption == 5){
            $company = Company_Details::with('Type')
            ->whereHas('Type', function ($query) use ($req) {
                $query->where('name', 'like', '%'.$req->search.'%');
                $query->orderBy('name','asc');
            })
            ->paginate(15);
        }
        
        return response()->json([
            'status' => true,
            'data' => $company,
        ], 200);
    } // End Method



    // Get Companies
    public function Get(Request $req){
        $companies = Company_Details::select('company_name','company_id')
        ->where('company_name', 'like', '%'.$req->company.'%')
        ->orderBy('company_name')
        ->take(10)
        ->get();


        if($companies->count() > 0){
            $list = "";
            foreach($companies as $index => $company) {
                $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$company->company_id.'">'.$company->company_name.'</li>';
            }
        }
        else{
            $list = '<li>No Data Found</li>';
        }
        return $list;
    } // End Method



    // Show Companies Details
    public function Details(Request $req){
        $apiUrl = Str::replaceLast('/api', '', env('API_URL'));
        $company = Company_Details::with('Type')->findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'data'=>view('admin_setup.company.details', compact('company','apiUrl'))->render(),
        ]);
    } // End Method
}
