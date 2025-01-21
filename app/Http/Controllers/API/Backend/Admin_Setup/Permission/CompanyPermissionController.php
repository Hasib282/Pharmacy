<?php

namespace App\Http\Controllers\API\Backend\Admin_Setup\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use App\Models\Company_Type;
use App\Models\Company_Details;
use App\Models\Permission_Company;
use App\Models\Permission_Head;

class CompanyPermissionController extends Controller
{
    // Show All User Permissions
    public function ShowAll(Request $req){
        $types = Company_Type::on('mysql')->get();
        $companypermission = Company_Details::on('mysql')->with('permissions')->orderBy('company_id')->paginate(15);
        return response()->json([
            'status'=> true,
            'data' => $companypermission,
            'types' => $types,
        ], 200);
    } // End Method



    // Edit User Permissions
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



    // Update User Permissions
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
            'message' => 'User Permissions Added Successfully'
        ], 200);  
    } // End Method



    // Search User Permissions
    public function Search(Request $req){
        $companypermission = Company_Details::on('mysql')
        ->where('company_name', 'like', $req->search.'%')
        ->where('company_type', 'like', '%'.$req->type.'%')
        ->with('permissions')
        ->orderBy('company_name')
        ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $companypermission,
        ], 200);
    } // End Method
    
    
    
    // Get The User From whom you get the permission
    public function UserFrom(Request $req){
        $froms = Company_Details::on('mysql')
        ->select('company_name','company_id')
        ->where('company_name', 'like', $req->from.'%')
        ->orderBy('company_name')
        ->take(10)
        ->get();


        if($froms->count() > 0){
            $list = "";
            foreach($froms as $index => $from) {
                $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$from->company_id.'">'.$from->company_name.'('.$from->company_id.')'.'</li>';
            }
        }
        else{
            $list = '<li>No Data Found</li>';
        }
        return $list;
    } // End Method
    
    
    
    
    // Get The User To whom you assing the permission
    public function UserTo(Request $req){
        $tos = Company_Details::on('mysql')
        ->select('company_name','company_id')
        ->where('company_name', 'like', $req->to.'%')
        ->orderBy('company_name')
        ->take(10)
        ->get();


        if($tos->count() > 0){
            $list = "";
            foreach($tos as $index => $to) {
                $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$to->company_id.'">'.$to->company_name.'('.$to->company_id.')'.'</li>';
            }
        }
        else{
            $list = '<li>No Data Found</li>';
        }
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
