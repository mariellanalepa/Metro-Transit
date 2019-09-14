@extends('layouts.admin.profile')

@section('content')
<div class="container">
    <h1>Account Settings</h1>
    <hr>
    <!-- Display Validation Errors -->
    @include('common.errors')
    @include('common.status')
    <!-- edit form column -->
    <form id="pers-form" action="{{ url('accountSettings') }}" method="POST" class="form-horizontal is-readonly">
        {{ csrf_field() }}
        <div class="col-sm-6 personal-info">
            
            <div class="form-group">
                <label class="col-lg-3 control-label">User name:</label>
                <div class="col-lg-8">
                    <input class="form-control" type="text" name="userName" value="{{ old('userName', $employee->userName) }}" disabled>
                </div>
            </div>
        
            <div id="password-dummy-form" class="form-group">
                <label class="col-lg-3 control-label">Password:</label>
                <div class="col-lg-8">
                    <input class="form-control" type="password" name="dummyPassword" value="{{ old('password', "password")}}" disabled>
                </div>
            </div>
            
            <div id="new-password-form" class="form-group">
                <label class="col-lg-3 control-label">New Password:</label>
                <div class="col-lg-8">
                    <input class="form-control" type="password" name="newPassword" value="{{ old('newPassword')}}" disabled>
                </div>
            </div>
            
            <div id="old-password-form" class="form-group">
                <label class="col-lg-3 control-label">Old Password:</label>
                <div class="col-lg-8">
                    <input class="form-control" type="password" name="oldPassword" value="{{ old('oldPassword')}}" disabled>
                </div>
            </div>
        </div>
        <div class="form-group text-center">
                <label class="col-md-3 control-label"></label>
                <div class="col-md-8">
                    <input id="save" type="submit" class="btn btn-primary" value="Save">
                <span></span>
                <a href="{{ route('accountSettings') }}">
                    <button type="button" id="cancel" class="btn btn-primary">
                        Cancel</button></a>
                </div>
        </div>
        <div class="col-sm-6 text-center">
        <button id="edit" type="button" class="btn btn-primary btn-edit">Edit</button>
        </div>
    </form>
    </div>
</div>
<hr>

@stop


@section('css')
<style>
#save,#cancel,#new-password-form,#old-password-form {
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
        $('#password-dummy-form').hide();
        $('#save, #cancel, #new-password-form, #old-password-form').show();
        var $form = $('#pers-form')
        $form.toggleClass('is-readonly');
        $form.find('input,textarea').prop('disabled', false);
    });
});
</script>     

@stop