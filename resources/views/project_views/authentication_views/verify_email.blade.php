@extends('project_views/base_views/base')

@section('title')
{{"Verify Email"}}
@endsection

@section('app_bar_end')
<button class="mdc-button mdc-button--app-bar" id="login_button">
Login
</button>
<button class="mdc-button mdc-button--app-bar" id="create_account_button">
Create Account
</button>
<script>
var login_button=document.querySelector("#login_button");
login_button.addEventListener('click',function(){
    window.location.href="{{route('login.show')}}"
});

var create_account_button=document.querySelector("#create_account_button");
create_account_button.addEventListener('click',function(){
    window.location.href="{{route('create_account.show')}}"
});
</script>
@endsection

@section('content')

<div class="card-container">
    <div class="mdc-card">
        <h4 class="heading heading--card">Verify Email</h4>
        <div class="info-container info-container--medium">A verification link has been sent to your email address</div>
        <div class="info-container info-container--medium">If you did not receive the email, <a href="{{route('verification.resend')}}">click here to request another</a></div>
    </div>
</div>

<script src="{{asset('js/project/authentication/verify_email_page.js')}}" async></script>

@endsection