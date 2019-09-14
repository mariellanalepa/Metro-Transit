<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Run;
use DateTime;

class Stop extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stops';
    
    /**
     * The primary key of the table.
     * 
     * @var int
     */
    protected $primaryKey = 'stopId';
    
    /**
     *Do not require time stamps for table row
     * 
     * @var boolean
     */
    public $timestamps = false;
    
    
    /**
     * Get stop schedule -- all routes, all stop times
     * @return associative array
     * e.g. $routeArrivalTimes = [0 => {"routeNumber": 1, "arrivalTime": 00:38:00}]
     */
    public function getSchedule($startTime, $endTime) {
        
         // Convert argument time strings to DateTime objects
        $startTime = DateTime::createFromFormat('H:i:s', 
                $startTime);
        
        $endTime = DateTime::createFromFormat('H:i:s', 
                $endTime);
        
        $routeTimes = $this->getRouteRelativeArrivalTimes();
        
        // Determine how many routes stop at the stop
        $numRoutes = count($routeTimes);
        // Create array to store all arrival times by route
        $routeArrivalTimes = array();
        
        for ($i = 0; $i < $numRoutes; $i++)
        {
            $routeNumber = $routeTimes[$i]->routeNumber;
            $route = Route::find($routeNumber);
            // runStartTimes should have length equal to number of runsPerDay
            // for that route
            $runs = $route->getRuns();
            // Make array for each route
            $arrivalTimes = array();
            // Convert relative arrival time to DateTime
            $relativeArrivalTime = DateTime::createFromFormat('H:i:s', 
                $routeTimes[$i]->relativeArrivalTime);
            // In order to obtain time interval for adding
            $baseTime = new DateTime('00:00:00');
            $timeDiff = $baseTime->diff($relativeArrivalTime);
            
            for($j = 0; $j < $route->runsPerDay; $j++)
            {
                $arrivalTime = $runs[$j]->getStartTime()->add($timeDiff);
                // Only add route time to array if between input times
                if (($startTime <= $arrivalTime) && ($arrivalTime <= $endTime))
                // Need to now convert this time back to a string
                $arrivalTimes[$j] = $arrivalTime->format('g:i:s A');
            }
            
            // Put that entire array in the routeArrivalTimes array,
            // indexed by routeNumber
            $routeArrivalTimes[$routeNumber] = $arrivalTimes;
        }
        
        //dd($routeArrivalTimes);
        
        return $routeArrivalTimes;
        
    }
    
    /**
     * Helper function to get the routes that stop at this stop, and the 
     * arrival time relative to the start of a route run
     * 
     * @return associative array 
     * e.g. [0 => {"routeNumber" : 1, "startRelativeArrivalTime": "00:38:00"}]
     */
    function getRouteRelativeArrivalTimes()
    {
        
        $routeStartStopTimes = DB::table('stops')
                            ->join('routeLegs', 'stops.stopId', '=', 'routeLegs.startStopId')
                            ->select('routeLegs.routeNumber', 'routeLegs.startRelativeArrivalTime as relativeArrivalTime')
                            ->where('stops.stopId', '=', $this->stopId)
                            ->get();
        
        $routeEndStopTimes = DB::table('stops')
                            ->join('routeLegs', 'stops.stopId', '=', 'routeLegs.endStopId')
                            ->select('routeLegs.routeNumber', 'routeLegs.endRelativeArrivalTime as relativeArrivalTime')
                            ->where('stops.stopId', '=', $this->stopId)
                            ->get();
       
        // Merge the two collections and only retain the unique values
        $routeTimes = $routeStartStopTimes->merge($routeEndStopTimes)->unique(); 
     
        
        
        return $routeTimes;
    }
    
    
    /*
     * Method to determine if stop is assigned to a route leg
     */
    public function isAssigned()
    {
        $routeLegs = DB::table('routeLegs')
                       ->where('routeLegs.startStopId', '=', $this->stopId)
                       ->orWhere('routeLegs.endStopId', '=', $this->stopId)
                       ->get();
                     
        return !$routeLegs->isEmpty();
        
    }
    
    /*
     * Rules for adding a new Stop
     */
    public static function addStopRules() 
    {
        $rules = array(
                        'stopId' => 'required|unique:stops|numeric|digits_between:1,4',
                        'stopName' => 'required'
                        );
        return $rules;
    }
   
    
}
