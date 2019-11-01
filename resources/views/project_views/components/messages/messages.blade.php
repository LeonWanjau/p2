@general(['messages_active'=>'true'])

    @section('title')
    {{ 'Messages' }}
    @endsection

    @slot('drawer')

        @php

            $parents_messages_list=[
            ['text'=>'View Messages Received','active'=>($view_parents_messages_received ?? null)],
            ['text'=>'View Messages Sent','active'=>($view_parents_messages_sent ?? null)],
            ];

            $teachers_messages_list=[
            ['text'=>'View Messages Sent','active'=>($view_teachers_messages_sent ?? null)]
            ];

        @endphp

        <aside class="mdc-drawer mdc-drawer--messages">
            <div class="mdc-drawer__content">
                <nav class="mdc-list" id="list">
                    <h6 class="heading heading--sidebar">
                        <span class="fa-stack">
                            <i class="far fa-comment fa-stack-2x"></i>
                            <i class="fas fa-user-friends fa-stack-1x"></i>
                        </span>
                        Parent Messages
                    </h6>
                    <div class="mdc-list-group">
                        @foreach($parents_messages_list as $list)
                            <a class="mdc-list-item @if($list['active'] !== null){{ 'mdc-list-item--activated' }}@endif"
                                href="#" aria-current="page" section="parent">
                                <span class="mdc-list-item__text">{{ $list['text'] }}</span>
                            </a>
                        @endforeach
                        <li role="separator" class="mdc-list-divider"></li>
                    </div>


                    <h6 class="heading heading--sidebar">
                        <span class="fa-stack">
                            <i class="far fa-comment fa-stack-2x"></i>
                            <i class="fas fa-chalkboard-teacher fa-stack-1x"></i>
                        </span>
                        Teacher Messages
                    </h6>
                    <div class="mdc-list-group">
                        @foreach($teachers_messages_list as $list)
                            <a class="mdc-list-item @if($list['active'] !== null){{ 'mdc-list-item--activated' }}@endif"
                                href="#" aria-current="page" section="teacher">
                                <span class="mdc-list-item__text">{{ $list['text'] }}</span>
                            </a>
                        @endforeach
                        <li role="separator" class="mdc-list-divider"></li>
                    </div>
                </nav>
            </div>
        </aside>

        <script type="module">
            var messages_drawer=document.querySelector('.mdc-drawer')

            messages_drawer.addEventListener('click',function(e){

                let link_text=e.target.children[0].innerText
                let link_section=e.target.getAttribute('section')
                
                if(link_section=='parent'){
                    if(link_text=="{{ $parents_messages_list[0]['text'] }}"){

                    window.location.href="{{ route('messages.parents.received.show') }}"
                    } else if(link_text=="{{ $parents_messages_list[1]['text'] }}"){

                        window.location.href="{{ route('messages.parents.sent.show') }}"
                    }
                }else if(link_section=='teacher'){
                    if(link_text=="{{ $teachers_messages_list[0]['text'] }}"){

                        window.location.href="{{ route('messages.teachers.sent.show') }}"
                    }
                    
                }
                
            })

        </script>
    @endslot

    @slot('main_content')
        {{ $main_content ?? null }}
    @endslot


@endgeneral
