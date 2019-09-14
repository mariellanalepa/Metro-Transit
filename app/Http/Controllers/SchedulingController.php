<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Employee;
use App\Route;
use App\Schedule;
use App\Operator;
use App\Run;
use App\Vehicle;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class SchedulingController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->session()->has('loggedUser'))
        {
           if ($request->session()->get('loggedUser')->employeeType == "admin")
           {
               $schedules = Schedule::all();
               return view('scheduling', ['schedules'=>$schedules]); 
           }       
        }
                  
        return redirect()->route('public');
    }
    
    /**
     * Show the table of routes 
     */
    public function showRoutes()
    {
        $routes = Route::all();
        return view('scheduleRoute', ['routes'=>$routes]);
    }
    
    /**
     * Show the table of unscheduled runs associated with 
     * selected route 
     */
    public function showRuns(Request $request)
    {
        /*
        if (!$request->filled('selectedRouteNumber'))
        {
            Session::flash('error', 'You must select a route number');
            return redirect()->route('scheduleRoute');
        }*/
        
        
        $validator = Validator::make($request->all(), ['selectedRouteNumber' =>
            'required', 'selectedDate' => 'required']);

        if ($validator->fails()) {
            return redirect()->route('scheduleRoute')
                ->withInput()
                ->withErrors($validator);
        }
        
        
        $selectedRouteNumber = $request->selectedRouteNumber;
        $request->session()->put('selectedRouteNumber', $selectedRouteNumber);
        
        //Start constructing a Schedule object
        $schedule = new Schedule;
        $schedule->date = $request->selectedDate;
        $schedule->adminId = $request->session()->get('loggedUser')->employeeId;
        //We will pass along this Schedule object as a Session variable
        $request->session()->put('newSchedule', $schedule);
        $request->session()->put('selectedDate', $request->selectedDate);
        
        $route = Route::find($selectedRouteNumber);
        $unscheduledRuns = $route->getUnscheduledRuns($request->selectedDate);
        
        return view('scheduleRun', ['routeNumber' => $route->routeNumber, 
            'runs' => $unscheduledRuns, 'date' => $request->selectedDate]);
    }
    
    /**
     * Show the table of employees 
     */
    public function showEmployees(Request $request)
    {
        $validator = Validator::make($request->all(), ['selectedRunId' =>
            'required']);

        if ($validator->fails()) {
            return redirect()->route('scheduleRun')
                ->withInput()
                ->withErrors($validator);
        }
        
        $schedule = $request->session()->get('newSchedule');
        $schedule->runId = $request->selectedRunId;
        
        //Get run for which we are scheduling
        $run = Run::find($request->selectedRunId);
        $request->session()->put('selectedRunNumber', $run->runNumber);
        
        $operators = Operator::getUnscheduledOperators($run, $schedule->date);
        // Get all the employees from the database
        //$employees = User::all();
        //$employees = Employee::all();
        
        
        
        return view('scheduleEmployee', ['operators' => $operators, 
            'selectedRouteNumber' => $request->session()->get('selectedRouteNumber'),
            'selectedDate' => $request->session()->get('selectedDate'),
            'selectedRunNumber' => $request->session()->get('selectedRunNumber')]);
    }
    
    
    public function showVehicles(Request $request)
    {   
        // Set the operatorId to that of the selected employee
        $schedule = $request->session()->get('newSchedule');
        $schedule->operatorId = $request->selectedEmployeeId;
        $selectedOperator = Employee::find($request->selectedEmployeeId)->firstName;
        $request->session()->put('selectedOperator', $selectedOperator);
        
        
        // Find available vehicles for this schedule isntance
        $vehicles = Vehicle::getAllAvailableVehiclesOfType($schedule);
        
        return view('scheduleVehicle', ['vehicles' => $vehicles,
                'selectedRouteNumber' => $request->session()->get('selectedRouteNumber'),
            'selectedDate' => $request->session()->get('selectedDate'),
            'selectedRunNumber' => $request->session()->get('selectedRunNumber'),
            'selectedOperator' => $request->session()->get('selectedOperator')]);
    }
    
    
    public function showConfirmSchedule(Request $request)
    {
        // Set the operatorId to that of the selected employee
        $schedule = $request->session()->get('newSchedule');
        $schedule->vehicleId = $request->selectedVehicleId;
        
        return view('confirmSchedule', ['schedule' => $schedule,
            ]);
    }
    
    public function confirmSchedule(Request $request)
    {
        $schedule = $request->session()->get('newSchedule');
        // Save schedule to database
        if ($schedule->save())
        {
            Session::flash('success', 'The schedule has been recorded');
        }
        else
        {
            Session::flash('error', 'Failed to create schedule instance');
        }
        
        return redirect()->route('scheduling');
    }
    
    public function deleteSchedule(Request $request)
    {   
        //Check if a schedule has been selected
        if ($request->filled('selectedSchedule'))
        {
            $scheduleId = $request->selectedSchedule;
            Schedule::find($scheduleId)->delete();
            Session::flash('success', 'The schedule instance has been deleted');
        }
        else
        {
            Session::flash('error', 
                    'You must select a schedule instance for deletion');
        }
        
        return redirect()->route('scheduling');
    }
}
