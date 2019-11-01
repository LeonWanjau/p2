@general(['users_active'=>'true'])

    @section('title')
    {{ 'Users' }}
    @endsection

    @php
        $teachers_list=[
        ['active'=>($view_teachers_active ?? null),'text'=>'View Teachers']
        ];

        $admins_list=[
        ['active'=>($view_admins_active ?? null),'text'=>'View Administrators']
        ];
    @endphp

    @slot('drawer')
        <aside class="mdc-drawer">
            <div class="mdc-drawer__content">
                <nav class="mdc-list" id="list">
                    <h6 class="heading heading--sidebar">
                        <i class="fas fa-chalkboard-teacher"></i> Teachers
                    </h6>
                    <div class="mdc-list-group">
                        @foreach($teachers_list as $list)
                            <a class="mdc-list-item @if($list['active'] !== null){{ 'mdc-list-item--activated' }}@endif"
                                href="#" aria-current="page" section="teacher">
                                <span class="mdc-list-item__text">{{ $list['text'] }}</span>
                            </a>
                        @endforeach
                        <li role="separator" class="mdc-list-divider"></li>
                    </div>

                    <h6 class="heading heading--sidebar">
                        <i class="fas fa-user-shield"></i> Administrators
                    </h6>
                    <div class="mdc-list-group">
                        @foreach($admins_list as $list)
                            <a class="mdc-list-item @if($list['active'] !== null){{ 'mdc-list-item--activated' }}@endif"
                                href="#" aria-current="page" section="admin">
                                <span class="mdc-list-item__text">{{ $list['text'] }}</span>
                            </a>
                        @endforeach
                        <li role="separator" class="mdc-list-divider"></li>
                    </div>
                </nav>
            </div>
        </aside>

        <script type="module">
            var users_drawer=document.querySelector('.mdc-drawer');

            users_drawer.addEventListener('click',function(e){

                let link_text=e.target.children[0].innerText
                let link_section=e.target.getAttribute('section')

                if(link_section=='teacher'){

                    if(link_text=="View Teachers"){
                        window.location.href="{{route('users.view',['user_type'=>'teachers'])}}"
                    }
                }else if(link_section=='admin'){

                    if(link_text=="View Administrators"){
                        window.location.href="{{route('users.view',['user_type'=>'admins'])}}"
                    }
                }
            })
        </script>
    @endslot



    @slot('main_content')
        {{ $main_content }}
    @endslot


    @slot('scripts')
        <script src="{{ asset('js/project/users/users_page.js') }}">
        </script>
    @endslot
@endgeneral
