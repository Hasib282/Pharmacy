<?php

namespace App\Http\Controllers\API\Backend\Setup\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;

use App\Models\Role;
use App\Models\Login_User;
use App\Models\Company_Details;
use App\Models\Permission_User;
use App\Models\Permission_Head;

class UserPermissionController extends Controller
{
    // Show All User Permissions
    public function Show(Request $req){
        if(Auth::user()->user_role == 1){
            $data = Login_User::on('mysql')->whereNotIn('user_role', ['1','4','5'])->with('permissions','company')->orderBy('user_id')->get();
        }
        else{
            $data = Login_User::on('mysql')->whereNotIn('user_role', ['1','4','5'])->whereNotIn('user_id', [Auth::user()->user_id])->with('permissions')->where('company_id', Auth::user()->company_id)->orderBy('user_id')->get();
        }

        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Edit User Permissions
    public function Edit(Request $req){
        $user = Login_User::on('mysql')->whereNotIn('user_role', ['1','4','5'])->where('user_id',$req->id)->first();
        $userpermission = Permission_User::on('mysql')->where('user_id', $req->id)->pluck('permission_id')->toArray();
        $companyPermission = Company_Details::on('mysql')->with('permissions')->where('company_id', $user->company_id)->first()->permissions->pluck('id')->toArray();
        
        $permissions = Permission_Head::on('mysql')
        ->with('mainhead')
        ->whereIn('id', $companyPermission)
        ->orderBy('permission_mainhead')
        ->get()
        ->groupBy('permission_mainhead');


        $groupedPermissions = [];

        foreach ($permissions as $mainheadId => $group) {
            foreach ($group as $permission) {
                // dd($permission->name);
                $name = $permission->name;
                $groupKey = 'Other';

                // Custom grouping logic
                if (str_contains($name, ' Admin')) $groupKey = 'Admin';
                elseif (str_contains($name, 'Roles')) $groupKey = 'Roles';
                elseif (str_contains($name, 'Permissions')) $groupKey = 'Permissions';
                elseif (str_contains($name, 'Banks')) $groupKey = 'Banks';
                elseif (str_contains($name, 'Locations')) $groupKey = 'Locations';
                elseif (str_contains($name, 'Stores')) $groupKey = 'Stores';
                elseif (str_contains($name, 'Payment Methods')) $groupKey = 'Payment Methods';
                elseif (str_contains($name, 'Corporate')) $groupKey = 'Corporate';

                elseif (str_contains($name, 'Groupes')) $groupKey = 'Groupes';
                elseif (str_contains($name, 'Service / Product')) $groupKey = 'Service / Product';
                elseif (str_contains($name, 'Client/Supplier')) $groupKey = 'Client/Supplier';
                elseif (str_contains($name, 'Clients')) $groupKey = 'Clients';
                elseif (str_contains($name, 'Suppliers')) $groupKey = 'Suppliers';
                elseif (str_contains($name, 'Transaction With Client')) $groupKey = 'Transaction With Client';
                elseif (str_contains($name, 'Transaction With Supplier')) $groupKey = 'Transaction With Supplier';
                elseif (str_contains($name, 'From Client')) $groupKey = 'From-Client';
                elseif (str_contains($name, 'To Supplier')) $groupKey = 'To-Supplier';

                elseif (str_contains($name, 'Bank Withdraw')) $groupKey = 'Bank-Withdraws';
                elseif (str_contains($name, 'Bank Deposit')) $groupKey = 'Bank-Deposits';

                elseif (str_contains($name, 'Employee Type')) $groupKey = 'Employee Type';
                elseif (str_contains($name, 'All Employee')) $groupKey = 'All-Employee';
                elseif (str_contains($name, 'Personal')) $groupKey = 'Employee-Personal-Details';
                elseif (str_contains($name, 'Education')) $groupKey = 'Employee-Education-Details';
                elseif (str_contains($name, 'Trainning')) $groupKey = 'Employee-Trainning-Details';
                elseif (str_contains($name, 'Experience')) $groupKey = 'Employee-Experience-Details';
                elseif (str_contains($name, 'Organization')) $groupKey = 'Employee-Organization-Details';
                elseif (str_contains($name, 'Attandence')) $groupKey = 'Attendance';
                elseif (str_contains($name, 'Payroll Setup')) $groupKey = 'Payroll-Setup';
                elseif (str_contains($name, 'Middleware')) $groupKey = 'Payroll-Middleware';
                elseif (str_contains($name, 'Process')) $groupKey = 'Payroll-Process';
                elseif (str_contains($name, 'Department')) $groupKey = 'Department';
                elseif (str_contains($name, 'Designation')) $groupKey = 'Designation';
                elseif (str_contains($name, 'Salary') && str_contains($name, 'Report')) $groupKey = 'Salary-Report';

                elseif (str_contains($name, 'Manufacturer')) $groupKey = 'Manufacturer';
                elseif (str_contains($name, 'Category')) $groupKey = 'Category';
                elseif (str_contains($name, 'Unit')) $groupKey = 'Unit';
                elseif (str_contains($name, 'Form')) $groupKey = 'Form';
                elseif (str_contains($name, 'Product')) $groupKey = 'Product';
                elseif (str_contains($name, 'Purchase') && str_contains($name, 'Transaction')) $groupKey = 'Purchase-Transaction';
                elseif (str_contains($name, 'Issue') && str_contains($name, 'Transaction')) $groupKey = 'Issue-Transaction';
                elseif (str_contains($name, 'Client Return') && str_contains($name, 'Transaction')) $groupKey = 'Client-Return-Transaction';
                elseif (str_contains($name, 'Supplier Return') && str_contains($name, 'Transaction')) $groupKey = 'Supplier-Return-Transaction';
                elseif (str_contains($name, 'Positive')) $groupKey = 'Positive';
                elseif (str_contains($name, 'Negative')) $groupKey = 'Negative';

                

                elseif (str_contains($name, 'Balance Sheet')) $groupKey = 'Balance-Sheet';
                elseif (str_contains($name, 'Account Statement')) $groupKey = 'Account-Statement';
                elseif (str_contains($name, 'Party Statement')) $groupKey = 'Party-Statement';

                $groupedPermissions[$permission->mainhead->name ?? 'Uncategorized'][$groupKey][] = [
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'checked' => in_array($permission->id, $userpermission),
                    'permission_mainhead' => $permission->permission_mainhead,
                ];
            }
        }
        
        return response()->json([
            'status'=> true,
            'permissions'=>$permissions,
            'userpermission'=>$userpermission,
            'user'=>$user,
            'groupedPermissions'=>$groupedPermissions
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
        $updatedData = Login_User::on('mysql')->with('permissions')->where('user_id',$req->user)->first();

        Cache::forget("permission_mainheads_{$req->user}");
        Cache::forget("permission_ids_{$req->user}");

        Cache::rememberForever("permission_mainheads_{$req->user}", function () use ($updatedData) {
            return $updatedData->permissions->pluck('permission_mainhead')->unique()->toArray();
        });
        
        Cache::rememberForever("permission_ids_{$req->user}", function () use ($updatedData) {
            return $updatedData->permissions->pluck('id')->unique()->toArray();
        });
        
        return response()->json([
            'status'=> true,
            'message' => 'User Permissions Added Successfully',
            "updatedData" => $updatedData,
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
            'from' => 'required|exists:mysql_second.user__infos,user_id',
            'to' => 'required|exists:mysql_second.user__infos,user_id',
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
