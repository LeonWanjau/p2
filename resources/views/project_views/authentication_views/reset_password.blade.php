@extends('project_views/base_views/base')

@section('title')
{{"Reset Password"}}
@endsection

@section('app_bar_end')
<button class="mdc-button mdc-button--app-bar" id="login_button">
    Login
</button>
<script>
    var login_button = document.querySelector("#login_button");
    login_button.addEventListener('click', function() {
        window.location.href = "{{route('login.show')}}"
    });
</script>
@endsection

@section('content')

<div class="card-container">
    <div class="mdc-card">

        <h4 class="heading heading--form">Reset Password</h4>

        <form class='form-container form-container--card' method="POST" action="{{route('password.update')}}">

            {{csrf_field()}}

            <input type="hidden" name="token" value="{{ $token }}"/>

            <div class="text-field-container">
                <div class="mdc-text-field text-field-alignment ripple-surface mdc-text-field--validation-text-color">
                    <input class="mdc-text-field__input" name="email" value="{{$email ?? old('email')}}" />
                    <label for="username" class="mdc-floating-label">Email</label>
                    <div class="mdc-line-ripple"></div>
                </div>
                @error('email')
                <div class="mdc-text-field-helper-line text-field-helper-text-alignment">
                    <div class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent">{{$message}}</div>
                </div>
                @enderror
            </div>

            <div class="text-field-container">
                <div class="mdc-text-field text-field-alignment ripple-surface mdc-text-field--validation-text-color">
                    <input type="password" class="mdc-text-field__input" name="password" value="{{old('password')}}" />
                    <label for="username" class="mdc-floating-label">New Password</label>
                    <div class="mdc-line-ripple"></div>
                </div>
                @error('password')
                <div class="mdc-text-field-helper-line text-field-helper-text-alignment">
                    <div class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent">{{$message}}</div>
                </div>
                @enderror
            </div>

            <div class="text-field-container">
                <div class="mdc-text-field text-field-alignment ripple-surface mdc-text-field--validation-text-color">
                    <input type="password" class="mdc-text-field__input" name="password_confirmation" value="{{old('password_confirmation')}}" />
                    <label for="username" class="mdc-floating-label">Confirm New Password</label>
                    <div class="mdc-line-ripple"></div>
                </div>
                @error('password_confirmation')
                <div class="mdc-text-field-helper-line text-field-helper-text-alignment">
                    <div class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent">{{$message}}</div>
                </div>
                @enderror
            </div>

            <button class="mdc-button mdc-button--raised ripple-surface mdc-button--form">
                Reset Password
            </button>

        </form>

    </div>
</div>

<script src="{{asset('js/project/authentication/reset_password_page.js')}}" async></script>
@endsection