@general(['parents_active'=>'true'])

    @section('title')
    {{ 'Parents' }}
    @endsection

    @slot('drawer')

        @php

            $parents_list=[
            ['text'=>'View Parents','active'=>($view_parents_active ?? null)]
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
                                href="#" aria-current="page" section="parent">
                                <span class="mdc-list-item__text">{{ $list['text'] }}</span>
                            </a>
                        @endforeach
                        <li role="separator" class="mdc-list-divider"></li>
                    </div>
                </nav>
            </div>
        </aside>

        <script type="module">
            var parents_drawer=document.querySelector('.mdc-drawer')
    
                parents_drawer.addEventListener('click',function(e){
    
                    let link_text=e.target.children[0].innerText;
                    let link_section=e.target.getAttribute('section');
    
                if(link_section=='parent'){
                    if(link_text=='View Parents'){
                        window.location.href="{{ route('parents.view') }}";
                    }
                }
                })
    
            </script>

    @endslot

    @slot('main_content')
        {{ $main_content ?? null }}
    @endslot

@endgeneral
