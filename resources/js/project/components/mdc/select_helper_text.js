import {MDCSelectHelperText} from '@material/select/helper-text';

export const select_helper_text=[].map.call(document.querySelectorAll('.mdc-select-helper-text'),function(el) {
    return new MDCSelectHelperText(el);
});