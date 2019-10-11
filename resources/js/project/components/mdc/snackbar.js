import {MDCSnackbar} from '@material/snackbar';

export const snackbar=[].map.call(document.querySelectorAll('.mdc-snackbar'),function(el){
    return new MDCSnackbar(el);
})