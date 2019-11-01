@students(['view_students_active'=>'true'])

    @slot('main_content')

    <div class="table-container">

        <table id="table_id" class="table table-striped table-bordered" style="width:100%">
            <thead>
            </thead>
            <tbody>
            </tbody>
        </table>

        <script src="{{ asset('js/project/students/view_students_page.js') }}">
        </script>

    </div>

    @endslot

@endstudents
