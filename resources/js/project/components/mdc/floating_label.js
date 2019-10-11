import {MDCFloatingLabel} from '@material/floating-label';

export const floating_labels=[].map.call(document.querySelectorAll(".mdc-floating-label"), function(el){
    return new MDCFloatingLabel(el);
});