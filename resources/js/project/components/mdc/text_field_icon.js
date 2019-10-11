import {MDCTextFieldIcon} from '@material/textfield/icon';

export const text_field_icon=[].map.call(document.querySelectorAll('.mdc-text-field-icon'),function(el){
    return new MDCTextFieldIcon(el)
})