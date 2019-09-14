<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'buses';
    
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
    
    /*
     * Rules for validator to add bus
     */
    public static function addBusRules()
    {
        $rules = array(
                        'vehicleId' => 'required|unique:vehicles|numeric|digits:4',
                        'capacity' => 'required|numeric|digits:2'
                        );
        return $rules;
    }
    
    /*
     * Method to retrieve all available buses on a given date and time
     * for scheduling purposes
     */
    public static function getAllAvailableBuses($schedule)
    {
        $runId = $schedule->runId;
        $run = Run::find($runId);
        $routeNumber = $run->routeNumber;
        $date = $schedule->date;
        $startTime = $run->getStartTimeString();
        $endTime = $run->getEndTimeString();
        
        // Now the complex query of finding available buses
        // First find which buses are scheduled during this time 
        $scheduledBuses = DB::table('buses')
                                ->join('schedules', 'buses.vehicleId', '=', 'schedules.vehicleId')
                                ->join('runs', 'schedules.runId', '=', 'runs.id')
                                ->select('buses.vehicleId')
                                ->whereDate('schedules.date', '=', $date)
                                ->whereTime('runs.startTime', '<=', $endTime)
                                ->whereTime('runs.endTime', '>=', $startTime)
                                ->get();
                        
        // Get ids of scheduled buses
        $id = array();
        $i = 0;
        foreach ($scheduledBuses as $scheduledBus)
        {   
            $id[$i] = $scheduledBus->vehicleId;
            $i = $i + 1;
        }
        
        // Find all unscheduled buses
        // Must use Bus class to retrieve Bus objects
        $unscheduledBuses = Bus::whereNotIn('vehicleId', $id)->get();
                                
        return $unscheduledBuses;
    }
}
