<?php

namespace App\Http\Controllers\Project\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VerifyUserController extends Controller
{

    public function showVerifyUserPage()
    {
        return view('project_views.authentication_views.verify_user');
    }

    public function redirectUser()
    {
        if (Auth::user() != null) {
            $user_role_id = Auth::user()->role_id;
            if ($user_role_id == 1) {
                return redirect()->route('schedule.view');
            } else if ($user_role_id == 2) {
                return redirect()->route('users.view', ['user_type' => 'admins']);
            }
        }
    }
}
