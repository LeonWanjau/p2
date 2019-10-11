@users(['view_teachers_active'=>'true'])
    @slot('main_content')
        <div class="container container--view-users">

            @php
                $table_head=['ID','First Name','Last Name','Email','Phone Number','Action'];
                $rows=[
                ['id'=>1,'f_name'=>'John','l_name'=>'Peter','email'=>'j@gmail.com'],
                ];

                $user_search_text_field=['name'=>'search_value'];
                $user_search_select=['name'=>'search_column'];

            @endphp

            <form class="form-container form-container--user-search" method="POST" id="teachers_search_form"
                action="{{ route('users.search',['user_type'=>$user_type]) }}">

                {{ csrf_field() }}

                <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-trailing-icon">
                    <input type="text" class="mdc-text-field__input" name="search_value">
                    <i class="material-icons mdc-text-field__icon" tabindex="0" role="button" id="search_icon">
                        search
                    </i>
                    <div class="mdc-notched-outline">
                        <div class="mdc-notched-outline__leading"></div>
                        <div class="mdc-notched-outline__notch">
                            <label for="tf-outlined" class="mdc-floating-label">Search</label>
                        </div>
                        <div class="mdc-notched-outline__trailing"></div>
                    </div>
                </div>

            </form>

            <div class="mdc-data-table" id="users_data_table">


                <table class="mdc-data-table__table" id="view_teachers_table">
                    <thead>
                        <tr class="mdc-data-table__header-row">
                            @foreach($table_head as $head)
                                <th class="mdc-data-table__header-cell" role="columnheader" scope="col">{{ $head }}</th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody class="mdc-data-table__content">
                        @isset($users)
                            @foreach($users as $user)
                                <tr class="mdc-data-table__row">
                                    <td class="mdc-data-table__cell">{{ $user->id }}</td>

                                    <td class="mdc-data-table__cell">{{ $user->f_name }}</td>

                                    <td class="mdc-data-table__cell">{{ $user->l_name }}</td>

                                    <td class="mdc-data-table__cell">{{ $user->email }}</td>

                                    <td class="mdc-data-table__cell">{{ $user->phone_number }}</td>

                                    <td class="mdc-data-table__cell">
                                        <button class="mdc-icon-button material-icons">edit</button>
                                        <button class="mdc-icon-button material-icons">delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        @endisset
                    </tbody>
                </table>
            </div>

        </div>

        <div class="mdc-snackbar mdc-snackbar--custom-fill">
            <div class="mdc-snackbar__surface">
                <div class="mdc-snackbar__label" role="status" aria-live="polite">
                    @if(session('custom_status'))
                        {{ session('custom_status') }}
                    @endif
                </div>
                <div class="mdc-snackbar__actions">
                    <button type="button" class="mdc-icon-button material-icons mdc-snackbar__dismiss">close</button>
                </div>
            </div>
        </div>


        <div class="mdc-dialog" role="alertdialog" aria-modal="true" aria-labelledby="my-dialog-title"
            aria-describedby="my-dialog-content">
            <div class="mdc-dialog__container">
                <div class="mdc-dialog__surface">
                    <!-- Title cannot contain leading whitespace due to mdc-typography-baseline-top() -->
                    <h2 class="mdc-dialog__title" id="my-dialog-title">Delete User</h2>
                    <div class="mdc-dialog__content" id="delete_user_dialog_content">

                    </div>
                    <footer class="mdc-dialog__actions">
                        <button type="button" class="mdc-button mdc-dialog__button" data-mdc-dialog-action="no">
                            <span class="mdc-button__label">No</span>
                        </button>
                        <button type="button" class="mdc-button mdc-dialog__button" data-mdc-dialog-action="yes">
                            <span class="mdc-button__label">Yes</span>
                        </button>
                    </footer>
                </div>
            </div>
            <div class="mdc-dialog__scrim"></div>
        </div>


        <script type="module">
            /*
                    var show_all_teachers_button = document.querySelector('#show_all_teachers_button')
                    show_all_teachers_button.addEventListener('click', function (e) {
                        e.preventDefault();
                        window.location.href =""
                    })
                    */

            var delete_user_id;

            var teachers_search_form = document.querySelector('#teachers_search_form')
            var search_icon = document.querySelector('#search_icon')
            search_icon.addEventListener('click', function (e) {
                teachers_search_form.submit();
            })

            var mdc_search_text_field =mdc_components.text_field.text_fields[0]
            /* @if(old('search_value')!="") */
            mdc_search_text_field.value = "{{ old('search_value') }}"
            /* @endif */

            var mdc_delete_dialog = mdc_components.dialog.dialog[0];
            mdc_delete_dialog.listen('MDCDialog:closing', function (e) {
                if (e.detail.action == 'yes') {
                    if (delete_user_id != null) {
                        window.location.href =
                            "http://localhost/IS_P2/public/index.php/users/{{ $user_type }}/" +
                            delete_user_id + "/delete";
                    }
                }
            })


            var delete_user_dialog_content = document.querySelector('#delete_user_dialog_content')
            var users_data_table = document.querySelector('#users_data_table')
            users_data_table.addEventListener('click', function (e) {
                if (e.target.tagName == "BUTTON") {
                    if (e.target.classList.contains('mdc-icon-button') && e.target.innerText == 'edit') {
                        let row = e.target.parentElement.parentElement;
                        let id = row.children[0].innerText
                        let first_name = row.children[1].innerText;
                        let last_name = row.children[2].innerText;
                        let email = row.children[3].innerText
                        let phone_number = row.children[4].innerText

                        window.location.href =
                            "http://localhost/IS_P2/public/index.php/users/{{ $user_type }}/" + id + "/edit?" +
                            "f_name=" + first_name +
                            "&l_name=" + last_name +
                            "&email=" + email +
                            "&phone_number=" + phone_number
                    } else if (e.target.classList.contains('mdc-icon-button') && e.target.innerText ==
                        'delete') {
                        let row = e.target.parentElement.parentElement
                        let id = row.children[0].innerText
                        let first_name = row.children[1].innerText
                        let last_name = row.children[2].innerText

                        let delete_user_string = "Are your sure you want to delete " + first_name + " " +
                            last_name +
                            " from the database?";

                        delete_user_dialog_content.innerText = delete_user_string;

                        delete_user_id = id

                        mdc_delete_dialog.open();
                    }
                }
            })

            /* @if(session('custom_status')) */
            var mdc_snackbar_action_status =mdc_components.snackbar.snackbar[0]
            mdc_snackbar_action_status.open();
            /* @endif */

        </script>



        <script src="{{ asset('js/project/users/view_users_page.js') }}"></script>
    @endslot
@endusers
