@account(['edit_account_active'=>'active'])

    @slot('main_content')

        <div class="card-container card-container--main-content">

            <div class="mdc-card">

                <h4 class="heading heading--form">Edit Account</h4>

                <form class="form-container form-container--card" method="POST"
                    action="{{ route('account.edit') }}">

                    {{ csrf_field() }}

                    @php
                        $text_fields=[
                        ['label'=>'First Name','name'=>'f_name','value'=>(Auth::user()->f_name ?? null)],
                        ['label'=>'Last Name','name'=>'l_name','value'=>(Auth::user()->l_name ?? null)],
                        ['label'=>'Phone Number','name'=>'phone_number','value'=>(Auth::user()->phone_number ?? null)],
                        ['label'=>'Email','name'=>'email','value'=>(Auth::user()->email ?? null)],
                        ];
                    @endphp

                    @foreach($text_fields as $text_field)
                        <div class="text-field-container">
                            <div class="mdc-text-field ripple-surface mdc-text-field--validation-text-color">
                                <input type="text" class="mdc-text-field__input"
                                    name="{{ $text_field['name'] }}" value=@if($errors->first($text_field['name']))
                                    "{{ old($text_field['name']) }}"
@else
                                    "{{ ($text_field['value'] ?? null) }}"
@endif
                                    />
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

@endaccount
