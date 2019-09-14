@extends('layouts.admin.planning')

@section('content')
@include('common.status')
<h3>Transit stops</h3>
<hr>
<!-- Stops Table -->
<!-- Wrap it in table-responsive container -->
<div class="table-responsive text-center">
    {{ csrf_field() }}
    <table class="table" id="table">
        <!-- Table Header -->
        <thead>
            <tr>
                <th class="text-center">Stop Id</th>
                <th class="text-center">Stop name</th>
            </tr>
        </thead>
        <!-- Table Body -->
        <tbody>
        <!-- Display info for each stop -->
        @foreach($stops as $stop)
            <tr class="stop{{ $stop->stopId }}">
                <td>{{ $stop->stopId }}</td>
                <td>{{ $stop->stopName }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<hr> 
<form id="select-form" action="{{ url('deleteStop') }}" method="POST">
  {{ csrf_field() }}        
  <div class="form-group text-center">
    <a class="btn btn-primary" href="{{ route('addStop') }}">Add a transit stop</a>
    <input type="hidden" id="selected" name="selectedStopId" value="">
    <input type="submit" class="btn btn-primary" value="Delete selected stop" >
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
    /* jQuery ready() method makes function available only after
         document is "ready", i.e., loaded 
     * 
     */
    $(document).ready(function() {
        // Use DataTable plugin to make table interactive
        var $table = $('#table').DataTable();
        
        // Select table item
        $('#table tbody').on('click', 'tr', function() {
            if ($(this).hasClass('selected'))
            {
                $(this).removeClass('selected');
            }
            else
            {
                $('#table tbody tr').removeClass('selected');
                $(this).addClass('selected');
                var $selectedStopId = $table.row(this).data()[0];
                $('#selected').val($selectedStopId);
            }  
        });
    });
</script>    

@stop
