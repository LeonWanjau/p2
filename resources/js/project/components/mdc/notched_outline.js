import {MDCNotchedOutline} from '@material/notched-outline';

export const notched_outline=[].map.call(document.querySelectorAll('.mdc-notched-outline'),function(el){
    return new MDCNotchedOutline(el)
})