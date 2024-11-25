<?php

namespace App\Http\Controllers\Frontend\Admin_Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /////////////////////////// --------------- Permission Main Head Methods start ---------- //////////////////////////
    // Show All PermissionMainheads
    public function ShowPermissionMainheads(Request $req){
        $name = "Permission Main Head";
        $js = 'admin_setup/permission/permission_mainheads';
        if ($req->ajax()) {
            return view('common_modals.single_input.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('common_modals.single_input.singleData', compact('name', 'js'));
        }
    } // End Method



    // Search Permission Main Heads 
    public function SearchPermissionMainheads(){
        $name = "Permission Main Head";
        $js = 'admin_setup/permission/permission_mainheads';
        return view('common_modals.single_input.singleData', compact('name', 'js'));
    } // End Method
    /////////////////////////// --------------- Permission Main Heads Methods End ---------- //////////////////////////
    
    
    
    
    
    /////////////////////////// --------------- Permissions Methods start ---------- //////////////////////////
    // Show All Permissions
    public function ShowPermissions(Request $req){
        $name = "Permissions";
        if ($req->ajax()) {
            return view('admin_setup.permission.permissions.ajaxBlade', compact('name'));
        }
        else{
            return view('admin_setup.permission.permissions.permissions', compact('name'));
        }
    } // End Method



    // Search Permissions 
    public function SearchPermissions(){
        $name = "Permissions";
        return view('admin_setup.permission.permissions.permissions', compact('name'));
    } // End Method
    /////////////////////////// --------------- Permissions Methods End ---------- //////////////////////////





    /////////////////////////// --------------- Route Permission Methods Start ---------- //////////////////////////
    // Show Route Permission
    public function ShowRoutePermissions(Request $req){
        $name = "Route Permission";
        if ($req->ajax()) {
            return view('admin_setup.permission.route_permission.ajaxBlade', compact('name'));
        }
        else{
            return view('admin_setup.permission.route_permission.routePermission', compact('name'));
        }
    } // End Method



    // Search Route Permissions 
    public function SearchRoutePermissions(){
        $name = "Route Permission";
        return view('admin_setup.permission.route_permission.routePermission', compact('name'));
    } // End Method
    /////////////////////////// --------------- Route Permission Methods End ---------- //////////////////////////

    
    
    

    /////////////////////////// --------------- Role Permission Methods Start ---------- //////////////////////////
    // Show Role Permission
    public function ShowRolePermissions(Request $req){
        $name = "Role Permission";
        if ($req->ajax()) {
            return view('admin_setup.permission.role_permission.ajaxBlade', compact('name'));
        }
        else{
            return view('admin_setup.permission.role_permission.rolePermission', compact('name'));
        }
    } // End Method



    // Search Role Permissions 
    public function SearchRolePermissions(){
        $name = "Role Permission";
        return view('admin_setup.permission.role_permission.rolePermission', compact('name'));
    } // End Method
    /////////////////////////// --------------- Role Permission Methods End ---------- //////////////////////////





    /////////////////////////// --------------- User Permission Methods Start ---------- //////////////////////////
    // Show User Permission
    public function ShowUserPermissions(Request $req){
        $name = "User Permission";
        if ($req->ajax()) {
            return view('admin_setup.permission.user_permission.ajaxBlade', compact('name'));
        }
        else{
            return view('admin_setup.permission.user_permission.userPermission', compact('name'));
        }
    } // End Method



    // Search User Permissions 
    public function SearchUserPermissions(){
        $name = "User Permission";
        return view('admin_setup.permission.user_permission.userPermission', compact('name'));
    } // End Method
    /////////////////////////// --------------- User Permission Methods End ---------- //////////////////////////
}
