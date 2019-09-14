@extends('layouts.admin.planning')

@section('content')
<a class="btn btn-primary" href="{{ route('chooseTrain') }}">Return to select train</a>
<h3>Carriage assignments for Train {{ $train->vehicleId }}</h3>
<hr>
<div class="container">
    <div class="col-sm-6">
        <!-- Carriage Assignments Table -->
        <div class="well well-lg">
            <div class="well-heading">
                <h4>Current carriage assignments</h4>
            </div>
            <div class="well-body">
                <table class="table table-striped">
                    <thead>
                    <th>Carriage id</th>
                    <th>Capacity</th>
                    </thead>
                    <tbody>
                        @foreach ($carriages as $carriage)
                            <tr>
                                <td>{{ $carriage->carriageId }}</td>
                                <td>{{ $carriage->capacity }}</td>
                                <!-- Carriage Assignment Delete Button -->
                                <td>
                                    <form action="carriageAssignments/{{ $carriage->carriageId }}" method="POST">
                                        {{ csrf_field() }}
                                        <!-- Way of telling Laravel we wish to use DELETE method -->
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-danger">
                                            <span class="glyphicon glyphicon-remove"></span> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Add Carriage Assignment -->
        <div class="well well-lg">
            <div class="well-heading">
                <h4>Add carriage</h4>
            </div>

            <div class="well-body">
                <!-- Display Validation Errors -->
                @include('common.errors')
                @include('common.status')
                <!-- New Contact Form -->
                <form action="{{ url('viewCarriageAssignments') }}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <label class="col-lg-3 control-label" for="stop">Carriage id:</label>
                      <div class="col-lg-8">
                        <select class="form-control" name="carriageId">
                          @foreach($freeCarriages as $carriage)
                            <option value="{{ $carriage->carriageId }}">
                              {{ $carriage->carriageId }}: capacity {{ $carriage->capacity}}
                            </option>
                          @endforeach
                        <select>
                      </div>
                    </div>
                    <!-- Add Assignment Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="btn btn-success">
                                <span class="glyphicon glyphicon-ok"></span> Add Carriage
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>     
    </div>
</div>
@stop


@section('css')

@stop

@section('js')
    

@stop