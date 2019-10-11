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
                        <i class="material-icons" aria-hidden="true">person</i> My Account
                    </h6>
                    <div class="mdc-list-group">
                        @foreach($account_list as $list)
                            <a class="mdc-list-item ripple-surface @if($list['active'] != null){{'mdc-list-item--activated'}}@endif"
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
        {{$main_content ?? null}}

        <script type="module">
            /*
            var mdc_drawer_account_list=mdc_components.list.list[1]
            mdc_drawer_account_list.listen('MDCList:action',function(event){
                let index=event.detail.index
                mdc_drawer_account_list.selectedIndex=index
            })
            */
        </script>
    @endslot

@endgeneral
