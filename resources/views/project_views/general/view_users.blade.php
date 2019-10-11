@users
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

            <form class="form-container form-container--user-search" method="POST" action="">

                {{ csrf_field() }}

                <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-trailing-icon">
                    <input type="text" class="mdc-text-field__input" name="search_value">
                    <i class="material-icons mdc-text-field__icon" tabindex="0" role="button">search</i>
                    <div class="mdc-notched-outline">
                        <div class="mdc-notched-outline__leading"></div>
                        <div class="mdc-notched-outline__notch">
                            <label for="tf-outlined" class="mdc-floating-label">Search</label>
                        </div>
                        <div class="mdc-notched-outline__trailing"></div>
                    </div>
                </div>

            </form>

            <div class="mdc-data-table">


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




            <script>
                /*
                    var show_all_teachers_button = document.querySelector('#show_all_teachers_button')
                    show_all_teachers_button.addEventListener('click', function (e) {
                        e.preventDefault();
                        window.location.href =""
                    })
                    */

            </script>

            <script src="{{ asset('js/project/general/users/view_users_page.js') }}"></script>

        </div>
    @endslot
@endusers
