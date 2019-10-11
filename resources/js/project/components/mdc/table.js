import {MDCDataTable} from '@material/data-table';

export const table=[].map.call(document.querySelectorAll('.mdc-data-table'),function(el){
    return new MDCDataTable(el);
})