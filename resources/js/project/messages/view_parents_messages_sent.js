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
        ajax: 'http://localhost/IS_P2/public/index.php/messages/parents/sent/action',
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
            }
        ]
    });

    editor.on('initCreate', function () {
        editor.field('id').hide();
    })

    editor.on('initEdit', function () {
        editor.field('id').show();
    })

    var column_defs = [{
            "className": 'details-control',
            "orderable": false,
            "searchable": false,
            "data": null,
            "defaultContent": '<i class="material-icons">add_circle_outline</i>',
            "targets": 0
        },
        {
            data: "id",
            title: "ID"
        },
        {
            data: "message",
            title: "Message"
        }
    ];

    var table = $('#table_id').DataTable({

        responsive: true,
        select: 'single',

        ajax: {
            url: 'http://localhost/IS_P2/public/index.php/messages/parents/sent/view',
            type: 'POST',
            dataSrc: 'data'
        },

        columns: column_defs,

        order: [
            [1, 'asc']
        ],

        dom: 'lBfrtip',


        buttons: [{
            extend: 'remove',
            editor: editor,
            className: 'delete_message_button'
        }],
    });


    table.on('select.dt deselect.dt', function () {
        table.buttons(['.delete_message_button']).enable(
            table.rows({
                selected: true
            }).indexes().length === 0 ? false : true
        )
    })

    table.on('draw.dt', function () {
        table.row({
            selected: true
        }).deselect()
        table.buttons(['.delete_message_button']).disable()
    })

    $('#table_id tbody').on('click', 'td.details-control', function () {
        let tr = $(this).closest('tr');
        let row = table.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it

            row.child.hide();
            tr.removeClass('shown');
            $(this).html('<i class="material-icons">add_circle_outline</i>')
        } else {
            // Open this row

            tr.addClass('shown');
            format(row.child, row.data().id)
            $(this).html('<i class="material-icons">remove_circle_outline</i>')
        }
    })


    function format(callback, msg_id) {

        $.ajax({

            type: "POST",

            url: "http://localhost/IS_P2/public/index.php/messages/parents/sent/associated_parents",

            dataType: 'json',

            data: {
                id: msg_id
            },

            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown)
            },

            success: function (data) {
                //console.log(data)
                let html = '';

                $.each(data.data, function (index, item) {
                    let row = ''

                    $.each(item, function (index, item) {
                        row += "<td>" + item + "</td>"
                    })

                    html += "<tr>" + row + "</tr>"
                })

                let table=
                '<table class="table table-bordered no-footer" style="width:50%">'+
                '<thead>'+
                '<tr>'+
                '<th>Parent ID</th>'+
                '<th>First Name</th>'+
                '<th>Last Name</th>'+
                '</tr>'+
                '</thead>'+
                '<tbody>'+
                html+
                '</tbody>'+
                '</table>'


                callback(table).show()
            }
        })
    }

});
