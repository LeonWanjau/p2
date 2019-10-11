@account(['view_account_active'=>'true'])

    @slot('main_content')

        <div class="card-container card-container--main-content">

            <div class="mdc-card">

                <h4 class="heading heading--form">My Account</h4>

                <ul class="mdc-list">
                    <li class="mdc-list-item mdc-list-item--account-information" tabindex="0">
                        <span class="mdc-list-item__text">First Name</span>
                        <span class="mdc-list-item__text">{{ Auth::user()->f_name ?? null }}</span>
                    </li>
                    <li role="separator" class="mdc-list-divider"></li>
                    <li class="mdc-list-item mdc-list-item--account-information">
                        <span class="mdc-list-item__text">Last Name</span>
                        <span>{{ Auth::user()->l_name ?? null }}</span>
                    </li>
                    <li role="separator" class="mdc-list-divider"></li>
                    <li class="mdc-list-item mdc-list-item--account-information">
                        <span class="mdc-list-item__text">Phone Number</span>
                        <span>{{ Auth::user()->phone_number ?? null }}</span>
                    </li>
                    <li role="separator" class="mdc-list-divider"></li>
                    <li class="mdc-list-item mdc-list-item--account-information">
                        <span class="mdc-list-item__text">Email Address</span>
                        <span>{{ Auth::user()->email ?? null }}</span>
                    </li>
                </ul>

                <button class="mdc-fab mdc-fab--bottom-right ripple-surface" title="Edit Account"
                    id="edit_account_fab_span">
                    <span class="mdc-fab__icon material-icons">edit</span>
                </button>

            </div>

        </div>

        <div class="mdc-snackbar mdc-snackbar--custom-fill">
            <div class="mdc-snackbar__surface">
                <div class="mdc-snackbar__label" role="status" aria-live="polite">
                    @if(session('custom_status'))
                        {{ session('custom_status') }}
                    @endif
                </div>
                <div class="mdc-snackbar__actions">
                    <button type="button" class="mdc-icon-button material-icons mdc-snackbar__dismiss">close</button>
                </div>
            </div>
        </div>


        <script type="module">
            //show snackbar
            /* @if(session('custom_status')) */
            var mdc_snackbar_action_status =mdc_components.snackbar.snackbar[0]
            mdc_snackbar_action_status.open();
            /* @endif */

            //fab span
            
            var edit_account_fab_span=document.querySelector('#edit_account_fab_span')
            edit_account_fab_span.addEventListener('click',function(e){
                window.location.href="{{ route('account.edit.show') }}"
            })
            
        </script>
    @endslot

@endaccount
