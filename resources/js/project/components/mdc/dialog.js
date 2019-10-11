import {MDCDialog} from '@material/dialog';

export const dialog=[].map.call(document.querySelectorAll('.mdc-dialog'),function(el){
    return new MDCDialog(el);
})