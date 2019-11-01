@teachers(['view_schedule_active'=>'true'])

    @slot('main_content')

        <link rel="stylesheet"
            href="{{ asset('js/project/scheduler/codebase/dhtmlxscheduler_material.css') }}"
            type="text/css" />

        <script src="{{ asset('js/project/scheduler/codebase/dhtmlxscheduler.js') }}">
        </script>
        <script
            src="{{ asset('js/project/scheduler/codebase/ext/dhtmlxscheduler_recurring.js') }}">
        </script>
        <script
            src="{{ asset('js/project/scheduler/codebase/ext/dhtmlxscheduler_active_links.js') }}">
        </script>
        <script
            src="{{ asset('js/project/scheduler/codebase/ext/dhtmlxscheduler_year_view.js') }}">
        </script>
        <script
            src="{{ asset('js/project/scheduler/codebase/ext/dhtmlxscheduler_container_autoresize.js') }}">
        </script>


        <div class="scheduler-container">
            
            <div id="scheduler_here" class="dhx_cal_container" style="width:100%;">
            </div>
            
        </div>



        <script>
            
            scheduler.config.date_format = "%Y-%m-%d %H:%i:%s";
            scheduler.config.header = [
                "day",
                "week",
                "month",
                "year",
                "date",
                "prev",
                "today",
                "next"
            ];
            scheduler.config.show_loading = true;

            scheduler.setLoadMode("day");

            scheduler.init("scheduler_here", new Date(), "week");

            scheduler.load("{{ route('schedule.load') }}", "json");

            var dp = new dataProcessor("{{ route('schedule.load') }}");
            dp.init(scheduler);
            dp.setTransactionMode("REST");
            
        </script>

    @endslot

@endteachers
