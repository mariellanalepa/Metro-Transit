<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stop;
use App\Route;


class PublicSchedulesController extends Controller
{


    /**
     * Access point for public schedules
     */
    public function index()
    {
        // Gather all of the stops and routes to provide to view
        $stops = Stop::all();
        $routes = Route::all();
     
        return view('public', ['stops' => $stops, 
                                    'routes' => $routes]);
    }
    
    /**
     * Supplies the view of the requested stop schedule
     * @param Request $request
     */
    public function getStopSchedule(Request $request)
    {
        // Convert time strings to proper format
        $startTime = date("H:i:s", strtotime($request->startTime));
        $endTime = date("H:i:s", strtotime($request->endTime));
        
        // Find Stop object associated with request
        $stop = Stop::find($request->stopId);
        
        // Get all the routes, and the times these routes arrive at the stop
        $routeTimes = $stop->getSchedule($startTime, $endTime);
        
        return view('stopSchedule', ['stop' => $stop, 'routeTimes' => $routeTimes]);
    }
    
    /**
     * Supplies the view of the requested route schedule
     * @param Request $request
     */
    public function getRouteSchedule(Request $request)
    {
        // Convert time strings to proper format
        $startTime = date("H:i:s", strtotime($request->startTime));
        $endTime = date("H:i:s", strtotime($request->endTime));
       
        // Find Route object associated with request
        $route = Route::find($request->routeNumber);
        
        // Get all of the stops along this route, and the time that we
        // arrive at the stop
        $stopTimes = $route->getSchedule($startTime, $endTime);
                
        return view('routeSchedule', ['route' => $route, 'stopTimes' => $stopTimes]);
           
    }
}
