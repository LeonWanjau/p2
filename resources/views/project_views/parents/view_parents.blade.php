@parents(['view_parents_active'=>'true'])

    @slot('main_content')

        <div class="table-container">

            <table id="table_id" class="table table-striped table-bordered" style="width:100%">
                <thead>
                </thead>
                <tbody>
                </tbody>
            </table>

            <script type="module" src="{{ asset('js/project/parents/view_parents_page.js') }}">
            </script>

        </div>
    </div>
    
    @endslot

@endparents
