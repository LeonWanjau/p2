<?php

namespace App\Http\Controllers\Project\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    use RedirectsUsers;

    public function __construct()
    {
       // $this->middleware('guest')->except('logout');
       $this->middleware('preventBackHistory');
    }

    public function redirectTo()
    {
        $user_role_id=Auth::user()->role_id;
        if($user_role_id==1){
            return route('schedule.view');
        }else if($user_role_id==2){
            return route('users.view',['user_type'=>'admins']);
        }
    }

    public function showLoginForm()
    {
        return view('project_views.authentication_views.login');
    }

    public function login(Login $request)
    {
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember_me'))) {
            return redirect($this->redirectPath());
        } else {
            throw ValidationException::withMessages([
                'email' => ['Wrong email or password'],
            ]);
        }
    }

    public function logout(Request $request){
        Auth::guard()->logout();

        $request->session()->invalidate();

        return redirect(route('login.show'));
    }
}
