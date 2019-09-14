<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Employee;
use App\Route;
use App\Schedule;
use App\Operator;
use App\Run;
use App\Stop;
use App\Vehicle;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ManageStopsController extends Controller
{
    
    /*
     * To access add stop form
     */
    public function addStop(Request $request)
    {
         if ($request->session()->has('loggedUser'))
        {
            // Get the user
            $employee = $request->session()->get('loggedUser');
            // Only return view if user is admin
            if ($employee->employeeType == "admin")
            {     
               return view('addStop');
            }         
        }
        
        return redirect()->route('public');
    }
    
    /*
     * Confirm add stop request
     */
    public function confirmStop(Request $request)
    {
        $validator = Validator::make($request->all(), 
                Stop::AddStopRules());
        

        if ($validator->fails()) {
            return redirect()->route('addStop')
                ->withInput()
                ->withErrors($validator);
        }
        
        // Create new stop instance
        $stop = new Stop();
        $stop->stopId = $request->stopId;
        $stop->stopName = $request->stopName;
        
        if ($stop->save()) 
        {
            Session::flash('success', 'Stop has been added');
        }
        else
        {
            Session::flash('error', 'Failed to add stop');
        }
      
        return redirect()->route('addStop');
    }
    
    /*
     * Delete stop
     * Only allowed if stop is not in an active route's leg
     */
    public function deleteStop(Request $request)
    {
        // Check if a stop has been selected for deletion
        if ($request->filled('selectedStopId'))
        {
            $selectedStopId = $request->selectedStopId;
            // Check to see if stop is in any route legs
            $stop = Stop::find($selectedStopId);
            $isAssigned = $stop->isAssigned();
            
            if (!$isAssigned)
            {
                $stop->delete();
                Session::flash('success', 'The selected vehicle has been deleted');
            }
            else
            {
                Session::flash('error', 'Cannot delete stop since it is currently '
                        . 'assigned to a route leg');
            }
            
        }
        else
        {
            Session::flash('error', 
                    'You must select a stop for deletion');
        }
        
        return redirect()->route('viewStops');
    }
    
    /*
     * Display the table of transit stops
     */
    public function showStops(Request $request)
    {
         if ($request->session()->has('loggedUser'))
        {
            // Get the user
            $employee = $request->session()->get('loggedUser');
            // Only return view if user is admin
            if ($employee->employeeType == "admin")
            {
                $stops = Stop::all();
                return view('viewStops', ['stops' => $stops]);
            }         
        }
        
        return redirect()->route('public');
    }
    
}
