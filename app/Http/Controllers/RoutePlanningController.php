<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Employee;
use App\Vehicle;
use App\Bus;
use App\Train;
use App\Carriage;
use App\Stop;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class RoutePlanningController extends Controller
{

     public function index(Request $request)
    {
        if ($request->session()->has('loggedUser'))
        {
            // Get the user
            $employee = $request->session()->get('loggedUser');
            // Only return view if user is admin
            if ($employee->employeeType == "admin")
                return view('routePlanning');
        }
        
        return redirect()->route('public');
    }
    
    /*
     * Display the table of fleet vehicles
     */
    public function showFleet(Request $request)
    {
         if ($request->session()->has('loggedUser'))
        {
            // Get the user
            $employee = $request->session()->get('loggedUser');
            // Only return view if user is admin
            if ($employee->employeeType == "admin")
            {
                $vehicles = Vehicle::allActive();
                return view('viewFleet', ['vehicles' => $vehicles]);
            }         
        }
        
        return redirect()->route('public');
    }
    
    
    /*
     * To access add vehicle menu
     */
    public function manageFleet(Request $request)
    {
         if ($request->session()->has('loggedUser'))
        {
            // Get the user
            $employee = $request->session()->get('loggedUser');
            // Only return view if user is admin
            if ($employee->employeeType == "admin")
            {
               return view('manageFleet');
            }         
        }
        
        return redirect()->route('public');
    }
    
     /*
     * To access carriage assignment
     */
    public function chooseTrain(Request $request)
    {
         if ($request->session()->has('loggedUser'))
        {
            // Get the user
            $employee = $request->session()->get('loggedUser');
            // Only return view if user is admin
            if ($employee->employeeType == "admin")
            {
               $trains = Train::all();
               return view('chooseTrain', ['trains' => $trains]);
            }         
        }
        
        return redirect()->route('public');
    }
    
    public function getCarriageAssignments(Request $request)
    {
        $train = Train::find($request->trainId);
        $request->session()->put('trainForAssignment', $train);
        
        return redirect()->route('viewCarriageAssignments');
    }
    
    /*
     * To access add carriage form
     */
    public function addCarriage(Request $request)
    {
         if ($request->session()->has('loggedUser'))
        {
            // Get the user
            $employee = $request->session()->get('loggedUser');
            // Only return view if user is admin
            if ($employee->employeeType == "admin")
            {
               return view('addCarriage');
            }         
        }
        
        return redirect()->route('public');
    }
    
    /*
     * To access add train form
     */
    public function addTrain(Request $request)
    {
         if ($request->session()->has('loggedUser'))
        {
            // Get the user
            $employee = $request->session()->get('loggedUser');
            // Only return view if user is admin
            if ($employee->employeeType == "admin")
            {
               // Provide list of unassigned carriages
               $carriages = Carriage::getUnassignedCarriages();
                
               return view('addTrain', ['carriages' => $carriages]);
            }         
        }
        
        return redirect()->route('public');
    }
    
    /*
     * To access add bus form
     */
    public function addBus(Request $request)
    {
         if ($request->session()->has('loggedUser'))
        {
            // Get the user
            $employee = $request->session()->get('loggedUser');
            // Only return view if user is admin
            if ($employee->employeeType == "admin")
            {
               return view('addBus');
            }         
        }
        
        return redirect()->route('public');
    }
    
    
    /*
     * To confirm add bus form data
     */
     public function confirmBus(Request $request)
    {
         $validator = Validator::make($request->all(), 
                Bus::AddBusRules());
        

        if ($validator->fails()) {
            return redirect()->route('addBus')
                ->withInput()
                ->withErrors($validator);
        }

        // First create the vehicle instance
        $vehicle = new Vehicle();
        $vehicle->vehicleId = $request->vehicleId;
        $vehicle->vehicleType = "bus";
        if (!$vehicle->save())
        {
            Session::flash('error', 'Failed to add bus');
            return redirect()->route('addBus');
        }
        
        // Now can create bus instance
        $bus = new Bus();
        $bus->vehicleId = $request->vehicleId;
        $bus->capacity = $request->capacity;
        
        if ($bus->save()) 
        {
            Session::flash('success', 'Bus has been added to fleet');
        }
        else
        {
            Session::flash('error', 'Failed to add bus');
        }
      
        return redirect()->route('addBus');
    }
    
    
    /*
     * To confirm add train form data
     */
     public function confirmTrain(Request $request)
    { 
         $validator = Validator::make(['vehicleId' => $request->vehicleId], 
                ['vehicleId' => 'required|unique:vehicles|numeric|digits:4']);
        

        if ($validator->fails()) {
            return redirect()->route('addTrain')
                ->withInput()
                ->withErrors($validator);
        }

        // First create the vehicle instance
        $vehicle = new Vehicle();
        $vehicle->vehicleId = $request->vehicleId;
        $vehicle->vehicleType = "train";
        if (!$vehicle->save())
        {
            Session::flash('error', 'Failed to add train');
            return redirect()->route('addTrain');
        }
        
        // Now can create train instance
        $train = new Train();
        $train->vehicleId = $request->vehicleId;
        
        if (!$train->save()) 
        {
            Session::flash('error', 'Failed to add train');
            return redirect()->route('addTrain');
        }
         
        // Check if carriages have been added to train at time of creation
        // If so, make the assignment of these carriages to the train
        if ($request->filled('carriageIds'))
        {
            foreach ($request->carriageIds as $carriageId)
            {
                $carriage = Carriage::find($carriageId);
                $carriage->trainId = $request->vehicleId;
                $carriage->save();
            }
                
        }
        
        Session::flash('success', 'Added train to fleet');
        return redirect()->route('addTrain');
    }
    
    
    /*
     * To confirm add carriage form data
     */
     public function confirmCarriage(Request $request)
    {
         $validator = Validator::make($request->all(), 
                Carriage::AddCarriageRules());
        

        if ($validator->fails()) {
            return redirect()->route('addCarriage')
                ->withInput()
                ->withErrors($validator);
        }
 
        // Create carriage instance
        $carriage = new Carriage();
        $carriage->carriageId = $request->carriageId;
        $carriage->capacity = $request->capacity;
        
        if ($carriage->save()) 
        {
            Session::flash('success', 'Carriage has been added to fleet');
        }
        else
        {
            Session::flash('error', 'Failed to add carriage');
        }
      
        return redirect()->route('addCarriage');
    }
    
    
    /*
     * Soft delete of Vehicle (sets status to 'inactive')
     */
    public function deleteVehicle(Request $request)
    {
        // Check if a vehicle has been selected for deletion
        if ($request->filled('selectedVehicleId'))
        {
            $selectedVehicleId = $request->selectedVehicleId;
            // Set status to inactive
            $vehicle = Vehicle::find($selectedVehicleId);
            $vehicle->status = "inactive";
            $vehicle->save();
            Session::flash('success', 'The selected vehicle has been deleted');
        }
        else
        {
            Session::flash('error', 
                    'You must select a vehicle for deletion');
        }
        
        return redirect()->route('viewFleet');
    }
    
    
    
}
