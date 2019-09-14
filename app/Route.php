<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateInterval;

class Route extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'routes';
    
    /**
     * The primary key of the table.
     * 
     * @var int
     */
    protected $primaryKey = 'routeNumber';
    
    /**
     *Do not require time stamps for table row
     * 
     * @var boolean
     */
    public $timestamps = false;
    
    /**
     * Get runs associated with this Route
     */
    public function getRuns()
    {
        $runs = Run::where('routeNumber', $this->routeNumber)->get();
        return $runs;
    }
    
    /**
     * Get unscheduled runs for this Route
     */
    public function getUnscheduledRuns($date)
    {
        $scheduledRuns = Schedule::select('runId')
                            ->whereDate('date', $date)
                            ->get();
        
        $runs = Run::where('routeNumber', $this->routeNumber)
                ->whereNotIn('id', $scheduledRuns)
                ->get();
        return $runs;
    }
    
    /**
     * Get total run time for this Route
     */
    public function getTotalRunTimeString()
    {
        $count = RouteLeg::where('routeNumber', $this->routeNumber)->count();
       
        $lastLeg = RouteLeg::where('routeNumber', $this->routeNumber)
                    ->where('legNumber', $count)->first();
                     

        return $lastLeg->endRelativeArrivalTime;
        
    }
    
    /**
     * Get total run time for this Route
     * 
     * @return DateTime
     */
    public function getTotalRunTime()
    {
        $totalTime = DateTime::createFromFormat('H:i:s', 
                $this->getTotalRunTimeString());
        
        return $totalTime; 
    }
    
    /**
     * Get all run start times associated with a route
     * @param int $routeNumber
     * @return array of times (type string)
     */
    public function getAllRunStartTimes()
    {
        $runStartTimes = DB::table('runs')
                    ->select('runs.startTime')
                    ->where('runs.routeNumber', '=', $this->routeNumber)
                    ->get();
        
        return $runStartTimes;
    }
    
    /**
     * Get route schedule -- all stops, all times
     * @return $routeArrivalTimes = [0 => {"stopName": name, "arrivalTime": 00:38:00}]
     */
    public function getSchedule($startTime, $endTime)
    {
        // Convert argument time strings to DateTime objects
        $startTime = DateTime::createFromFormat('H:i:s', 
                $startTime);
        
        $endTime = DateTime::createFromFormat('H:i:s', 
                $endTime);
        
        // Get the array of stops are relative arrival time at each
        $stopTimes = $this->getStopRelativeArrivalTimes();
        
        // Determine how many stops are along this route
        $numStops = count($stopTimes);
        
        // Create array to store all arrival times by stop
        $stopArrivalTimes = array();
        
        $i = 0;
        
        foreach ($stopTimes as $stopTime)
        {
            $stopName = Stop::find($stopTime->stopId)->stopName;
            
            // This stop will be stopped at multiple times through the day,
            // once for each run of the route
            // get the runs to determine exact arrival times
            $runs = $this->getRuns();

            // Make array for each stop
            $arrivalTimes = array();
            // Convert relative arrival time to DateTime
            $relativeArrivalTime = DateTime::createFromFormat('H:i:s', 
                $stopTime->relativeArrivalTime);
            // In order to obtain time interval for adding
            $baseTime = new DateTime('00:00:00');
            $timeDiff = $baseTime->diff($relativeArrivalTime);
            
            for($j = 0; $j < $this->runsPerDay; $j++)
            {
                $arrivalTime = $runs[$j]->getStartTime()->add($timeDiff);
                // Only add stop time to array if between input times
                if (($startTime <= $arrivalTime) && ($arrivalTime <= $endTime))
                    // Need to now convert this time back to a string
                    $arrivalTimes[$j] = $arrivalTime->format('g:i:s A');
            }
               
            // Put that entire array in the routeArrivalTimes array,
            // indexed by routeNumber
            $stopArrivalTimes[$stopName] = $arrivalTimes;
        }
        
        //dd($stopArrivalTimes);
              
        return $stopArrivalTimes;
        
    }
    
    /**
     * Helper function to get all stops that are on this route, and the relative
     * arrival time at each stop (in relation to the start of a route run)
     */
    function getStopRelativeArrivalTimes()
    {
        $startStopRelativeArrivalTimes = DB::table('routeLegs')
                                     ->select('startStopId as stopId', 
                                             'startRelativeArrivalTime as relativeArrivalTime')
                                     ->where('routeNumber', '=', $this->routeNumber)
                                     ->get();
        
        $endStopRelativeArrivalTimes = DB::table('routeLegs')
                                     ->select('endStopId as stopId', 
                                             'endRelativeArrivalTime as relativeArrivalTime')
                                     ->where('routeNumber', '=', $this->routeNumber)
                                     ->get();
        
        // Merge the two collections and only retain the unique values
        $stopRelativeArrivalTimes = $startStopRelativeArrivalTimes
                                        ->merge($endStopRelativeArrivalTimes)->unique();
        
        
        return $stopRelativeArrivalTimes;
        
    }
}
