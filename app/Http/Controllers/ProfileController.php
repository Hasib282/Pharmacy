<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\User_Info;

class ProfileController extends Controller
{
    public function ShowProfile(int $userid){
        Gate::authorize('view-profile', $userid);

        $profile = User_Info::findorfail($userid);
        return view('profile.showProfile', compact('profile'));
    }
}
