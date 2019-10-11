import {MDCTabBar} from '@material/tab-bar';
import {MDCTabIndicator} from '@material/tab-indicator';
import {MDCTab} from '@material/tab';
import {MDCTabScroller} from '@material/tab-scroller';

export const tab_bar=[].map.call(document.querySelectorAll('.mdc-tab-scroller'), function() {
    return new MDCTabBar(el);
});

export const tab_indicator=[].map.call(document.querySelectorAll('.mdc-tab-indicator'), function() {
    return new MDCTabIndicator(el);
});

export const tab=[].map.call(document.querySelectorAll('.mdc-tab'), function() {
    return new MDCTab(el);
});

export const tab_scroller=[].map.call(document.querySelectorAll('.mdc-tab-scroller'), function() {
    return new MDCTabScroller(el);
});