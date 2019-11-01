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
        ajax: 'http://localhost/IS_P2/public/index.php/classes/action',
        table: '#table_id',
        idSrc: 'id',
        fields: [{
                label: 'Class ID',
                name: 'id',
                attr: {
                    disabled: true
                }
            },
            {
                label: 'Class',
                name: 'class_name'
            },
            {
                label: 'Class Teacher ID',
                name: 'teacher_id',
                data: 'teacher_id',
                type: 'select',
                placeholder:''
            },
            {
                label: 'Number of Students',
                name: 'number_of_students',
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
            data: "id",
            title: "Class ID"
        },
        {
            data: "class_name",
            title: "Class Name"
        },
        {
            data: "teacher_id",
            title: "Class Teacher ID"
        },
        {
            data: "number_of_students",
            title: "Number of Students"
        }
    ];

    var table = $('#table_id').DataTable({

        responsive: true,

        select: 'single',

        ajax: {
            url: 'http://localhost/IS_P2/public/index.php/classes/view',
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
                className: 'edit_classes_button'
            },
            {
                extend: 'remove',
                editor: editor,
                className: 'delete_classes_button'
            }
        ],

        initComplete: function (settings, json) {
            let teachers = json.teachers
            
            let options = []

            teachers.forEach(function (val) {
                options.push({
                    label:val.id+": "+val.f_name+" "+val.l_name,
                    value:val.id
                })
            })

            editor.field('teacher_id').update(options)
        }
    });

    table.on('select.dt deselect.dt', function () {
        table.buttons(['.edit_classes_button', '.delete_classes_button']).enable(
            table.rows({
                selected: true
            }).indexes().length === 0 ? false : true
        )
    })

    table.on('draw.dt', function () {
        table.row({
            selected: true
        }).deselect()
        table.buttons(['.edit_classes_button', '.delete_classes_button']).disable()
    })
});
