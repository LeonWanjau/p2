@parents(['view_parents_active'=>'true'])

@slot('main_content')

    <div class="container container--view-users">

        <form class="form-container form-container--user-search" method="POST"
            action="{{route('parents.add')}}">

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

        <div class="mdc-data-table">

            @php
            $table_head=[
            'ID','First Name','Last Name','Role','Phone Number'
            ];
            @endphp

            <table class="mdc-data-table__table" id="view_teachers_table">
                <thead>
                    <tr class="mdc-data-table__header-row">
                        @foreach($table_head as $head)
                            <th class="mdc-data-table__header-cell" role="columnheader" scope="col">{{ $head }}</th>
                        @endforeach
                    </tr>
                </thead>

                <tbody class="mdc-data-table__content">
                    @isset($parents)
                        @foreach($parents as $parent)
                            <tr class="mdc-data-table__row">
                                <td class="mdc-data-table__cell">{{ $parent->id }}</td>

                                <td class="mdc-data-table__cell">{{ $parent->f_name }}</td>

                                <td class="mdc-data-table__cell">{{ $parent->l_name }}</td>

                                <td class="mdc-data-table__cell">{{ $parent->email }}</td>

                                <td class="mdc-data-table__cell">{{ $parent->phone_number }}</td>

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

@endslot

@endparents
