import {MDCFormField} from '@material/form-field';

export const form_field=[].map.call(document.querySelectorAll('.mdc-form-field'), function(el) {
    return new MDCFormField(el);
});