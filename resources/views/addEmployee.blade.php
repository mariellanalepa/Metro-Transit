@extends('layouts.admin.employees')

@section('content')
<div class="container">
    <h3>Add an employee</h3>
    <hr>
    <!-- Display Validation Errors -->
    @include('common.errors')
    @include('common.status')
    <!-- edit form column -->
    <form id="pers-form" action="{{ url('addEmployee') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}
        <div class="col-sm-6 personal-info">
            
            <h4>Identification</h4>
            <div class="form-group">
                <label class="col-lg-3 control-label">Employee id:</label>
                <div class="col-lg-8">
                    <input class="form-control" type="text" name="employeeId" value="{{ old('employeeId') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">SIN:</label>
                <div class="col-lg-8">
                    <input class="form-control" type="text" name="sin" value="{{ old('sin') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">Employee type:</label>
                <div class="col-lg-8">
                    <input class="form-control" type="text" name="employeeType" value="{{ old('employeeType') }}">
                </div>
            </div>
            <h4>Name</h4>
            <div class="form-group">
                <label class="col-lg-3 control-label">First name:</label>
                <div class="col-lg-8">
                    <input class="form-control" type="text" name="firstName" value="{{ old('firstName') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">Last name:</label>
                <div class="col-lg-8">
                    <input class="form-control" type="text" name="lastName" value="{{ old('lastName') }}">
                </div>
            </div>
            <h4>Address</h4>
            <div class="form-group">
                <label class="col-lg-3 control-label">Street number:</label>
                <div class="col-lg-8">
                    <input class="form-control" type="text" name="streetNumber" value="{{ old('streetNumber') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">Street name:</label>
                <div class="col-lg-8">
                    <input class="form-control" type="text" name="streetName" value="{{ old('streetName') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">City:</label>
                <div class="col-lg-8">
                    <input class="form-control" type="text" name="city" value="{{ old('city') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">State:</label>
                <div class="col-lg-8">
                    <input class="form-control" type="text" name="state" value="{{ old('state') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">Postal code:</label>
                <div class="col-lg-8">
                    <input class="form-control" type="text" name="postcode" value="{{ old('postcode') }}">
                </div>
            </div>
        </div>
        <div class="col-sm-6 personal-info">
            <h4>Phone number</h4>
            <div class="form-group">
                <label class="col-md-3 control-label">Primary:</label>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="phoneNumber" value="{{ old('phoneNumber') }}">
                </div>
            </div>
        </div>
        <div class="col-sm-6 personal-info">
            <h4>Account credentials</h4>
            <div class="form-group">
                <label class="col-md-3 control-label">User name:</label>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="userName" value="{{ old('userName') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Password:</label>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="password" value="{{ old('password') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label"></label>
                <div class="col-md-8">
                    <input id="save" type="submit" class="btn btn-primary" value="Save">
                <span></span>
                <a href="{{ route('addEmployee') }}">
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