<?php

namespace App\Http\Controllers\API\Backend\Setup\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;

use App\Models\Role;
use App\Models\Login_User;
use App\Models\Permission_User;
use App\Models\Permission_Head;

class UserPermissionController extends Controller
{
    // Show All User Permissions
    public function ShowAll(Request $req){
        $roles = Role::on('mysql')->whereNotIn('id', ['1'])->get();
        if(Auth::user()->user_role == 1){
            $data = Login_User::on('mysql')->whereNotIn('user_role', ['1','4','5'])->with('permissions','company')->orderBy('user_id')->get();
        }
        else{
            $data = Login_User::on('mysql')->whereNotIn('user_role', ['1','4','5'])->whereNotIn('user_id', [Auth::user()->user_id])->with('permissions')->where('company_id', Auth::user()->company_id)->orderBy('user_id')->get();
        }

        $data->getCollection()->transform(function ($user) {
            $user->auth_user_role = Auth::user()->user_role;
            return $user;
        });
        return response()->json([
            'status'=> true,
            'data' => $data,
            'roles' => $roles,
        ], 200);
    } // End Method



    // Edit User Permissions
    public function Edit(Request $req){
        $user = Login_User::on('mysql')->whereNotIn('user_role', ['1','4','5'])->where('user_id',$req->id)->first();
        $userpermission = Permission_User::on('mysql')->where('user_id', $req->id)->pluck('permission_id')->toArray();
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
            'userpermission'=>$userpermission,
            'user'=>$user
        ], 200);
    } // End Method



    // Update User Permissions
    public function Update(Request $req){
        $req->validate([
            'user' => 'required|exists:mysql.login__users,user_id',
            'permissions' => 'array',
            'permissions.*' => 'integer|exists:mysql.permission__heads,id',
        ]);

        $user = Login_User::on('mysql')->whereNotIn('user_id', [Auth::user()->user_id])->where('user_id',$req->user)->first();

        $user->permissions()->sync($req->permissions);

        // Update User Pemissions Cache
        $user_data = Login_User::on('mysql')->with('permissions')->where('user_id',$req->user)->first();

        Cache::forget("permission_mainheads_{$req->user}");
        Cache::forget("permission_ids_{$req->user}");

        Cache::rememberForever("permission_mainheads_{$req->user}", function () use ($user_data) {
            return $user_data->permissions->pluck('permission_mainhead')->unique()->toArray();
        });
        
        Cache::rememberForever("permission_ids_{$req->user}", function () use ($user_data) {
            return $user_data->permissions->pluck('id')->unique()->toArray();
        });
        
        return response()->json([
            'status'=> true,
            'message' => 'User Permissions Added Successfully'
        ], 200);  
    } // End Method



    // Search User Permissions
    public function Search(Request $req){
        if(Auth::user()->user_role == 1) {
            $userpermission = Login_User::on('mysql')
            ->with('permissions','company')
            ->whereNotIn('user_id', [Auth::user()->user_id])
            ->whereNotIn('user_role', ['1','4','5'])
            ->whereNotIn('user_role', ['1'])
            ->where('user_name', 'like', $req->search.'%')
            ->where('user_role', 'like', $req->role.'%')
            ->with('permissions')
            ->orderBy('user_name')
            ->paginate(15);
        }
        else{
            $userpermission = Login_User::on('mysql')
            ->with('permissions','company')
            ->whereNotIn('user_role', ['1','4','5'])
            ->whereNotIn('user_id', [Auth::user()->user_id])
            ->where('company_id', Auth::user()->company_id)
            ->whereNotIn('user_role', ['1'])
            ->where('user_name', 'like', $req->search.'%')
            ->where('user_role', 'like', $req->role.'%')
            ->with('permissions')
            ->orderBy('user_name')
            ->paginate(15);
        }
        

        $userpermission->getCollection()->transform(function ($user) {
            $user->auth_user_role = Auth::user()->user_role;
            return $user;
        });
        
        return response()->json([
            'status' => true,
            'data' => $userpermission,
        ], 200);
    } // End Method
    
    
    
    // Get The User From whom you get the permission
    public function UserFrom(Request $req){
        if(Auth::user()->user_role == 1) {
            $froms = Login_User::on('mysql')
            ->select('user_name','user_id','company_user_id')
            ->whereNotIn('user_role', ['1','4','5'])
            ->where('user_name', 'like', $req->from.'%')
            ->orderBy('user_name')
            ->take(10)
            ->get();
        }
        else{
            $froms = Login_User::on('mysql')
            ->select('user_name','user_id','company_user_id')
            ->whereNotIn('user_role', ['1','4','5'])
            ->where('company_id', Auth::user()->company_id)
            ->where('user_name', 'like', $req->from.'%')
            ->orderBy('user_name')
            ->take(10)
            ->get();
        }

        $list = "<ul>";
            if($froms->count() > 0){
                foreach($froms as $index => $from) {
                    $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$from->user_id.'">'.$from->user_name.'('.(Auth::user()->user_role == 1 ? $from->user_id : $from->company_user_id).')'.'</li>';
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
        if(Auth::user()->user_role == 1) {
            $data = Login_User::on('mysql')
            ->select('user_name','user_id','company_user_id')
            ->where('user_name', 'like', $req->to.'%')
            ->whereNotIn('user_role', ['1','4','5'])
            ->orderBy('user_name')
            ->take(10)
            ->get();
        }
        else{
            $data = Login_User::on('mysql')
            ->select('user_name','user_id','company_user_id')
            ->where('user_name', 'like', $req->to.'%')
            ->whereNotIn('user_role', ['1','4','5'])
            ->where('company_id', Auth::user()->company_id)
            ->orderBy('user_name')
            ->take(10)
            ->get();
        }

        $list = "<ul>";
            if($data->count() > 0){
                foreach($data as $index => $item) {
                    $list .= '<li tabindex="' . ($index + 1) . '" data-id="'.$item->user_id.'">'.$item->user_name.'('.(Auth::user()->user_role == 1 ? $item->user_id : $item->company_user_id).')'.'</li>';
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
            'from' => 'required|exists:mysql.user__infos,user_id',
            'to' => 'required|exists:mysql.user__infos,user_id',
        ]);

        $from = Login_User::on('mysql')->whereNotIn('user_role', ['1','4','5'])->where('user_id', $req->from)->first();
        $to = Login_User::on('mysql')->whereNotIn('user_role', ['1','4','5'])->where('user_id', $req->to)->first();

        $fromPermissions = $from->permissions->pluck('id')->toArray();

        $to->permissions()->sync($fromPermissions);
        
        return response()->json([
            'status' => true,
            'message' => 'User Permissions Copied Successfully'
        ], 200);
    } // End Method
}
