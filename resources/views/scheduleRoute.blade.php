@extends('layouts.admin.scheduling')

@section('content')
    @include('common.errors')
    @include('common.status')
    <h3>Choose a route</h3>
    <hr>
    <!-- Route Table -->
    <!-- Wrap it in table-responsive container -->
    <div class="table-responsive text-center">
        {{ csrf_field() }}
        <table class="table" id="table">
            <!-- Table Header -->
            <thead>
                <tr>
                    <th class="text-center">Route number</th>
                    <th class="text-center">Service start time</th>
                    <th class="text-center">Total run time</th>
                    <th class="text-center">Runs per day</th>
                    <th class="text-center">Vehicle type</th>
                </tr>
            </thead>
            <!-- Table Body -->
            <tbody>
            <!-- Display info for each route -->
            @foreach($routes as $route)
                <tr class="employee{{ $route->routeNumber }}">
                    <td>{{ $route->routeNumber }}</td>
                    <td>{{ $route->serviceStartTime }}</td>
                    <td>{{ $route->getTotalRunTimeString() }}</td>
                    <td>{{ $route->runsPerDay }}</td>
                    <td>{{ $route->vehicleType }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <hr>
    <h3>Pick a date</h3>  
    <hr>
    <form id="select-form" action="{{ url('scheduleRun') }}" method="POST">
        {{ csrf_field() }}
        <div class="form-group">
          <label for="datepicker">Date: </label>
          <input type="text" id="datepicker" name="selectedDate">
        </div>
        <div class="form-group text-center">
          <input type="hidden" id="selected" name="selectedRouteNumber" value="">
          <input type="submit" class="btn btn-primary" value="Schedule route">
        </div> 
    </form>       
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
            var $routeId = $table.row(this).data()[0];
            if ($(this).hasClass('selected'))
            {
                $(this).removeClass('selected');
                $('#selected').val(null);
            }
            else
            {
                $('#table tbody tr').removeClass('selected');
                $(this).addClass('selected');
                $('#selected').val($routeId);
            }
        })
    });
</script>    

@stop