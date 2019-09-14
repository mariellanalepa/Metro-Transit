@extends('layouts.admin.planning')

@section('content')
<div class="container">
    <h3>Add a transit stop</h3>
    <hr>
    <!-- Display Validation Errors -->
    @include('common.errors')
    @include('common.status')
    <!-- edit form column -->
    <form id="pers-form" action="{{ url('addStop') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}
        <div class="col-sm-6 personal-info">
            
            <h4>Identification</h4>
            <div class="form-group">
                <label class="col-lg-3 control-label">Stop id:</label>
                <div class="col-lg-8">
                    <input class="form-control" type="text" name="stopId" value="{{ old('stopId') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">Stop name:</label>
                <div class="col-lg-8">
                    <input class="form-control" type="text" name="stopName" value="{{ old('stopName') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label"></label>
                <div class="col-md-8">
                    <input id="save" type="submit" class="btn btn-primary" value="Save">
                <span></span>
                <a href="{{ route('manageFleet') }}">
                    <button type="button" id="cancel" class="btn btn-primary">
                        Cancel</button></a>
                </div>
            </div>
        </div>
    </form>
    </div>
</div>
<hr>

@stop


@section('css')
@stop

@section('js')
@stop