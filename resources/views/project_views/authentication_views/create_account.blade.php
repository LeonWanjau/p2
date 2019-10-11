@extends('project_views/base_views/base')

@section('title')
{{ "Create Account" }}
@endsection

@section('app_bar_end')
<button class="mdc-button mdc-button--app-bar button-login">
    Login
</button>
@endsection

@section('content')

<div class="card-container">
    <div class="mdc-card">


        <h4 class="heading heading--form">Create Account</h4>


        <form class="form-container form-container--card" method="POST"
            action="{{ route('create_account') }}">

            {{ csrf_field() }}

            {{-- --First Name-- --}}
            <div class="text-field-container">
                <div class="mdc-text-field ripple-surface mdc-text-field--validation-text-color">
                    <input class="mdc-text-field__input" name="first_name"
                        value="{{ old('first_name') }}" />
                    <label for="username" class="mdc-floating-label">First Name</label>
                    <div class="mdc-line-ripple"></div>
                </div>
                @error('first_name')
                    <div class="mdc-text-field-helper-line flex-align-self-start">
                        <div class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent">
                            {{ $message }}</div>
                    </div>
                @enderror
            </div>

            {{-- --Last Name-- --}}
            <div class="text-field-container">
                <div class="mdc-text-field ripple-surface mdc-text-field--validation-text-color">
                    <input class="mdc-text-field__input" name="last_name"
                        value="{{ old('last_name') }}" />
                    <label for="username" class="mdc-floating-label">Last Name</label>
                    <div class="mdc-line-ripple"></div>
                </div>
                @error('last_name')
                    <div class="mdc-text-field-helper-line flex-align-self-start">
                        <div class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent">{{ $message }}
                        </div>
                    </div>
                @enderror
            </div>

            {{-- --Email-- --}}
            <div class="text-field-container">
                <div class="mdc-text-field ripple-surface mdc-text-field--validation-text-color">
                    <input class="mdc-text-field__input" name="email" value="{{ old('email') }}" />
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

            {{-- --Password-- --}}
            <div class="text-field-container">
                <div class="mdc-text-field ripple-surface mdc-text-field--validation-text-color">
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

            {{-- --Phone Number-- --}}
            <div class="text-field-container">
                <div class="mdc-text-field ripple-surface mdc-text-field--validation-text-color">
                    <input type="number" class="mdc-text-field__input" name="phone_number"
                        value="{{ old('phone_number') }}" />
                    <label for="username" class="mdc-floating-label">Phone Number</label>
                    <div class="mdc-line-ripple"></div>
                </div>
                @error('phone_number')
                    <div class="mdc-text-field-helper-line">
                        <div class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent">{{ $message }}
                        </div>
                    </div>
                @enderror
            </div>

            {{-- --Role-- --}}
            <div class="select-container select-container--form">
                <div class="mdc-select mdc-select--flex ripple-surface mdc-select--validation-text-color">
                    <i class="mdc-select__dropdown-icon"></i>
                    <select class="mdc-select__native-control" name="role">
                        <option value="" disabled selected></option>
                        <option value="teacher" @if(old('role')=="teacher" ) {{ "selected" }} @endif>
                            Teacher
                        </option>
                        <option value="administrative_staff" @if(old('role')=="administrative_staff" )
                            {{ "selected" }} @endif>
                            Administrative staff
                        </option>
                    </select>
                    <label class="mdc-floating-label">Role</label>
                    <div class="mdc-line-ripple"></div>
                </div>
                @error('role')
                    <p class="mdc-select-helper-text mdc-select-helper-text--persistent">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- --Create Account Button-- --}}
            <button class="mdc-button mdc-button--raised ripple-surface mdc-button--form">
                Create Account
            </button>

        </form>

    </div>
</div>

<script src="{{ asset('js/project/authentication/create_account_page.js') }}" async></script>
<script>
    var login_button = document.querySelector(".button-login");
    login_button.addEventListener('click', function () {
        window.location.href = "{{ route('login.show') }}"
    });

</script>
@endsection
