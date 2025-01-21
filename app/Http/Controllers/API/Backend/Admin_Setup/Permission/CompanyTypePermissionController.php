<?php

namespace App\Http\Controllers\API\Backend\Admin_Setup\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use App\Models\Company_Type;
use App\Models\Permission_Company_Type;
use App\Models\Permission_Head;

class CompanyTypePermissionController extends Controller
{
    // Show All Role Permissions
    public function ShowAll(Request $req){
        $companytypepermission = Company_Type::on('mysql')->with('permissions')->orderBy('id')->get();
        return response()->json([
            'status'=> true,
            'data' => $companytypepermission,
        ], 200);
    } // End Method



    // Edit Role Permissions
    public function Edit(Request $req){
        $type = Company_Type::on('mysql')->where('id',$req->id)->first();
        $companytypepermission = Permission_Company_Type::on('mysql')->where('company_type_id', $req->id)->pluck('permission_id')->toArray();
        $permissions = Permission_Head::on('mysql')->with('mainhead')
        ->orderBy('permission_mainhead')
        ->get()
        ->groupBy('permission_mainhead');

        // dd(Cache::get("permission_ids_{$req->id}"));

        return response()->json([
            'status'=> true,
            'permissions'=>$permissions,
            'companytypepermission'=>$companytypepermission,
            'type'=>$type
        ], 200);
    } // End Method



    // Update Role Permissions
    public function Update(Request $req){
        $type = Company_Type::on('mysql')->findOrFail($req->type);

        $req->validate([
            'type' => 'required',
            'permissions' => 'array',
            'permissions.*' => 'integer|exists:mysql.permission__heads,id',
        ]);

        $type->permissions()->sync($req->permissions);

        // Update Company Type Pemissions Cache
        $company_type = Company_Type::on('mysql')->with('permissions')->findOrFail($req->type);

        Cache::forget("permission_mainheads_{$req->type}");
        Cache::forget("permission_ids_{$req->type}");

        Cache::rememberForever("permission_mainheads_{$req->type}", function () use ($company_type) {
            return $company_type->permissions->pluck('permission_mainhead')->unique()->toArray();
        });
        
        Cache::rememberForever("permission_ids_{$req->type}", function () use ($company_type) {
            return $company_type->permissions->pluck('id')->unique()->toArray();
        });
        
        return response()->json([
            'status'=> true,
            'message' => 'Role Permissions Added Successfully'
        ], 200);  
    } // End Method



    // Search Role Permissions
    public function Search(Request $req){
        $companytypepermission = Company_Type::on('mysql')
        ->where('name', 'like', $req->search.'%')
        ->with('permissions')
        ->orderBy('name')
        ->get();
        
        return response()->json([
            'status' => true,
            'data' => $companytypepermission,
        ], 200);
    } // End Method
}
