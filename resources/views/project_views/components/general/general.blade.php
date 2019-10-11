@extends('project_views/base_views/base')

@section('app_bar_end')
<div class="mdc-tab-bar" role="tablist">
    <div class="mdc-tab-scroller">
        <div class="mdc-tab-scroller__scroll-area">
            <div class="mdc-tab-scroller__scroll-content">
                @php
                    if(Auth::user() != null){
                    if(Auth::user()->role_id==2){
                    $tabs=[
                    ['title'=>'Users','active'=>$users_active??null],
                    ['title'=>'Parents','active'=>$parents_active??null],
                    ['title'=>'Students','active'=>$students_active??null],
                    ['title'=>'Messages','active'=>$messages_active??null],
                    ];
                    }else if(Auth::user()->role_id==1){
                    $tabs=[
                    ['title'=>'Teachers','active'=>$teachers_active??null],
                    ['title'=>'Parents','active'=>$parents_active??null],
                    ['title'=>'Students','active'=>$students_active??null],
                    ['title'=>'Messages','active'=>$messages_active??null],
                    ];
                    }}
                    else{
                    $tabs=[
                    ['title'=>'Users','active'=>$users_active??null],
                    ['title'=>'Teachers','active'=>$teachers_active??null],
                    ['title'=>'Parents','active'=>$parents_active??null],
                    ['title'=>'Students','active'=>$students_active??null],
                    ['title'=>'Messages','active'=>$messages_active??null],
                    ];
                    }
                @endphp

                @foreach($tabs as $tab)
                    <button class="mdc-tab 
@isset($tab['active'])
                        {{ 'mdc-tab--active' }} 
@endisset
                        mdc-tab--app-bar" role="tab" aria-selected="true" tabindex="0">
                        <span class="mdc-tab__content">
                            <span class="mdc-tab__text-label">{{ $tab['title'] }}</span>
                        </span>
                        <span class="mdc-tab-indicator 
@isset($tab['active'])
                            {{ 'mdc-tab-indicator--active' }}
@endisset
                             mdc-tab-indicator--app-bar">
                            <span class="mdc-tab-indicator__content mdc-tab-indicator__content--underline"></span>
                        </span>
                        <span class="mdc-tab__ripple"></span>
                    </button>
                @endforeach


            </div>
        </div>
    </div>
</div>
<!--
<button class="mdc-button mdc-button--app-bar ripple-surface" id="logout_button">
    Logout
</button>
-->

<button class="mdc-icon-button material-icons" id="top_app_bar_menu_icon">menu</button>


<div class="mdc-menu mdc-menu-surface mdc-menu-surface--fixed" id="top_app_bar_list_menu">
    <!--
    <div>
        <i class="material-icons" aria-hidden="true">person</i> <p>Username</p>
    </div>
    -->
    <nav class="mdc-list">

        <h6 class="heading heading--top-app-bar-list">
            <i class="material-icons" aria-hidden="true">person</i>
            <p class="label">
                @auth
                    {{ Auth::user()->f_name." ".Auth::user()->l_name }}
                @endauth
            </p>
        </h6>

        <li role="separator" class="mdc-list-divider"></li>
        <a class="mdc-list-item" href="{{ route('account.view') }}" aria-current="page">
            <i class="fas fa-address-card mdc-list-item__graphic"></i>
            <span class="mdc-list-item__text">My Account</span>
        </a>
        <a class="mdc-list-item" href="#">
            <i class="fas fa-sign-out-alt mdc-list-item__graphic"></i>
            <span class="mdc-list-item__text">Logout</span>
        </a>
    </nav>
</div>


@endsection

@section('content')

<div class="drawer-container position-fixed">
    {{ $drawer ?? null }}
</div>

<div class="main-content-container">
    {{ $main_content ?? null }}
</div>

<script>
    /*
    var logout_button = document.querySelector('#logout_button');
    logout_button.addEventListener('click', function () {
        window.location.href = "{{ route('logout') }}"

    });
    */

    //Properly position drawer and main content
    var drawer_container = document.querySelector('.drawer-container')
    var main_content_container = document.querySelector('.main-content-container')

    function loadContent() {
        main_content_container.style.marginLeft = drawer_container.offsetWidth + "px";
    }

</script>

<script src="{{ asset('js/project/general/general_component.js') }}"></script>

<script type="module">
    var top_app_bar_menu_icon=document.querySelector('#top_app_bar_menu_icon')
    var top_app_bar_list_menu=document.querySelector('#top_app_bar_list_menu')

    top_app_bar_menu_icon.addEventListener('click',function(e){
        if(top_app_bar_list_menu.classList.contains('mdc-menu-surface--open')){
            top_app_bar_list_menu.classList.remove('mdc-menu-surface--open')
        }else{
            top_app_bar_list_menu.classList.add('mdc-menu-surface--open')
        }
    })
</script>


{{ $scripts ?? null }}
@endsection
