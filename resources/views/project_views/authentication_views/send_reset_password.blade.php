@extends('project_views/base_views/base')

@section('title')
{{"Send Password Reset"}}
@endsection

@section('app_bar_end')
<button class="mdc-button mdc-button--app-bar" id="create_account_button">
Create Account
</button>

<button class="mdc-button mdc-button--app-bar" id="login_button">
Login
</button>

<script>
var login_button=document.querySelector("#login_button");
login_button.addEventListener('click',function(){
    window.location.href="{{route('login.show')}}"
});

document.querySelector("#create_account_button").addEventListener('click',function(){
    window.location.href="{{route('create_account.show')}}"
});
</script>
@endsection

@section('content')

<div class="card-container">
    <div class="mdc-card">
        
        <h4 class="heading heading--form">Password Reset Link</h4>

        @if (session('status'))
        <div class="info-container">
            {{ session('status') }}
        </div>
        @endif
        <form class="form-container form-container--card" method="POST" action="{{route('password.email')}}">
            {{csrf_field()}}
            <div class="text-field-container">
                <div class="mdc-text-field text-field-alignment ripple-surface mdc-text-field--validation-text-color">
                    <input class="mdc-text-field__input" name="email" value="{{old('email')}}" />
                    <label for="username" class="mdc-floating-label">Enter Email Address</label>
                    <div class="mdc-line-ripple"></div>
                </div>
                @error('email')
                <div class="mdc-text-field-helper-line text-field-helper-text-alignment">
                    <div class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent">{{$message}}</div>
                </div>
                @enderror
            </div>

            <button class="mdc-button mdc-button--raised ripple-surface mdc-button--form">
                Send Reset Link
            </button>
        </form>
    </div>
</div>

<script src="{{asset('js/project/authentication/send_password_reset_link_page.js')}}" async></script>
@endsection