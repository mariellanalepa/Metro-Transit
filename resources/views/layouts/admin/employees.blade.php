@extends('layouts.admin')

@section('side-nav')
    <p><a class='side-nav-link' href="{{ route('viewEmployees') }}">View employees</a></p>
    <p><a class='side-nav-link' href="{{ route('addEmployee') }}">Add a new employee</a></p>
@stop

    
    

