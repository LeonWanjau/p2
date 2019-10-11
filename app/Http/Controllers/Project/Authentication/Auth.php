<?php

namespace App\Http\Controllers\Project\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory as View;
use App\Http\Requests\CreateAccount;
use App\Http\Requests\Login;
use App\Http\Requests\SendPasswordResetLink;
use App\Http\Requests\ResetPassword;
use Illuminate\Support\Facades\Log;
use App\ProjectModels\User;
//use Illuminate\Contracts\Hashing\Hasher as Hash;
use Illuminate\Auth\AuthManager;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
//use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth as AuthF;
use Illuminate\Validation\ValidationException;

class Auth extends Controller
{

    use VerifiesEmails;

    public function __construct()
    {
        /*
         $this->middleware('signed')->only('verify');
         $this->middleware('auth')->only('verify');
         */ }

    protected function redirectTo()
    {
        return route('home.show');
        //return '/home';
        //return route('show_login');
    }

    public function showCreateAccount(View $view)
    {
        return $view->make('project_views/authentication_views/create_account');
    }

    public function createAccount(CreateAccount $request, AuthManager $auth)
    {
        //$log->channel('single')->info($request->all());

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
            'dob' => $data['dob'],
            'phone_number' => $data['phone_number'],
            'role_id' => $role_id,
        ]);


        //$user = $auth->user();

        event(new Registered($user));

        if ($auth->attempt($request->only('email', 'password'), true)) {
            return redirect($this->redirectPath());
        }


        //$auth->guard()->login($user);

        return "Login Failed";
    }

    public function verify(Request $request)
    {
        if ($request->route('id') != $request->user()->getKey()) {
            throw new AuthorizationException;
        }

        if ($request->user()->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect(route('home.show'))->with('verified', true);
    }

    public function showLogin(View $view)
    {
        if (AuthF::check()) {
            return redirect(route('home.show'));
         } else {
            return $view->make('project_views.authentication_views.login');
        }
    }

    public function login(Login $request, AuthManager $auth)
    {
        if ($auth->attempt($request->only('email', 'password'), true)) {
            return redirect(route('home.show'));
        } else {
            throw ValidationException::withMessages([
                'email' => ["Wrong email or password"],
            ]);
        }
    }

    public function logout(AuthManager $auth)
    {
        $auth->logout();

        return redirect(route('show_login'));
    }

    public function showPasswordResetLink(View $view)
    {
        return $view->make('project_views.authentication_views.send_reset_password');
    }

    public function showPasswordReset(View $view, Request $request, $token)
    {
        return $view->make('project_views.authentication_views.reset_password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function showPasswordResetStatus(View $view)
    {
        return $view->make('project_views.authentication_views.password_reset_status');
    }

    public function sendResetLinkEmail(SendPasswordResetLink $request)
    {
        $response = Password::broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }

    protected function sendResetLinkResponse($request, $response)
    {
        return back()->with('status', trans($response));
    }

    protected function sendResetLinkFailedResponse($request, $response)
    {
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
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
            ? $this->sendResetResponse($request, $response)
            : $this->sendResetFailedResponse($request, $response);
    }

    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        // event(new PasswordReset($user));

        AuthF::guard()->login($user);
    }

    protected function sendResetResponse(Request $request, $response)
    {
        return redirect($this->redirectPath())
            ->with('status', trans($response));
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }
}
