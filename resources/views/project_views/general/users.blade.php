@general(['users_active'=>'true'])

    @section('title')
    {{ 'Users' }}
    @endsection

    @php
        $teachers_list=[
        ['active'=>'mdc-list-item--activated','text'=>'View Teachers']
        ];
    @endphp

    @slot('drawer')

        @drawer

            @slot('drawer_content')

                @list
                    @slot('list_content')

                        @list_subheader

                            @slot('list_subheader_icon')
                                <i class="fas fa-chalkboard-teacher"></i>
                            @endslot

                            @slot('list_subheader_text')
                                Teachers
                            @endslot

                        @endlist_subheader

                        @list_group
                            @slot('list_group_content')
                                @foreach($teachers_list as $list)
                                    @list_item($list)
                                    @endlist_item
                                @endforeach
                            @endslot
                        @endlist_group
                    @endslot
                @endlist

            @endslot

        @enddrawer

    @endslot

    {
    @slot('main_content')
    
        @view_users(['users'=>($users ?? null)])
        @endview_users
    @endslot
    

    @slot('scripts')
        <script src="{{ asset('js/project/general/users_page.js') }}"></script> 
    @endslot
@endgeneral
