<?php

namespace App\Http\Controllers\Project\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SendPasswordResetLink;
use Illuminate\Support\Facades\Password;


class ForgotPasswordController extends Controller
{ 

    public function showLinkRequestForm(){
        return view('project_views.authentication_views.send_reset_password');
    }

    public function sendResetLinkEmail(SendPasswordResetLink $request){
        $response=Password::broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($response)
                    : $this->sendResetLinkFailedResponse($request, $response);
    }

    public function sendResetLinkResponse($response){
        return back()->with('status',trans($response));
    }

    public function sendResetLinkFailedResponse($request,$response){
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }
}
