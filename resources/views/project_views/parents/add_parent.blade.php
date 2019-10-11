@parents(['add_parents_active'=>'true'])

    @slot('main_content')

        <div class="card-container card-container--main-content">

            <div class="mdc-card">

                <h4 class="heading heading--form">Add Parent</h4>

                <form class="form-container form-container--card" method="POST"
                    action="{{route('parents.add')}}">

                    {{ csrf_field() }}



                    @php

                        $text_fields=[
                        ['label'=>'First Name','name'=>'f_name','value'=>($f_name ?? '')],
                        ['label'=>'Last Name','name'=>'l_name','value'=>($l_name ?? '')],
                        ['label'=>'Phone Number','name'=>'phone_number','value'=>($phone_number ?? '')],
                        ];

                    @endphp

                    @foreach($text_fields as $text_field)
                        <div class=" text-field-container">
                            <div class="mdc-text-field ripple-surface mdc-text-field--validation-text-color">
                                <input type="text" class="mdc-text-field__input"
                                    name="{{ $text_field['name'] }}"
                                    value="{{ old($text_field['name']) ?? $text_field['value'] }}" />
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

                    <div class="select-container select-container--form">
                        <div class="mdc-select mdc-select--flex ripple-surface mdc-select--validation-text-color">
                            <i class="mdc-select__dropdown-icon"></i>
                            <select class="mdc-select__native-control" name="role">
                                <option value="" disabled selected></option>
                                <option value="father" @if(old('role')=="father" ) {{ "selected" }} @endif>
                                    Father
                                </option>
                                <option value="mother" @if(old('role')=="mother")
                                    {{ "selected" }} @endif>
                                    Mother
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

                    <button class="mdc-button mdc-button--raised mdc-button--form">Add Parent</button>

                </form>

            </div>

        </div>

    @endslot

@endparents
