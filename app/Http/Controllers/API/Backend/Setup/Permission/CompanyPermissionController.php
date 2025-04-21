<?php

namespace App\Http\Controllers\API\Backend\Setup\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use App\Models\Company_Type;
use App\Models\Company_Details;
use App\Models\Permission_Company;
use App\Models\Permission_Head;

class CompanyPermissionController extends Controller
{
    // Show All Company Permissions
    public function ShowAll(Request $req){
        $types = Company_Type::on('mysql')->get();
        $data = Company_Details::on('mysql')->with('permissions')->orderBy('company_id')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
            'types' => $types,
        ], 200);
    } // End Method



    // Edit Company Permissions
    public function Edit(Request $req){
        $company = Company_Details::on('mysql')->where('company_id',$req->id)->first();
        $companypermission = Permission_Company::on('mysql')->where('company_id', $req->id)->pluck('permission_id')->toArray();
        $permissions = Permission_Head::on('mysql')->with('mainhead')
        ->orderBy('permission_mainhead')
        ->get()
        ->groupBy('permission_mainhead');
        // ->groupBy(function ($item) {
        //     return $item->mainhead->name;
        // });
        
        return response()->json([
            'status'=> true,
            'permissions'=>$permissions,
            'companypermission'=>$companypermission,
            'company'=>$company
        ], 200);
    } // End Method



    // Update Company Permissions
    public function Update(Request $req){
        $req->validate([
            'company' => 'required|exists:mysql.company__details,company_id',
            'permissions' => 'array',
            'permissions.*' => 'integer|exists:mysql.permission__heads,id',
        ]);

        $company = Company_Details::on('mysql')->where('company_id', $req->company)->first();

        $company->permissions()->sync($req->permissions);


        // Update Company Pemissions Cache
        $company_data = Company_Details::on('mysql')->with('permissions')->where('company_id', $req->company)->first();

        Cache::forget("permission_mainheads_{$req->company}");
        Cache::forget("permission_ids_{$req->company}");

        Cache::rememberForever("permission_mainheads_{$req->company}", function () use ($company_data) {
            return $company_data->permissions->pluck('permission_mainhead')->unique()->toArray();
        });
        
        Cache::rememberForever("permission_ids_{$req->company}", function () use ($company_data) {
            return $company_data->permissions->pluck('id')->unique()->toArray();
        });
        
        return response()->json([
            'status'=> true,
            'message' => 'Company Permissions Added Successfully'
        ], 200);  
    } // End Method



    // Search Company Permissions
    public function Search(Request $req){
        $data = Company_Details::on('mysql')
        ->where('company_name', 'like', $req->search.'%')
        ->where('company_type', 'like', '%'.$req->type.'%')
        ->with('permissions')
        ->orderBy('company_name')
        ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method
    
    
    
    // Get The User From whom you get the permission
    public function UserFrom(Request $req){
        $data = Company_Details::on('mysql')
        ->select('company_name','company_id')
        ->where('company_name', 'like', $req->from.'%')
        ->orderBy('company_name')
        ->take(10)
        ->get();


        $list = "<ul>";
            if($data->count() > 0){
                foreach($data as $index => $item) {
                    $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$item->company_id.'">'.$item->company_name.'('.$item->company_id.')'.'</li>';
                }
            }
            else{
                $list .= '<li>No Data Found</li>';
            }
        $list .= "</ul>";

        return $list;
    } // End Method
    
    
    
    // Get The User To whom you assing the permission
    public function UserTo(Request $req){
        $data = Company_Details::on('mysql')
        ->select('company_name','company_id')
        ->where('company_name', 'like', $req->to.'%')
        ->orderBy('company_name')
        ->take(10)
        ->get();

        $list = "<ul>";
            if($data->count() > 0){
                foreach($data as $index => $item) {
                    $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$item->company_id.'">'.$item->company_name.'('.$item->company_id.')'.'</li>';
                }
            }
            else{
                $list .= '<li>No Data Found</li>';
            }
        $list .= "</ul>";

        return $list;
    } // End Method
    
    
    
    // Copy User Permissions
    public function Copy(Request $req){
        $req->validate([
            'from' => 'required|exists:mysql.company__details,company_id',
            'to' => 'required|exists:mysql.company__details,company_id',
        ]);

        $from = Company_Details::on('mysql')->where('company_id', $req->from)->first();
        $to = Company_Details::on('mysql')->where('company_id', $req->to)->first();

        $fromPermissions = $from->permissions->pluck('id')->toArray();

        $to->permissions()->sync($fromPermissions);
        
        return response()->json([
            'status' => true,
            'message' => 'Company Permissions Copied Successfully'
        ], 200);
    } // End Method
}
