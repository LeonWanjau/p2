@general(['teachers_active'=>'true'])

    @section('title')
    {{ 'Teachers' }}
    @endsection

    @slot('drawer')

        @php

            $schedule_list=[
            ['text'=>'View Schedule','active'=>($view_schedule_active ?? null)],
            ];

        @endphp

        <aside class="mdc-drawer">
            <div class="mdc-drawer__content">
                <nav class="mdc-list" id="list">
                    <h6 class="heading heading--sidebar">
                        <i class="fas fa-calendar-alt"></i> My Schedule
                    </h6>
                    <div class="mdc-list-group">
                        @foreach($schedule_list as $list)
                            <a class="mdc-list-item @if($list['active'] !== null){{ 'mdc-list-item--activated' }}@endif"
                                href="#" aria-current="page" section="schedule">
                                <span class="mdc-list-item__text">{{ $list['text'] }}</span>
                            </a>
                        @endforeach
                        <li role="separator" class="mdc-list-divider"></li>
                    </div>
                </nav>
            </div>
        </aside>

        <script type="module">
            var teachers_drawer=document.querySelector('.mdc-drawer')

            teachers_drawer.addEventListener('click',function(e){

                let link_text=e.target.children[0].innerText;
                let link_section=e.target.getAttribute('section');

            if(link_section=='schedule'){
                if(link_text=='View Schedule'){
                    window.location.href="{{ route('schedule.view') }}";
                }
            }
            })

        </script>
    @endslot

    @slot('main_content')
        {{ $main_content ?? null }}
    @endslot

@endgeneral
