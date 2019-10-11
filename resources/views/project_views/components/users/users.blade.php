@general(['users_active'=>'true'])

    @section('title')
    {{ 'Users' }}
    @endsection

    @php
        $teachers_list=[
        ['active'=>($view_teachers_active ?? null),'text'=>'View Teachers']
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
                                href="#" aria-current="page">
                                <span class="mdc-list-item__text">{{ $list['text'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </nav>
            </div>
        </aside>
    @endslot



    @slot('main_content')
        {{ $main_content }}
    @endslot


    @slot('scripts')
        <script src="{{ asset('js/project/users/users_page.js') }}">
        </script>
    @endslot
@endgeneral
