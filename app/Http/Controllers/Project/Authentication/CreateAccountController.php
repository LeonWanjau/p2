<?php

namespace App\Http\Controllers\Project\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\ProjectModels\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RedirectsUsers;

class CreateAccountController extends Controller
{
    use RedirectsUsers;

    public function redirectTo()
    {
        if (Auth::user() != null) {
            $user_role_id = Auth::user()->role_id;
            if ($user_role_id == 1) {
                return route('schedule.view');
            } else if ($user_role_id == 2) {
                return route('users.view', ['user_type' => 'admins']);
            }
        }
    }

    public function showCreateAccountForm()
    {
        return view('project_views.authentication_views.create_account');
    }

    public function createAccount(CreateAccount $request)
    {
        $data = $request->all();

        if ($data['role'] == 'teacher') {
            $role_id = 1;
        } else if ($data['role'] == 'administrative_staff') {
            $role_id = 2;
        }

        $user = User::create([
            'f_name' => $data['first_name'],
            'l_name' => $data['last_name'],
            'password' => Hash::make($data['password']),
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'role_id' => $role_id,
        ]);

        event(new Registered($user));

        Auth::guard()->login($user);

        return redirect($this->redirectPath());
    }
}
