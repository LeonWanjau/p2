//import style from "../../../sass/project/components/text_field.scss";
import {MDCTextField} from '@material/textfield';
import {MDCFloatingLabel} from '@material/floating-label';

export const text_fields=[].map.call(document.querySelectorAll(".mdc-text-field"), function(el){
    return new MDCTextField(el);
})