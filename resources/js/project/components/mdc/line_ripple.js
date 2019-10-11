import {MDCLineRipple} from '@material/line-ripple';

export const line_ripples=[].map.call(document.querySelectorAll('.mdc-line-ripple'),function(el){
    return new MDCLineRipple(el);
});