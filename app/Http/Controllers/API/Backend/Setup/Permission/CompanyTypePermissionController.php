<?php

namespace App\Http\Controllers\API\Backend\Setup\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use App\Models\Company_Type;
use App\Models\Permission_Company_Type;
use App\Models\Permission_Head;

class CompanyTypePermissionController extends Controller
{
    // Show All Company Type Permissions
    public function Show(Request $req){
        $data = Company_Type::on('mysql')->with('permissions')->orderBy('id')->get();
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Edit Company Type Permissions
    public function Edit(Request $req){
        $type = Company_Type::on('mysql')->where('id',$req->id)->first();
        $companytypepermission = Permission_Company_Type::on('mysql')->where('company_type_id', $req->id)->pluck('permission_id')->toArray();
        $permissions = Permission_Head::on('mysql')->with('mainhead')
        ->orderBy('permission_mainhead')
        ->get()
        ->groupBy('permission_mainhead');

        return response()->json([
            'status'=> true,
            'permissions'=>$permissions,
            'companytypepermission'=>$companytypepermission,
            'type'=>$type
        ], 200);
    } // End Method



    // Update Company Type Permissions
    public function Update(Request $req){
        $type = Company_Type::on('mysql')->findOrFail($req->type);

        $req->validate([
            'type' => 'required|exists:mysql.company__types,id',
            'permissions' => 'array',
            'permissions.*' => 'integer|exists:mysql.permission__heads,id',
        ]);

        $type->permissions()->sync($req->permissions);

        // Update Company Type Pemissions Cache
        $updatedData = Company_Type::on('mysql')->with('permissions')->findOrFail($req->type);

        Cache::forget("permission_mainheads_{$req->type}");
        Cache::forget("permission_ids_{$req->type}");

        Cache::rememberForever("permission_mainheads_{$req->type}", function () use ($updatedData) {
            return $updatedData->permissions->pluck('permission_mainhead')->unique()->toArray();
        });
        
        Cache::rememberForever("permission_ids_{$req->type}", function () use ($updatedData) {
            return $updatedData->permissions->pluck('id')->unique()->toArray();
        });
        
        return response()->json([
            'status'=> true,
            'message' => 'Company Type Permissions Added Successfully',
            "updatedData" => $updatedData,
        ], 200);  
    } // End Method



    // Search Company Type Permissions
    public function Search(Request $req){
        $data = Company_Type::on('mysql')
        ->where('name', 'like', $req->search.'%')
        ->with('permissions')
        ->orderBy('name')
        ->get();
        
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    } // End Method
}
