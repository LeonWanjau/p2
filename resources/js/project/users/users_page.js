
/*
const targetNode=document.getElementById('list');

const config={attributes:true,childList:true,subtree:true};

const callback=function(mutationsList,observer){
    for(let mutation of mutationsList){
        if(mutation.type==='attributes'){
            //console.log('The '+mutation.attributeName+' attribute was modified');
            //console.log(mutation.target.children[1].childNodes[0]);
            if(mutation.target.children[1].childNodes[0].textContent=="View Teachers"){
                console.log('view teachers affected')
            }
        }else if(mutation.type==='childList'){
            console.log('child modified')
        }
    }
};

const observer=new MutationObserver(callback);

observer.observe(targetNode,config);

console.log('hello');
console.log(targetNode);
*/

//Show and hide sidebar lists
var sidebar_subheadings = document.querySelectorAll('.heading--sidebar');
sidebar_subheadings.forEach(function (subheading) {
    subheading.addEventListener('click', function (e) {
        if(e.target.innerText.trim()=="Teachers"){
           //console.log(e.target.nextElementSibling);
           if(e.target.nextElementSibling !=null && e.target.nextElementSibling.classList.contains('mdc-list-group')){
                if(e.target.nextElementSibling.classList.contains('display-none')){
                    e.target.nextElementSibling.classList.remove('display-none')
                }else{
                    e.target.nextElementSibling.classList.add('display-none')
                }
           }
        }
    });
});

//Edit Teacher Accounts
/*
var view_teachers_table=document.querySelector('#view_teachers_table');
var view_teachers_modal=document.querySelector('#view_teachers_modal');
var view_teachers_modal_close_button=view_teachers_modal.querySelector('.mdc-icon-button');

view_teachers_table.addEventListener('click',function(e){
    if(e.target.tagName=='TD'){
        view_teachers_modal.classList.add('display-block');

        let row=e.target.parentElement;

        let first_name_field=view_teachers_modal.querySelector("[name='f_name']");
        let first_name_label=first_name_field.nextElementSibling;
        first_name_label.classList.add('mdc-floating-label--float-above');
        first_name_field.value=row.children[1].innerText;
        let first_name_validator=first_name_field.parentElement.nextElementSibling;
        if(first_name_validator!=null){
            first_name_validator.remove();
        }

        let second_name_field=view_teachers_modal.querySelector("[name='l_name']");
        let second_name_label=second_name_field.nextElementSibling;
        second_name_label.classList.add('mdc-floating-label--float-above');
        second_name_field.value=row.children[2].innerText;
        let second_name_validator=second_name_field.parentElement.nextElementSibling;
        if(second_name_validator!=null){
            second_name_validator.remove();
        }

        let email_field=view_teachers_modal.querySelector("[name='email']");
        let email_label=email_field.nextElementSibling;
        email_label.classList.add('mdc-floating-label--float-above');
        email_field.value=row.children[3].innerText;
        let email_validator=email_field.parentElement.nextElementSibling;
        if(email_validator!=null){
            email_validator.remove();
        }

        let id_field=view_teachers_modal.querySelector("[name='id']");
        id_field.value=row.children[0].innerText;
    }
})

view_teachers_modal_close_button.addEventListener('click',function(e){
    e.preventDefault();
    view_teachers_modal.classList.remove('display-block');
})
*/

