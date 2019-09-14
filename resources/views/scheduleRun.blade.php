@extends('layouts.admin.scheduling')

@section('content')
@include('common.errors')
@include('common.status')
<h3>You are scheduling Route {{ $routeNumber }} for {{ $date }}</h3>
<hr>
<div class="container-fluid">
        <!-- Unscheduled Run Table -->
        <!-- Wrap it in table-responsive container -->
        <div class="table-responsive text-center">
            {{ csrf_field() }}
            <table class="table" id="table">
                <!-- Table Header -->
                <thead>
                    <tr>
                        <th class="text-center">Run id</th>
                        <th class="text-center">Run number</th>
                        <th class="text-center">Start time</th>
                        <th class="text-center">End time</th>
                    </tr>
                </thead>
                <!-- Table Body -->
                <tbody>
                <!-- Display info for each run -->
                @foreach($runs as $run)
                    <tr class="employee{{ $run->runNumber }}">
                        <td>{{ $run->id }}</td>
                        <td>{{ $run->runNumber }}</td>
                        <td>{{ $run->getStartTimeString() }}</td>
                        <td>{{ $run->getEndTimeString() }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <form id="select-form" action="{{ url('scheduleEmployee') }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" id="selected" name="selectedRunId" value="">
            <input type="submit" class="btn btn-primary" value="Schedule run">
        </form>
</div>
@stop


@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
@stop


@section('js')
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>

<!-- Scripts -->
<script>
    /* Script to initialize datepicker */
    $( function() {
    $( "#datepicker" ).datepicker({
        dateFormat: 'yy-mm-dd'});
    } );
    
    /* jQuery ready() method makes function available only after
         document is "ready", i.e., loaded 
     * 
     */
    $(document).ready(function() {
        // Use DataTable plugin to make table interactive
        var $table = $('#table').DataTable();
        
        // Select item
        $('#table tbody').on('click', 'tr', function() {
            var $runId = $table.row(this).data()[0];
            if ($(this).hasClass('selected'))
            {
                $(this).removeClass('selected');
                $('#selected').val(null);
            }
            else
            {
                $('#table tbody tr').removeClass('selected');
                $(this).addClass('selected');
                $('#selected').val($runId);
            }
        })
    });
</script>    

@stop