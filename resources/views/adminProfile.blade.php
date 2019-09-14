@extends('layouts.admin.profile')

@section('content')
<div class="container-fluid">
    <div class="col-sm-6">
        <div class="well well-lg">
            <a class="info-head" href="{{ route('accountSettings') }}">
                <span class="glyphicon glyphicon-user"></span> Account Settings</a>
            <p class="desc">View and edit username and password</p>
        </div>
        <div class="well well-lg">
            <a class="info-head" href="{{ route('personalInfo') }}">
                <span class="glyphicon glyphicon-edit"></span> Personal Information</a>
            <p class="desc">View and edit name, address, and phone numbers</p>
        </div>
        <div class="well well-lg">
            <a class="info-head" href="{{ route('emergencyContacts') }}">
                <span class="glyphicon glyphicon-phone-alt"></span> Emergency Contacts</a>
            <p class="desc">View and edit emergency contacts</p>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
.glyphicon-user, .gylphicon-edit, .glyphicon-phone-alt, .well-lg {
    font-size: 25px;
}

.desc {
    font-size: 20px;
    padding-top: 20px;
}

.info-head {
    color: #9D0D13;
}

</style>
@stop

@section('js')
<script>
</script>    

@stop