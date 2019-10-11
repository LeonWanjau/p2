<div class="text-field-container {{$text_field_container_classes ?? null}}">
    <div class="mdc-text-field ripple-surface mdc-text-field--validation-text-color">
        <input class="mdc-text-field__input" name="{{ $name }}" value="{{ old($name) }}" />
        <label for="{{ $name }}" class="mdc-floating-label">{{ $label }}</label>
        <div class="mdc-line-ripple"></div>
    </div>
    @error($name)
        <div class="mdc-text-field-helper-line">
            <div class="mdc-text-field-helper-text {{ $persistent ?? null }}">{{ $message }}
            </div>
        </div>
    @enderror
</div>
