<!DOCTYPE html>

<head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css"/>
<link rel="stylesheet"  href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.css"/>
 
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.js"></script>

<style>
.container{
    display:flex;
    flex-direction:column;
    padding:1px;
    margin:1%;
    width:100%;
}
</style>
</head>

<body>
    <div class="container">
    <table id="table_id" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Column 1</th>
                <th>Column 2</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Row 1 Data 1</td>
                <td>Row 1 Data 2</td>
            </tr>
            <tr>
                <td>Row 2 Data 1</td>
                <td>Row 2 Data 2</td>
            </tr>
        </tbody>
    </table>
</div>

    <script>
            $(document).ready(function () {
                var table = $('#table_id').DataTable();
            })
    
        </script>
    <!--  <script type="module" src="{{ asset('js/project/data_table/data_table.js') }}">-->

</body>
