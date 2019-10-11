import {MDCTab} from '@material/tab';

export const tab=[].map.call(document.querySelectorAll('.mdc-tab'),function(el){
    return new MDCTab(el);
})