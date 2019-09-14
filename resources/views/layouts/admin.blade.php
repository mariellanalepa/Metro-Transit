@extends('layouts.base')

@section('head-nav')
    <li class="active"><a href="{{ route('home') }}">Home</a></li>
    <li><a href="{{ route('profile') }}">Profile</a></li>
    <li><a href="{{ route('viewEmployees') }}">Employees</a></li>
    <li><a href="{{ route('routePlanning') }}">Route Planning</a></li>
    <li><a href="{{ route('scheduling') }}">Scheduling</a></li>
@stop



    
    

