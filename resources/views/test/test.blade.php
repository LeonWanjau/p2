<!DOCTYPE html>

<head>
    <style>
        html,
        body {
            margin: 0px;
            padding: 0px;
            height: 100%;
            overflow: hidden;
        }

    </style>

    <link rel="stylesheet"
        href="{{ asset('js/project/scheduler/codebase/dhtmlxscheduler_material.css') }}"
        type="text/css" />

    <script src="{{ asset('js/project/scheduler/codebase/dhtmlxscheduler.js') }}"> </script>
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

    <title>Test</title>
</head>

<body>

    <div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:100%;'>
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

        scheduler.init("scheduler_here", new Date(2018, 11, 3), "week");

        scheduler.load("{{ route('temp') }}", "json");

        var dp = new dataProcessor("{{ route('temp') }}");
        dp.init(scheduler);
        dp.setTransactionMode("REST");

    </script>
</body>
