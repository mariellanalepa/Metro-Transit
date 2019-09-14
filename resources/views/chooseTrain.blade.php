@extends('layouts.admin.planning')

@section('content')
@include('common.status')
<h3>Manage carriage assignments</h3>
<hr>
<div class="col-md-4">
<form id="stop-form" action="{{ url('chooseTrain') }}" method="POST">
  {{ csrf_field() }}
  <div class="form-group">
    <label for="stop">Select train:</label>
    <select class="form-control" name="trainId">
       @foreach($trains as $train)
       <option value="{{ $train->vehicleId }}">
           {{ $train->vehicleId }}: capacity {{ $train->getCapacity() }}
       </option>
       @endforeach
    <select>
  </div>
  <button type="submit" class="btn btn-default">Edit carriage assignments</button>
</form>
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
                var $selectedVehicleId = $table.row(this).data()[0];
                $('#selected').val($selectedVehicleId);
            }  
        });
    });
</script>    

@stop
