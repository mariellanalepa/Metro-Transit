@extends('layouts.operator')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="panel">
                <div class="panel-heading">
                    <h3>Operator Dashboard</h3>
                    <h4>Welcome, {{ $firstName }} {{ $lastName }}</h4>
                </div>
                
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
 @stop
 
 @section('css')
 @stop
