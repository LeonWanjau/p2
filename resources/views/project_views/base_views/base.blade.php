<!DOCTYPE html>

<head>
    <title>@yield('title')</title>
</head>

<body style="visibility: hidden;" class="body">
    <div class="page-container">
        <header class="mdc-top-app-bar mdc-top-app-bar--fixed mdc-top-app-bar--position">
            <div class="mdc-top-app-bar__row">
                <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
                    <span>School System</span>
                    @yield('app_bar_start')
                </section>


                <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end">
                    @yield('app_bar_end')
                </section>
            </div>
        </header>


        <div class="content-container">
            @yield('content')
        </div>


        <script type="module">
            var top_app_bar = document.querySelector('.mdc-top-app-bar');
            var content_container = document.querySelector('.content-container');
            //var list_menu=document.querySelector('#list_menu')

            function js_load() {
                content_container.style.marginTop = top_app_bar.offsetHeight+ "px";

                
                if(typeof top_app_bar_list_menu !== "undefined"){
                top_app_bar_list_menu.style.top= top_app_bar.offsetHeight+"px";
                }
                
                
                if (typeof loadContent === 'function'){
                    loadContent();
                }
                document.body.style.visibility = 'visible';
            }

            window.onload=js_load;
        </script>

        <script src="{{ asset('js/project/fonts/fonts.js') }}"></script>

    </div>
</body>
