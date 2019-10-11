<button class="mdc-tab {{$tab_active ?? 'not-exist'}} mdc-tab--app-bar" role="tab" aria-selected="true" tabindex="0">
    <span class="mdc-tab__content">
        <span class="mdc-tab__text-label">{{$title}}</span>
    </span>
    {{$tab_indicator}}
    <span class="mdc-tab__ripple"></span>
</button>