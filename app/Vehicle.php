<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// Database support for raw queries
use Illuminate\Support\Facades\DB;

class Vehicle extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vehicles';
    
    /**
     * The primary key of the table.
     * 
     * @var int
     */
    protected $primaryKey = 'vehicleId';
    
    /**
     *Do not require time stamps for table row
     * 
     * @var boolean
     */
    public $timestamps = false;
    
    /**
     * Retrieve capacity based on vehicle type
     */
    public function getCapacity()
    {
        if ($this->vehicleType == "bus")
        {
            return Bus::find($this->vehicleId)->capacity;
        }
        else if ($this->vehicleType == "train")
        {
            return Train::find($this->vehicleId)->getCapacity();
        }
    }
    
    /**
     * Method to retrieve all available vehicles of a certain type on a 
     * given date and time
     * for scheduling purposes
     */
    public static function getAllAvailableVehiclesOfType($schedule)
    {
        $runId = $schedule->runId;
        $run = Run::find($runId);
        $routeNumber = $run->routeNumber;
        $vehicleType = Route::find($routeNumber)->vehicleType;
        $date = $schedule->date;
        $startTime = $run->getStartTimeString();
        $endTime = $run->getEndTimeString();
        
        // Now the complex query of finding available vehicles of that type
        // First find which operators are scheduled during this time 
        $scheduledVehicles = DB::table('vehicles')
                                ->join('schedules', 'vehicles.vehicleId', '=', 'schedules.vehicleId')
                                ->join('runs', 'schedules.runId', '=', 'runs.id')
                                ->select('vehicles.vehicleId')
                                ->where('vehicles.vehicleType', $vehicleType)
                                ->where('vehicles.status', "active")
                                ->whereDate('schedules.date', '=', $date)
                                ->whereTime('runs.startTime', '<=', $endTime)
                                ->whereTime('runs.endTime', '>=', $startTime)
                                ->get();
                        
        // Get ids of scheduled vehicles
        $id = array();
        $i = 0;
        foreach ($scheduledVehicles as $scheduledVehicle)
        {   
            $id[$i] = $scheduledVehicle->vehicleId;
            $i = $i + 1;
        }
        
        // Find all unscheduled operators
        // Must use Operator class to retrieve Operator objects
        $unscheduledVehicles = Vehicle::where('vehicleType', $vehicleType)
                                ->whereNotIn('vehicleId', $id)->get();
        
        
        return $unscheduledVehicles;
    }
    
    /**
     * Retrieve all active vehicles
     */
    public static function allActive()
    {
       return Vehicle::where('status', "active")->get(); 
    }
    
    public static function addVehicleRules()
    {
        $rules = array(
                        'vehicleId' => 'required|unique:vehicles|numeric|digits:4',
                        'vehicleType' => 'required|in:bus,train'
                        );
        return $rules;
    }
    
}
