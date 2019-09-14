<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trains';
    
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
     * Determine capacity of train based on individual capacities of 
     * comprising carriages
     */
    public function getCapacity()
    {
        $capacity = 0;
        $carriages = $this->getCarriages();
        
        foreach ($carriages as $carriage)
        {
            $capacity = $capacity + $carriage->capacity;
        }
        
        return $capacity;
    }
    
    /*
     * Find all carriages that are assigned to this train
     */
    public function getCarriages()
    {
        return Carriage::where('trainId', $this->vehicleId)->get();
    }
    
    /*
     * Method to retrieve all available trains on a given date and time
     * for scheduling purposes
     */
    public static function getAllAvailableTrains($schedule)
    {
        $runId = $schedule->runId;
        $run = Run::find($runId);
        $routeNumber = $run->routeNumber;
        $date = $schedule->date;
        $startTime = $run->getStartTimeString();
        $endTime = $run->getEndTimeString();
        
        // Now the complex query of finding available trains
        // First find which trains are scheduled during this time 
        $scheduledTrains = DB::table('trains')
                                ->join('schedules', 'trains.vehicleId', '=', 'schedules.vehicleId')
                                ->join('runs', 'schedules.runId', '=', 'runs.id')
                                ->select('trains.vehicleId')
                                ->whereDate('schedules.date', '=', $date)
                                ->whereTime('runs.startTime', '<=', $endTime)
                                ->whereTime('runs.endTime', '>=', $startTime)
                                ->get();
                        
        // Get ids of scheduled buses
        $id = array();
        $i = 0;
        foreach ($scheduledTrains as $scheduledTrain)
        {   
            $id[$i] = $scheduledTrain->vehicleId;
            $i = $i + 1;
        }
        
        // Find all unscheduled buses
        // Must use Bus class to retrieve Bus objects
        $unscheduledTrain = Train::whereNotIn('vehicleId', $id)->get();
                                
        return $unscheduledTrains;
    }
    
}
