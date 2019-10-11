import {MDCTabIndicator} from '@material/tab-indicator';

export const tab_indicator=[].map.call(document.querySelectorAll('mdc-tab-indicator'),function(el){
    return new MDCTabIndicator(el);
});