<div class="mdc-tab-bar" role="tablist">
    <div class="mdc-tab-scroller">
        <div class="mdc-tab-scroller__scroll-area">
            <div class="mdc-tab-scroller__scroll-content">
                @foreach($tabs as $tab)
                    <button class="mdc-tab 
                    @isset($tab['active'])
                    {{
                        'mdc-tab--active'
                     }} 
                     @endisset
                     mdc-tab--app-bar" role="tab" aria-selected="true"
                        tabindex="0">
                        <span class="mdc-tab__content">
                            <span class="mdc-tab__text-label">{{ $tab['title'] }}</span>
                        </span>
                        <span class="mdc-tab__ripple"></span>

                        <span class="mdc-tab-indicator 
                    @isset($tab['active'])
                    {{ 'mdc-tab-indicator--active' }} 
                    @endisset
                    mdc-tab-indicator--app-bar">
                            <span class="mdc-tab-indicator__content mdc-tab-indicator__content--underline"></span>
                        </span>
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</div>
