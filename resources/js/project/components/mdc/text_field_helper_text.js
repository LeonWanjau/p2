import {MDCTextFieldHelperText} from '@material/textfield/helper-text';

export const select_field_helper_text=[].map.call(
    document.querySelectorAll('.mdc-text-field-helper-text'),
    function(el){
        return new MDCTextFieldHelperText(el);
    });