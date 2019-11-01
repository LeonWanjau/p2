<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VerifyUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user() != null){

            $user=Auth::user();

            if($user->user_verified_at == null){

                return redirect()->route('verification.user.show');
            }
        }

        return $next($request);
    }
}
