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
        ajax: 'http://localhost/IS_P2/public/index.php/students/action',
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
                label: 'First name',
                name: 'f_name'
            },
            {
                label: 'Last name',
                name: 'l_name'
            },
            {
                label: 'Age',
                name: 'age'
            },
            {
                type: 'select',
                label: 'Class Name',
                name: 'class_name',
                data: null,
                placeholder:""
            },
            {
                type: 'select',
                label: 'Mother ID',
                name: 'mother_id',
                data: 'mother_id',
                placeholder:"",
                placeholderDisabled: false
            },
            {
                type: 'select',
                label: 'Father ID',
                name: 'father_id',
                data: 'father_id',
                placeholder:"",
                placeholderDisabled: false
            }
        ]
    });

    editor.on('initCreate', function () {
        editor.field('id').hide();
    })

    editor.on('initEdit', function () {
        editor.field('id').show();
    })

    //editor.dependent('class_id', 'http://localhost/IS_P2/public/index.php/classes/class_name');

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
            data: "age",
            title: "Age"
        },
        {
            data: "class_name",
            title: "Class Name"
        },
        {
            data: "mother_id",
            title: "Mother ID"
        },
        {
            data: "father_id",
            title: "Father ID"
        },

    ];

    var table = $('#table_id').DataTable({

        responsive: true,

        select: 'single',

        ajax: {
            url: 'http://localhost/IS_P2/public/index.php/students/view',
            type: 'POST',
            dataSrc: 'data',
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
                className: 'edit_students_button'
            },
            {
                extend: 'remove',
                editor: editor,
                className: 'delete_students_button'
            }
        ],

        initComplete: function (settings, json) {
            //Set class names selector
            let class_names = json.class_names
            let options = []

            class_names.forEach(function (val) {
                options.push({
                    label: val,
                    value: val
                })
            })

            editor.field('class_name').update(options)

            //Set father_id selector
            let fathers=json.fathers
            let father_options=[]

            fathers.forEach(function(val){
                father_options.push({
                    label:val.id+": "+val.f_name+" "+val.l_name,
                    value:val.id
                })
            })

            editor.field('father_id').update(father_options)

            //Set mother_id selector
            let mothers=json.mothers
            let mother_options=[]

            mothers.forEach(function(val){
                mother_options.push({
                    label:val.id+": "+val.f_name+" "+val.l_name,
                    value:val.id
                })
            })

            editor.field('mother_id').update(mother_options)
        }
    });

    table.on('select.dt deselect.dt', function () {
        table.buttons(['.edit_students_button', '.delete_students_button']).enable(
            table.rows({
                selected: true
            }).indexes().length === 0 ? false : true
        )
    })

    table.on('draw.dt', function () {
        table.row({
            selected: true
        }).deselect()
        table.buttons(['.edit_students_button', '.delete_students_button']).disable()
    })
});
