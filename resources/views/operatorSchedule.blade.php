@extends('layouts.operator')

@section('content')
@include('common.status')
<h3>My Schedule</h3>
<hr>
<!-- Schedule Table -->
<!-- Wrap it in table-responsive container -->
<div class="table-responsive text-center">
    {{ csrf_field() }}
    <table class="table" id="table">
        <!-- Table Header -->
        <thead>
            <tr>
                <th class="text-center">Schedule id</th>
                <th class="text-center">Date</th>
                <th class="text-center">Route Number</th>
                <th class="text-center">Run Number</th>
                <th class="text-center">Start Time</th>
                <th class="text-center">End Time</th>
                <th class="text-center">Vehicle id</th>
            </tr>
        </thead>
        <!-- Table Body -->
        <tbody>
        <!-- Display info for each route -->
        @foreach($schedules as $schedule)
            <tr class="schedule{{ $schedule->id }}">
                <td>{{ $schedule->id }}</td>
                <td>{{ $schedule->date }}</td>
                <td>{{ $schedule->getRoute() }}</td>
                <td>{{ $schedule->getRun() }}</td> 
                <td>{{ $schedule->getStartTimeString() }}</td>
                <td>{{ $schedule->getEndTimeString() }}</td>
                <td>{{ $schedule->vehicleId }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@stop


@section('js')
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
<script>  
    /* jQuery ready() method makes function available only after
         document is "ready", i.e., loaded 
     * 
     */
    $(document).ready(function() {
        // Use DataTable plugin to make table interactive
        var $table = $('#table').DataTable();
    });
</script>    

@stop
