<div class="select-container {{$select_container_classes ?? null}}">
        <div class="mdc-select mdc-select--flex ripple-surface mdc-select--validation-text-color">
            <i class="mdc-select__dropdown-icon"></i>
            <select class="mdc-select__native-control" name="{{$name}}">
                {{$options}}
            </select>
            <label class="mdc-floating-label">{{$label}}</label>
            <div class="mdc-line-ripple"></div>
        </div>
        @error($name)
            <p class="mdc-select-helper-text {{$persistent ?? null}}">
                {{ $message }}
            </p>
        @enderror
    </div>