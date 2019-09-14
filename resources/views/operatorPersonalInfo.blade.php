@extends('layouts.operator.profile')

@section('content')
<div class="container">
    <h1>Personal information</h1>
    <hr>
    <!-- Display Validation Errors -->
    @include('common.errors')
    @include('common.status')
    <!-- edit form column -->
    <form id="pers-form" action="{{ url('personalInfo') }}" method="POST" class="form-horizontal is-readonly">
        {{ csrf_field() }}
        <div class="col-sm-6 personal-info">
            
            <h3>Name</h3>
            <div class="form-group">
                <label class="col-lg-3 control-label">First name:</label>
                <div class="col-lg-8">
                    <input class="form-control" type="text" name="firstName" value="{{ old('firstName', $employee->firstName) }}" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">Last name:</label>
                <div class="col-lg-8">
                    <input class="form-control" type="text" name="lastName" value="{{ old('lastName', $employee->lastName) }}" disabled>
                </div>
            </div>
            <h3>Address</h3>
            <div class="form-group">
                <label class="col-lg-3 control-label">Street number:</label>
                <div class="col-lg-8">
                    <input class="form-control" type="text" name="streetNumber" value="{{ old('streetNumber', $employee->streetNumber) }}" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">Street name:</label>
                <div class="col-lg-8">
                    <input class="form-control" type="text" name="streetName" value="{{ old('streetName', $employee->streetName) }}" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">City:</label>
                <div class="col-lg-8">
                    <input class="form-control" type="text" name="city" value="{{ old('city', $employee->city) }}" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">State:</label>
                <div class="col-lg-8">
                    <input class="form-control" type="text" name="state" value="{{ old('state', $employee->state) }}" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">Postal code:</label>
                <div class="col-lg-8">
                    <input class="form-control" type="text" name="postcode" value="{{ old('postcode', $employee->postcode) }}" disabled>
                </div>
            </div>
        </div>
        <div class="col-sm-6 personal-info">
            <h3>Phone number</h3>
            <div class="form-group">
                <label class="col-md-3 control-label">Primary:</label>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="phoneNumber" value="{{ old('phoneNumber', $employee->getPhoneNumber()) }}" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label"></label>
                <div class="col-md-8">
                    <input id="save" type="submit" class="btn btn-primary" value="Save">
                <span></span>
                <a href="{{ route('personalInfo') }}">
                    <button type="button" id="cancel" class="btn btn-primary">
                        Cancel</button></a>
                </div>
            </div>
        </div>
    </form>
    </div>
    <div class="col-sm-6 text-center">
        <button id="edit" type="button" class="btn btn-primary btn-edit">Edit</button>
    </div>
</div>
<hr>

@stop


@section('css')
<style>
#save,#cancel {
  display: none;
}    
    
form.is-readonly input[disabled],
form.is-readonly textarea[disabled] {
  cursor: text;
  background-color: #fff;
  border-color: transparent;
  outline-color: transparent;
  box-shadow: none;
}
</style>
@stop

@section('js')
<!-- Scripts -->
<script>
$(document).ready(function(){
    $('#edit').on('click', function(){
        $(this).hide();
        $('#save, #cancel').show();
        var $form = $('#pers-form')
        $form.toggleClass('is-readonly');
        $form.find('input,textarea').prop('disabled', false);
    });
});
</script>     

@stop