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
        ajax: 'http://localhost/IS_P2/public/index.php/users/admins/action',
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
                label: 'Password',
                name: 'password',
                type: 'password'
            },
            {
                label: 'Email',
                name: 'email'
            },
            {
                label: 'Phone Number',
                name: 'phone_number'
            }
        ]
    });

    editor.on('initCreate', function () {
        editor.field('id').hide();
        editor.field('password').show();
    })

    editor.on('initEdit', function () {
        editor.field('id').show();
        editor.field('password').hide();
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
            data: "email",
            title: "email"
        },
        {
            data: "phone_number",
            title: "Phone Number"
        },
        {
            data: "user_verified_at",
            title: "Verification Status",
            render: function (data, type, row) {
                if (data == null) {
                    return "Unverified"
                } else if (data !== null) {
                    return "Verified"
                }
            }
        }
    ];

    var table = $('#table_id').DataTable({

        responsive: true,
        select: 'single',

        ajax: {
            url: 'http://localhost/IS_P2/public/index.php/users/admins/view',
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
                className: 'edit_admin_button'
            },
            {
                extend: 'remove',
                editor: editor,
                className: 'delete_admin_button'
            },
            {
                extend: "selectedSingle",
                text: 'Verify',
                action: function (e, dt, node, config) {
                    editor
                        .title('Verify User')
                        .buttons({
                            text: 'Verify',
                            className: 'btn-primary',

                            action: function () {
                                let row = table.row({
                                    selected: true
                                })
                                let data = table.row({
                                    selected: true
                                }).data();

                                $.ajax({
                                    type: "POST",

                                    url: "http://localhost/IS_P2/public/index.php/users/admins/verify",

                                    data: {
                                        data: data
                                    },

                                    error: function (jqXHR, textStatus, errorThrown) {
                                        console.log(errorThrown)
                                    },

                                    success: function (data) {
                                        let new_data = data.data[0]
                                        row.data(new_data).draw()
                                        editor.close()
                                    }
                                })
                            }

                        })
                        .edit(
                            table.rows({
                                selected: true
                            }).indexes()
                        )
                },
                editor: editor
            },
            {
                extend: "selectedSingle",
                text: 'Unverify',
                action: function (e, dt, node, config) {

                    editor
                        .title('Unverify User')
                        .buttons({
                            text: 'Unverify',
                            className: 'btn-primary',

                            action: function () {
                                let row = table.row({
                                    selected: true
                                })
                                let data = table.row({
                                    selected: true
                                }).data();

                                $.ajax({
                                    type: "POST",

                                    url: "http://localhost/IS_P2/public/index.php/users/admins/unverify",

                                    data: {
                                        data: data
                                    },

                                    error: function (jqXHR, textStatus, errorThrown) {
                                        console.log(errorThrown)
                                    },

                                    success: function (data) {
                                        let new_data = data.data[0]
                                        row.data(new_data).draw()
                                        editor.close()
                                    }
                                })
                            }

                        })
                        .edit(
                            table.rows({
                                selected: true
                            }).indexes()
                        )
                },
                editor: editor
            }
        ],
    });


    table.on('select.dt deselect.dt', function () {
        table.buttons(['.edit_admin_button', '.delete_admin_button']).enable(
            table.rows({
                selected: true
            }).indexes().length === 0 ? false : true
        )
    })

    table.on('draw.dt', function () {
        table.row({
            selected: true
        }).deselect()
        table.buttons(['.edit_admin_button', '.delete_admin_button']).disable()
    })

});
