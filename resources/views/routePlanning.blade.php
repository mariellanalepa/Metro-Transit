@extends('layouts.admin.planning')

@section('content')
<div class="container-fluid">
    <div class="col-sm-6">
        <div class="well well-lg">
            <a class="info-head" href="{{ route('viewFleet') }}">
                <span class="fas fa-bus"></span> Fleet (Bus and Train)</a>
            <p class="desc">View and manage transit vehicles</p>
        </div>
        <div class="well well-lg">
            <a class="info-head" href="{{ route('viewStops') }}">
                <span class="fas fa-map-marker-alt"></span> Stops</a>
            <p class="desc">View and manage stop locations</p>
        </div>
        <div class="well well-lg">
            <a class="info-head" href="#">
                <span class="fas fa-map"></span> Routes</a>
            <p class="desc">View and manage routes</p>
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