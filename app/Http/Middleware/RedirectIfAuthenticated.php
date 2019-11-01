<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
           // return redirect('/home');
           //return redirect(route('home.show'));
           if (Auth::user() != null) {
            $user_role_id = Auth::user()->role_id;
            if ($user_role_id == 1) {
                return redirect(route('schedule.view'));
            } else if ($user_role_id == 2) {
                return redirect(route('users.view', ['user_type' => 'admins']));
            }
        }
        }

        return $next($request);
    }
}
