@general

    @section('title')
    {{ 'Account' }}
    @endsection

    @php
        $account_list=[
        ['text'=>'View Account','active'=>($view_account_active ?? null)],
        ['text'=>'Edit Account','active'=>($edit_account_active ?? null)],
        ];
    @endphp

    @slot('drawer')
        <aside class="mdc-drawer">
            <div class="mdc-drawer__content">
                <nav class="mdc-list" id="list">
                    <h6 class="heading heading--sidebar">
                        <i class="fas fa-user-circle"></i> My Account
                    </h6>
                    <div class="mdc-list-group">
                        @foreach($account_list as $list)
                            <a class="mdc-list-item ripple-surface @if($list['active'] != null){{'mdc-list-item--activated'}}@endif"
                                href="#" aria-current="page" section="account">
                                <span class="mdc-list-item__text">{{ $list['text'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </nav>
            </div>
        </aside>

        <script type="module">
            var account_drawer=document.querySelector('.mdc-drawer')

            account_drawer.addEventListener('click',function(e){

                let link_text=e.target.children[0].innerText;
                let link_section=e.target.getAttribute('section');

                if(link_section='account'){

                    if(link_text=='View Account'){
                        window.location.href="{{ route('account.view') }}"
                    } else if(link_text=='Edit Account'){
                        window.location.href="{{ route('account.edit.show') }}"
                    }
            }
            })
        </script>

    @endslot

    @slot('main_content')
        {{$main_content ?? null}}
    @endslot

@endgeneral
