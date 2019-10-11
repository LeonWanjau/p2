@extends('project_views/base_views/base')

@section('title')
{{ "Login" }}
@endsection

@section('content')


<div class="card-container">
    <div class="mdc-card">
        <h4 class="heading heading--form">Login</h4>

        <form action="{{ route('login') }}" method="POST" class="form-container form-container--card">
            {{ csrf_field() }}



            <div class="text-field-container">
                <div class="mdc-text-field ripple-surface mdc-text-field--validation-text-color">
                    <input type="text" class="mdc-text-field__input" name="email"
                        value="{{ old('email') }}" />
                    <label for="username" class="mdc-floating-label">Email</label>
                    <div class="mdc-line-ripple"></div>
                </div>
                @error('email')
                    <div class="mdc-text-field-helper-line">
                        <div class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent">{{ $message }}
                        </div>
                    </div>
                @enderror
            </div>

            <div class="text-field-container">
                <div class="mdc-text-field text-field-alignment ripple-surface mdc-text-field--validation-text-color">
                    <input type="password" class="mdc-text-field__input" name="password"
                        value="{{ old('password') }}" />
                    <label for="username" class="mdc-floating-label">Password</label>
                    <div class="mdc-line-ripple"></div>
                </div>
                @error('password')
                    <div class="mdc-text-field-helper-line">
                        <div class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent">{{ $message }}
                        </div>
                    </div>
                @enderror
            </div>

            <div class="form-field-container">
                <div class="mdc-form-field">
                    <div class="mdc-checkbox">
                        <input type="checkbox" class="mdc-checkbox__native-control" id="remember_me" name="remember_me"
                            value="true" />
                        <div class="mdc-checkbox__background">
                            <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                <path class="mdc-checkbox__checkmark-path" fill="none"
                                    d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                            </svg>
                            <div class="mdc-checkbox__mixedmark"></div>
                        </div>
                    </div>
                    <label for="remember_me">Remember Me</label>
                </div>
            </div>

            <button class="mdc-button mdc-button--raised ripple-surface mdc-button--form" id="login_button">
                Login
            </button>

            <button class="mdc-button mdc-button--outlined mdc-button--form ripple-surface" id="create_account_button">
                Create Account
            </button>

            <button class="mdc-button mdc-button--outlined mdc-button--form ripple-surface" id="forgot_password_button">
                Forgot Password?
            </button>

        </form>
    </div>
</div>

<script src="{{ asset('js/project/authentication/login_page.js') }}" async></script>

<script>
    var create_account_button = document.querySelector('#create_account_button');
    create_account_button.addEventListener('click', function (e) {
        e.preventDefault();
        window.location.href = "{{ route('create_account.show') }}"
    });

    var forgot_password_button = document.querySelector('#forgot_password_button');
    forgot_password_button.addEventListener('click', function (e) {
        e.preventDefault();
        window.location.href = "{{ route('password.request') }}"
    });

</script>
@endsection
