<?php

namespace App\Http\Controllers\API\Backend\Admin_Setup\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Role;
use App\Models\User_Info;
use App\Models\Permission_User;
use App\Models\Permission_Head;

class UserPermissionController extends Controller
{
    // Show All User Permissions
    public function ShowAll(Request $req){
        $roles = Role::whereNotIn('id', ['1'])->get();
        $userpermission = User_Info::whereNotIn('user_role', ['1'])->with('permissions')->orderBy('user_name')->paginate(15);
        return response()->json([
            'status'=> true,
            'data' => $userpermission,
            'roles' => $roles,
        ], 200);
    } // End Method



    // Edit User Permissions
    public function Edit(Request $req){
        $user = User_Info::whereNotIn('user_role', ['1'])->where('user_id',$req->id)->first();
        $userpermission = Permission_User::where('user_id', $req->id)->pluck('permission_id')->toArray();
        $permissions = Permission_Head::with('mainhead')
        ->orderBy('permission_mainhead')
        ->get()
        ->groupBy('permission_mainhead');
        // ->groupBy(function ($item) {
        //     return $item->mainhead->name;
        // });
        
        return response()->json([
            'status'=> true,
            'permissions'=>$permissions,
            'userpermission'=>$userpermission,
            'user'=>$user
        ], 200);
    } // End Method



    // Update User Permissions
    public function Update(Request $req){
        $req->validate([
            'user' => 'required|exists:user__infos,user_id',
            'permissions' => 'array',
            'permissions.*' => 'integer|exists:permission__heads,id',
        ]);

        $user = User_Info::where('user_id',$req->user)->first();

        $user->permissions()->sync($req->permissions);
        
        return response()->json([
            'status'=> true,
            'message' => 'User Permissions Added Successfully'
        ], 200);  
    } // End Method



    // Search User Permissions
    public function Search(Request $req){
        $userpermission = User_Info::whereNotIn('user_role', ['1'])
        ->where('user_name', 'like', '%'.$req->search.'%')
        ->where('user_role', 'like', '%'.$req->role.'%')
        ->with('permissions')
        ->orderBy('user_name')
        ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $userpermission,
        ], 200);
    } // End Method
    
    
    
    // Get The User From whom you get the permission
    public function UserFrom(Request $req){
        $froms = User_Info::select('user_name','user_id')
        ->where('user_name', 'like', '%'.$req->from.'%')
        ->orderBy('user_name')
        ->take(10)
        ->get();


        if($froms->count() > 0){
            $list = "";
            foreach($froms as $index => $from) {
                $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$from->user_id.'">'.$from->user_name.'('.$from->user_id.')'.'</li>';
            }
        }
        else{
            $list = '<li>No Data Found</li>';
        }
        return $list;
    } // End Method
    
    
    
    
    // Get The User To whom you assing the permission
    public function UserTo(Request $req){
        $tos = User_Info::select('user_name','user_id')
        ->where('user_name', 'like', '%'.$req->to.'%')
        ->orderBy('user_name')
        ->take(10)
        ->get();


        if($tos->count() > 0){
            $list = "";
            foreach($tos as $index => $to) {
                $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$to->user_id.'">'.$to->user_name.'('.$to->user_id.')'.'</li>';
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
            'from' => 'required|exists:user__infos,user_id',
            'to' => 'required|exists:user__infos,user_id',
        ]);

        $from = User_Info::where('user_id', $req->from)->first();
        $to = User_Info::where('user_id', $req->to)->first();

        $fromPermissions = $from->permissions->pluck('id')->toArray();

        $to->permissions()->sync($fromPermissions);
        
        return response()->json([
            'status' => true,
            'message' => 'User Permissions Copied Successfully'
        ], 200);
    } // End Method
}
