import {MDCTabBar} from '@material/tab-bar';

export const tab_bar=[].map.call(document.querySelectorAll('.mdc-tab-bar'),function(el){
    return new MDCTabBar(el);
})