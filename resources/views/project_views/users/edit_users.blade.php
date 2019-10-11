@users

    @slot('main_content')

        <div class="card-container card-container--main-content">

            <div class="mdc-card">

                <h4 class="heading heading--form">Edit User</h4>

                <form class="form-container form-container--card" method="POST"
                    action="@if($user_type=='teachers')
                {{ route('users.edit',['user_type'=>$user_type,'id'=>$id]) }} @endif">

                    {{ csrf_field() }}



                    @php

                        $text_fields=[
                        ['label'=>'First Name','name'=>'f_name','value'=>($f_name ?? '')],
                        ['label'=>'Last Name','name'=>'l_name','value'=>($l_name ?? '')],
                        ['label'=>'Email','name'=>'email','value'=>($email ?? '')],
                        ['label'=>'Phone Number','name'=>'phone_number','value'=>($phone_number ?? '')],
                        ];

                    @endphp

                    @foreach($text_fields as $text_field)
                        <div class=" text-field-container">
                            <div class="mdc-text-field ripple-surface mdc-text-field--validation-text-color">
                                <input type="text" class="mdc-text-field__input"
                                    name="{{ $text_field['name'] }}"
                                    value="{{ old($text_field['name']) ?? $text_field['value']  }}" />
                                <label for="username"
                                    class="mdc-floating-label">{{ $text_field['label'] }}</label>
                                <div class="mdc-line-ripple"></div>
                            </div>
                            @error($text_field['name'])
                                <div class="mdc-text-field-helper-line">
                                    <div class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent">
                                        {{ $message }}
                                    </div>
                                </div>
                            @enderror
                        </div>
                    @endforeach

                    <button class="mdc-button mdc-button--raised mdc-button--form">Save Changes</button>

                </form>

            </div>

        </div>
    @endslot

@endusers
