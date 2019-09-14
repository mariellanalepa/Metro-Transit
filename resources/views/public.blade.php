@extends('layouts.base')

@section('side-nav')
<div class="schedule-tab-menu">
  <div class="list-group">
    <a href="" class="list-group-item active">Schedules by Stop</a>
    <a href="" class="list-group-item">Schedules by Route</a>
  </div>
</div>
@stop

@section('content')
<div class="schedule-tab">
    <!-- Stop Schedules Tab -->
    <div id="StopSchedules" class="schedule-tab-content col-md-4 active">
      <h3>Stop Schedule</h3>
      <hr>
      <form id="stop-form" action="{{ route('stopSchedule') }}" method="POST">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="stop">Select stop:</label>
            <select class="form-control" name="stopId">
               @foreach($stops as $stop)
               <option value="{{ $stop->stopId }}">{{ $stop->stopName }}</option>
               @endforeach
            <select>
          </div>
          <div class="form-group">
            <label for="startTime">Starting from:</label>
            <div class="input-group bootstrap-timepicker timepicker">   
              <input id="timepicker1" type="text" class="form-control input-small" name="startTime">
              <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            </div>
          </div>
          <div class="form-group">
            <label for="endTime">Ending at:</label>
            <div class="input-group bootstrap-timepicker timepicker">
              <input id="timepicker2" type="text" class="form-control input-small" name="endTime">
              <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            </div>
          </div>
          <button type="submit" class="btn btn-default">Submit</button>
      </form>
    </div>
    <!-- Route Schedules Tab -->
    <div id="RouteSchedules" class="schedule-tab-content col-md-4">
      <h3>Route Schedule</h3>
      <hr>
      <form action="{{ route('routeSchedule') }}" method="POST">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="stop">Select route:</label>
            <select class="form-control" name="routeNumber">
               @foreach($routes as $route)
               <option value="{{ $route->routeNumber }}">{{ $route->routeNumber }}</option>
               @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="startTime">Starting from:</label>
            <div class="input-group bootstrap-timepicker timepicker">   
              <input id="timepicker3" type="text" class="form-control input-small" name="startTime">
              <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            </div>
          </div>
          <div class="form-group">
            <label for="endTime">Ending at:</label>
            <div class="input-group bootstrap-timepicker timepicker">
              <input id="timepicker4" type="text" class="form-control input-small" name="endTime">
              <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            </div>
          </div>
          <!--
          <div class=form-group">
              <label for="startTime">Starting at:</label>
              <input id="timepicker" type="text" class="timepicker form-control" name="startTime">
              <span class="glyphicon glyphicon-time"></span>
              <label for="endTime">Ending at:</label>
              <input id="timepicker" type="text" class="timepicker" name="endTime">
              <span class="glyphicon glyphicon-time"></span>
          </div>
          -->
          <button type="submit" class="btn btn-default">Submit</button>
      </form>
    </div>
</div>
@stop

@section('css')
<!--
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
-->
<style>
  body {
    background-image: url(https://images.unsplash.com/photo-1520105072000-f44fc083e508?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1778&q=80);
    background-size: 110%;
  }
  
  .list-group-item:first-child {
      border-top-left-radius: 0px;
      border-top-right-radius: 0px;
  }
  
  .list-group-item:last-child {
      border-top-left-radius: 0px;
      border-top-right-radius: 0px;
  }
  
  .list-group-item {
      padding-top: 10px;
      padding-bottom: 10px;
      border-left: none;
      border-right: none;
  }
  
  .list-group-item, .list-group-item.active, 
  a.list-group-item, a.list-group-item.active {
      background-color: transparent;
      color: white;
      border: none;
  }
   
  a.list-group-item.active, a.list-group-item:hover, a.list-group-item.active:hover {
      text-decoration: none;
  }
  
  a.list-group-item.active, .list-group-item.active:hover {
      background-color: #9d9d9d;
      color: black;
  }
  
  .schedule-tab-content {
      background-color: #ffffff;
      margin-left: -20px;
      margin-top: -20px;
      padding-left: 20px;
      padding-right: 20px;
      padding-top: 10px;
      padding-bottom: 30px;
  }
  
  

  .schedule-tab .schedule-tab-content:not(.active){
      display: none;
  }
</style>
@stop

@section('js')
<script>
    
$(document).ready(function() {
    //$('#timepicker').timepicker({ 'timeFormat': 'HH:mm:ss' });
    $('#timepicker1').timepicker();
    $('#timepicker2').timepicker();
    $('#timepicker3').timepicker();
    $('#timepicker4').timepicker();
    
    $(".schedule-tab-menu>.list-group>a").click(function(e) {
        e.preventDefault();
        // Ensure only one active tab at a time
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $(".schedule-tab>.schedule-tab-content").removeClass("active");
        $(".schedule-tab>.schedule-tab-content").eq(index).addClass("active");
    });
});
</script>
@stop