@general(['students_active'=>'true'])

    @section('title')
    {{ 'Students' }}
    @endsection

    @slot('drawer')

        @php

            $students_list=[
            ['text'=>'View Students','active'=>($view_students_active ?? null)],
            ['text'=>'View Classes','active'=>($view_classes_active ?? null)],
            ];

        @endphp

        <aside class="mdc-drawer">
            <div class="mdc-drawer__content">
                <nav class="mdc-list" id="list">
                    <h6 class="heading heading--sidebar">
                        <i class="fas fa-school"></i> Students
                    </h6>
                    <div class="mdc-list-group">
                        @foreach($students_list as $list)
                            <a class="mdc-list-item @if($list['active'] !== null){{ 'mdc-list-item--activated' }}@endif"
                                href="#" aria-current="page" section='student'>
                                <span class="mdc-list-item__text">{{ $list['text'] }}</span>
                            </a>
                        @endforeach
                        <li role="separator" class="mdc-list-divider"></li>
                    </div>
                </nav>
            </div>
        </aside>

        <script type="module">
            var students_drawer=document.querySelector('.mdc-drawer')

            students_drawer.addEventListener('click',function(e){

                let link_text=e.target.children[0].innerText;
                let link_section=e.target.getAttribute('section');

                if(link_section='student'){

                    if(link_text=='View Students'){
                        window.location.href="{{ route('students.view') }}"
                    } else if(link_text=='View Classes'){
                        window.location.href="{{ route('classes.view') }}"
                    }
            }
            })
        </script>
    @endslot

    @slot('main_content')
        {{ $main_content }}
    @endslot

@endgeneral
