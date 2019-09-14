@extends('layouts.admin.planning')

@section('content')
<div class="container-fluid">
    <div class="col-sm-6">
        <div class="well well-lg">
            <a class="info-head" href="{{ route('addBus') }}">
                <span class="fas fa-bus"></span> Add a bus
            </a>
            <p class="desc">Add a bus to the fleet</p>
        </div>
        <div class="well well-lg">
            <a class="info-head" href="{{ route('addTrain') }}">
                <span class="fas fa-subway"></span> Add a train
            </a>
            <p class="desc">Add a train with the option to make carriage assignment</p>
        </div>
        <div class="well well-lg">
            <a class="info-head" href="{{ route('addCarriage') }}">
                <span class="fas fa-plus-circle"></span> Add a carriage</a>
            <p class="desc">Add a carriage which can be assigned to a train</p>
        </div>
        <div class="well well-lg">
            <a class="info-head" href="{{ route('chooseTrain') }}">
                <span class="fas fa-arrow-alt-circle-right"></span> Assign carriages</a>
            <p class="desc">Add or modify carriage to train assignments </p>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
.well-lg {
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