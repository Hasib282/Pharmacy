<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    // Login Function
    public function Login(Request $req){
        $req->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $req->remember;

        if(Auth::attempt(['user_email' => $req->email, 'password' => $req->password], $remember)){
            // Log out the user if they are not active
            if (Auth::user()->status != 1) {
                Auth::logout(); 
                return response()->json([
                    'status' => false,
                    'notice' => 'Your account is not active. Please contact support.',
                ], 401);
            }
            
            // Remember me funtionality
            $remember_time = time() + (180 * 24 * 60 * 60); // 6 Month
            if ($remember){
                setcookie("email", $req->email, $remember_time, "/login", "", true, true);
            }
            else{
                setcookie("email","");
            }

            $user = Auth::user();

            $token = $user->createToken('API Token')->plainTextToken;
            
            return response()->json([
                'status' => true,
                'notice' => 'User Logged in Successfully',
                'token' => $token,
                'token_type' => 'bearer'
            ], 200);
        }

        return response()->json([
            'status' => false,
            'notice' => 'Email or Password is incorrect.',
        ], 401);
    } // End Method



    // Logout Function
    public function Logout(Request $req){
        $user = $req->user();
        
        Cache::forget("permission_mainheads_{$user->user_id}");
        Cache::forget("permission_ids_{$user->user_id}");
        Cache::forget("route_permissions_{$user->user_id}");

        // session()->forget('api_token');
        session()->flush();

        $user->tokens()->delete();
        return response()->json([
            'status' => true,
            'message' => 'Logged out Successfully',
        ], 200);
    } // End Method
    


    // Load Sidebar Function
    public function Sidebar(Request $req){
        return response()->json([
            'status' => true,
            'data' => view('layouts.sidebar')->render(),
        ], 200);
    } // End Method
}
