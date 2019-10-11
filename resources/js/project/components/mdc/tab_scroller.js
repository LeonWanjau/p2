import {MDCTabScroller} from '@material/tab-scroller';

export const tab_scroller=[].map.call(document.querySelectorAll('.mdc-tab-scroller'),function(el){
    return new MDCTabScroller(el);
})