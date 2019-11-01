@users(['view_teachers_active'=>'true'])

    @slot('main_content')

    
        <div class="table-container">

            <table id="table_id" class="table table-bordered" style="width:100%">
                <thead>
                </thead>
                <tbody>
                </tbody>
            </table>

            <script type="module" src="{{ asset('js/project/users/view_teachers_page.js') }}">
            </script>

        </div>
    </div>
    
    
    @endslot

@endusers