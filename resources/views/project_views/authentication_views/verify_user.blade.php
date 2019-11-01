@extends('project_views/base_views/base')

@section('title')
{{ "Account Verification" }}
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
        <h4 class="heading heading--card">Account Verification</h4>
        <div class="info-container info-container--medium">Your account needs to be verified by an admistrator</div>
        <div class="info-container info-container--medium">If your account is already verified, <a href="{{route('verification.user.redirect')}}">click here to proceed</a></div>
    </div>
</div>

<script src="{{asset('js/project/authentication/verify_user_page.js')}}" async></script>
@endsection