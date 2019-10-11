import {MDCTopAppBar} from '@material/top-app-bar';

export const top_app_bar=[].map.call(document.querySelectorAll(".mdc-top-app-bar"), function(el) {
    return new MDCTopAppBar(el);
});