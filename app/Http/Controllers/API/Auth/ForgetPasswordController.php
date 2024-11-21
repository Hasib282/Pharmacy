<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetEmail;
use Illuminate\Support\Str;

use App\Models\User_Info;

class ForgetPasswordController extends Controller
{
    // Send Email With the verification link and store token
    public function ForgotPassword(Request $req){
        $req->validate(['email' => 'required|email']);
        $frontendUrl = $req->frontend_url;
        
        $user = User_Info::where('user_email', $req->email)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'This email address is not registered.',
            ], 404);
        }

        // Generate a unique token
        $token = Str::random(60);

        // Store the token in the password_resets table
        DB::table('password_resets')->updateOrInsert(
            ['email' => $req->email],
            ['token' => Hash::make($token), 'created_at' => now()]
        );

        // Send the email with the reset link
        $resetLink = "{$frontendUrl}/resetpassword?token={$token}&email=" . urlencode($req->email);

        Mail::to($req->email)->send(new PasswordResetEmail($resetLink));

        return response()->json([
            'status' => true,
            'message' => 'Password reset link sent, Please! Check your email',
        ], 200);
    } // End Method



    // Handle the form submission to reset the password
    public function ResetPassword(Request $req)
    {
        $req->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'token' => 'required'
        ]);

        $reset = DB::table('password_resets')->where('email', $req->email)->first();

        if (!$reset || !Hash::check($req->token, $reset->token)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid token or email.',
            ], 404);
        }

        $user = User_Info::where('user_email', $req->email)->first();

        $user->password = Hash::make($req->password);
        $user->save();

        DB::table('password_resets')->where('email', $req->email)->delete();

        return response()->json([
            'status' => true,
            'redirect' => '/login',
            'message' => 'Your password has been successfully reset!',
        ], 200);
    } // End Method
}
