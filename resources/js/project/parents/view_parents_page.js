//var $  = require( 'jquery' );
//var dt = require( 'datatables.net-bs4' );


import $ from 'jquery';
import 'datatables.net';
import 'datatables.net-bs4';
import 'datatables.net-responsive-bs4'
import 'datatables.net-select-bs4'
import 'datatables.net-buttons-bs4'
require('datatables.net-editor')(window, $)
require('datatables.net-editor-bs4')
//import 'datatables.net-editor-free'
import 'bootstrap';
import style from "../../../sass/project/components/data_tables/data_tables.scss"





$(document).ready(function () {

    var editor = new $.fn.dataTable.Editor({
        ajax: 'http://localhost/IS_P2/public/index.php/parents/action',
        table: '#table_id',
        idSrc: 'id',
        fields: [{
                label: 'ID',
                name: 'id',
                attr:{ disabled:true }
            },
            {
                label: 'First name',
                name: 'f_name'
            },
            {
                label: 'Last name',
                name: 'l_name'
            },
            {
                label: 'Phone Number',
                name: 'phone_number'
            },
            {
                label: 'Role',
                name: 'role',
                type:'select',
                options:[
                    {label:"Father", value:"Father"},
                    {label:"Mother", value:"Mother"}
                ]
            },
        ]
    });

    editor.on('initCreate',function(){
        editor.field('id').hide();
    })

    editor.on('initEdit', function () {
        editor.field('id').show();
    })

    var column_defs = [{
            data: "id",
            title: "ID"
        },
        {
            data: "f_name",
            title: "First Name"
        },
        {
            data: "l_name",
            title: "Last Name"
        },
        {
            data: "phone_number",
            title: "Phone Number"
        },
        {
            data: "role",
            title: "Role"
        },
    ];

    var table = $('#table_id').DataTable({

        responsive: true,
        select: 'single',

        ajax: {
            url: 'http://localhost/IS_P2/public/index.php/parents/view',
            type: 'POST',
            dataSrc: 'data'
        },

        columns: column_defs,

        dom: 'lBfrtip',


        buttons: [{
                extend: 'create',
                editor: editor
            },
            {
                extend: 'edit',
                editor: editor,
                className: 'edit_parents_button'
            },
            {
                extend: 'remove',
                editor: editor,
                className: 'delete_parents_button'
            }
        ],
    });


    table.on('select.dt deselect.dt', function () {
        table.buttons(['.edit_parents_button', '.delete_parents_button']).enable(
            table.rows({
                selected: true
            }).indexes().length === 0 ? false : true
        )
    })

    table.on('draw.dt', function () {
        table.row({selected:true}).deselect()
        table.buttons(['.edit_parents_button', '.delete_parents_button']).disable()
    })

});
