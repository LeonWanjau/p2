import {MDCSelect} from '@material/select';

const selects=[].map.call(document.querySelectorAll('.mdc-select'),
    function(el){
        return new MDCSelect(el);
    });