import {MDCList} from "@material/list";

export const list=[].map.call(document.querySelectorAll('.mdc-list'),function(el){
    return new MDCList(el);
});