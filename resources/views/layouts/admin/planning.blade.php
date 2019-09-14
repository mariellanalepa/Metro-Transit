@extends('layouts.admin')

@section('side-nav')
    <p><a class='side-nav-link' href="{{ route('viewFleet') }}">View fleet</a></p>
    <p><a class='side-nav-link' href="{{ route('manageFleet') }}">Manage fleet resources</a></p>
    <p><a class='side-nav-link' href="{{ route('viewStops') }}">View stops</a></p>
    <p><a class='side-nav-link' href="{{ route('addStop') }}">Add a transit stop</a></p>
    <p><a class='side-nav-link' href="#">View routes</a></p>
    <p><a class='side-nav-link' href="#">Add a route</a></p>
@stop





    
    

