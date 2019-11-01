import $ from 'jquery';
import 'datatables.net';
import 'datatables.net-bs4';
import 'datatables.net-responsive-bs4'
import 'datatables.net-select-bs4'
import 'datatables.net-buttons-bs4'
require('datatables.net-editor')(window, $)
require('datatables.net-editor-bs4')
import 'bootstrap';
import style from "../../../sass/project/components/data_tables/data_tables.scss"

$(document).ready(function () {

    var editor = new $.fn.dataTable.Editor({
        ajax: 'http://localhost/IS_P2/public/index.php/messages/parents/received/action',
        table: '#table_id',
        idSrc: 'id',
        fields: [{
                label: 'ID',
                name: 'id',
                attr: {
                    disabled: true
                }
            },
            {
                label: 'Message',
                name: 'message'
            },
            {
                label: 'Parent ID',
                name: 'parent_id'
            },
            {
                label: 'Phone Number',
                name: 'phone_number'
            },
            {
                label: 'Date Received',
                name: 'date_received'
            },
        ]
    });

    editor.on('initCreate', function () {
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
            data: "message",
            title: "Message"
        },
        {
            data: "parent_id",
            title: "Parent ID"
        },
        {
            data: "phone_number",
            title: "Phone Number"
        },
        {
            data: "date_received",
            title: "Date Received"
        },
    ];

    var table = $('#table_id').DataTable({

        responsive: true,
        select: 'single',

        ajax: {
            url: 'http://localhost/IS_P2/public/index.php/messages/parents/received/view',
            type: 'POST',
            dataSrc: 'data'
        },

        columns: column_defs,

        dom: 'lBfrtip',


        buttons: [{
            extend: 'remove',
            editor: editor,
            className: 'delete_parents_button'
        }],
    });


    table.on('select.dt deselect.dt', function () {
        table.buttons(['.delete_parents_button']).enable(
            table.rows({
                selected: true
            }).indexes().length === 0 ? false : true
        )
    })

    table.on('draw.dt', function () {
        table.row({
            selected: true
        }).deselect()
        table.buttons(['.delete_parents_button']).disable()
    })

});
