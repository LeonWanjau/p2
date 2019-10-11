import {MDCRipple} from '@material/ripple';

 const ripples = [].map.call(document.querySelectorAll('.ripple-surface'), function(el){
    return new MDCRipple(el);
});

export {ripples};


/*
import style from "../../../../sass/project/components/ripple/ripple.scss";

export {style as ripple};
*/