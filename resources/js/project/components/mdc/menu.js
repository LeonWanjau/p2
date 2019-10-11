import {MDCMenu} from '@material/menu';
import {MDCMenuSurface} from '@material/menu-surface';

export const menu=[].map.call(document.querySelectorAll('.mdc-menu'),function(el){
    return new MDCMenu(el)
})

export const menu_surface=[].map.call(document.querySelectorAll('.mdc-menu-surface'),function(el){
    return new MDCMenuSurface(el)
})