@extends('layouts.admin.scheduling')

@section('content')
@include('common.errors')
@include('common.status')
<h3>You are scheduling Route {{ $selectedRouteNumber }}, 
    Run {{ $selectedRunNumber }} for {{ $selectedDate }}, 
    with Operator {{ $selectedOperator }}</h3>
<hr>
<!-- Vehicle Table -->
<!-- Wrap it in table-responsive container -->
<div class="table-responsive text-center">
    {{ csrf_field() }}
    <table class="table" id="table">
        <!-- Table Header -->
        <thead>
            <tr>
                <th class="text-center">Vehicle ID</th>
                <th class="text-center">Vehicle Type</th>
                <th class="text-center">Capacity</th>
            </tr>
        </thead>
        <!-- Table Body -->
        <tbody>
        <!-- Display info for each employee -->
        @foreach($vehicles as $vehicle)
            <tr class="vehicle{{ $vehicle->vehicleId }}">
                <td>{{ $vehicle->vehicleId }}</td>
                <td>{{ $vehicle->vehicleType }}</td>
                <td>{{ $vehicle->getCapacity() }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<form id="select-form" action="{{ url('confirmSchedule') }}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" id="selected" name="selectedVehicleId" value="">
    <input type="submit" class="btn btn-primary" value="Select vehicle">
</form>   
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
    /* jQuery ready() method makes function available only after
         document is "ready", i.e., loaded 
     * 
     */
    $(document).ready(function() {
        // Use DataTable plugin to make table interactive
        var $table = $('#table').DataTable();
        
        // Select item
        $('#table tbody').on('click', 'tr', function() {
            var $vehicleId = $table.row(this).data()[0];
            if ($(this).hasClass('selected'))
            {
                $(this).removeClass('selected');
                $('#selected').val(null);
            }
            else
            {
                $('#table tbody tr').removeClass('selected');
                $(this).addClass('selected');
                $('#selected').val($vehicleId);
            }
        })
    });
</script>  
@stop