@extends('layouts.admin')

@section('side-nav')
    <p><a class='side-nav-link' href="{{ route('scheduling') }}">View schedules</a></p>
    <p><a class='side-nav-link' href="{{ route('scheduleRoute') }}">Add schedule instance</a></p>
@stop

    
    

