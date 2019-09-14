@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="col-lg-8">
        @include('common.errors')
        @include('common.status')

        <form id="pers-form" action="{{ url('personalInfo') }}" method="POST" class="form-horizontal is-readonly">
            {{ csrf_field() }}
            <label for="form-control" class="col-lg-3 control-label">Phone number:</label>
            <div class="col-lg-8">
                <input type="text" name="phoneNumber" id="phone-number" class="form-control" value="{{ old('phoneNumber', $employee->getPhoneNumber())}}" disabled>
            </div>
            <div class="col-lg-8">
                <input id="save" type="submit" class="btn btn-primary" value="Save">
                <span></span>
                <a href="{{ route('personalInfo') }}"><button type="button" id="cancel" class="btn btn-primary">Cancel</button></a>
            </div>
        </form>
    </div>
    <div class="col-lg-8">
        <button id="edit" type="button" class="btn btn-primary btn-edit">Edit</button>
    </div>
</div>



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