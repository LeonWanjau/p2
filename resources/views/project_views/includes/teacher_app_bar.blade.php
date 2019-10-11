<div class="mdc-tab-bar" role="tablist">
    <div class="mdc-tab-scroller">
        <div class="mdc-tab-scroller__scroll-area">
            <div class="mdc-tab-scroller__scroll-content">

                <button class="mdc-tab 
@isset($monday_active)
                {{ 'mdc-tab--active' }}
@endisset
                mdc-tab--app-bar" role="tab" aria-selected="true" tabindex="0">
                    <span class="mdc-tab__content">
                        <span class="mdc-tab__text-label">Monday</span>
                    </span>
                    <span class="mdc-tab-indicator 
@isset($monday_active)
                        {{ 'mdc-tab-indicator--active' }}
@endisset
                    mdc-tab-indicator--app-bar">
                        <span class="mdc-tab-indicator__content mdc-tab-indicator__content--underline"></span>
                    </span>
                    <span class="mdc-tab__ripple"></span>
                </button>

                <button class="mdc-tab
@isset($tuesday_active)
                {{ 'mdc-tab--active' }}
@endisset
                mdc-tab--app-bar" role="tab" aria-selected="true" tabindex="0">
                    <span class="mdc-tab__content">
                        <span class="mdc-tab__text-label">Tuesday</span>
                    </span>
                    <span class="mdc-tab-indicator
@isset($tuesday_active)
                    {{ 'mdc-tab-indicator--active' }}
@endisset
                    mdc-tab-indicator--app-bar">
                        <span class="mdc-tab-indicator__content mdc-tab-indicator__content--underline"></span>
                    </span>
                    <span class="mdc-tab__ripple"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<button class="mdc-button mdc-button--app-bar ripple-surface" id="logout_button">
    Logout
</button>

<script>
    var logout_button = document.querySelector('#logout_button');
    logout_button.addEventListener('click', function () {
        window.location.href = "{{ route('logout') }}"

    });

</script>
