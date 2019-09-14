@extends('layouts.admin.scheduling')

@section('content')
<div class="container-fluid">
    <span>You are creating the schedule instance:</span>
    <div class="well well-sm">
        <table class="table table-bordered">
            <thead>
              <tr>
                <th>Run Id</th>
                <th>Date</th>
                <th>Admin Id</th>
                <th>Operator Id</th>
                <th>Vehicle Id</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{ $schedule->runId }}</td>
                <td>{{ $schedule->date }}</td>
                <td>{{ $schedule->adminId }}</td>
                <td>{{ $schedule->operatorId }}</td>
                <td>{{ $schedule->vehicleId }}</td>
              </tr>
            </tbody>
        </table>
    </div>
    <form action="{{ url('scheduleConfirmed') }}" method="POST">
    {{ csrf_field() }}
    <input type="submit" class="btn btn-primary" value="Confirm schedule">
    </form>  
</div>
@stop

@section('js')
 @stop
 
 @section('css')
 @stop
