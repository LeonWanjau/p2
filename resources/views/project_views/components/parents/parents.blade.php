@general(['parents_active'=>'true'])

    @section('title')
    {{ 'Parents' }}
    @endsection

    @slot('drawer')

        @php

            $parents_list=[
            ['text'=>'View Parents','active'=>($view_parents_active ?? null)],
            ['text'=>'Add Parent','active'=>($add_parent_active ?? null)],
            ];

        @endphp

        <aside class="mdc-drawer">
            <div class="mdc-drawer__content">
                <nav class="mdc-list" id="list">
                    <h6 class="heading heading--sidebar">
                        <i class="fas fa-user-friends"></i> Parents
                    </h6>
                    <div class="mdc-list-group">
                        @foreach($parents_list as $list)
                            <a class="mdc-list-item @if($list['active'] !== null){{ 'mdc-list-item--activated' }}@endif"
                                href="#" aria-current="page">
                                <span class="mdc-list-item__text">{{ $list['text'] }}</span>
                            </a>
                            <li role="separator" class="mdc-list-divider"></li>
                        @endforeach
                    </div>
                </nav>
            </div>
        </aside>

    @endslot

    @slot('main_content')
        {{$main_content ?? null}}
    @endslot

@endgeneral
