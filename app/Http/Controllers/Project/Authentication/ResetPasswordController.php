<?php

namespace App\Http\Controllers\Project\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPassword;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{

    use RedirectsUsers;

    public function redirectTo()
    {
        return route('home.show');
    }

    public function showPasswordResetForm(Request $request, $token = null)
    {
        return view('project_views.authentication_views.reset_password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(ResetPassword $request)
    {
        $response = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        return $response == Password::PASSWORD_RESET
                    ? $this->sendResetResponse($response)
                    : $this->sendResetFailedResponse($request, $response);
    }

    public function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->setRememberToken(Str::random(60));
        $user->save();
        Auth::guard()->login($user);
    }

    public function sendResetResponse($response)
    {
        return redirect($this->redirectPath())
            ->with('status', trans($response));
    }

    public function sendResetFailedResponse($request, $response)
    {
        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }
}
