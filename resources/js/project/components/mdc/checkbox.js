import {MDCCheckbox} from '@material/checkbox';

export const checkbox=[].map.call(document.querySelectorAll('.mdc-checkbox'), function(el) {
    return new MDCCheckbox(el);
});