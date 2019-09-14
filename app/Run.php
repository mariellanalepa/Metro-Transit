<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Run extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'runs';
    
    /**
     * The primary key of the table.
     * 
     * @var int
     */
    protected $primaryKey = 'id';
    
    /**
     *Do not require time stamps for table row
     * 
     * @var boolean
     */
    public $timestamps = false;
    
    
    /**
     * Get run start time
     * 
     * @return DateTime
     */
    public function getStartTime()
    {
        // first find associated route
        $route = Route::find($this->routeNumber);
        // Get route's start time
        $serviceStartTimeString = $route->serviceStartTime;
        $serviceStartTime = DateTime::createFromFormat('H:i:s', 
                $serviceStartTimeString);
        
        $totalTime = $route->getTotalRunTime();
        
        // In order to obtain time interval for adding
        $baseTime = new DateTime('00:00:00');
        $totalTimeInterval = $baseTime->diff($totalTime);
        
        //Calculate start time given run number of the day
        $startTime = $serviceStartTime;
        
        for ($i = 0; $i < ($this->runNumber - 1); $i++)
        {
            $startTime->add($totalTimeInterval);
        }
        
        return $startTime;
    }
    
    /**
     * Get run start time
     * 
     * @return string -- formatted string representing Time
     */
    public function getStartTimeString()
    {
        return $this->getStartTime()->format('H:i:s');
    }
    
    /**
     * Get run end time
     * 
     * * @return DateTime
     */
    public function getEndTime()
    {
        // first find associated route
        $route = Route::find($this->routeNumber);
        // Get route's start time
        $serviceStartTimeString = $route->serviceStartTime;
        $serviceStartTime = DateTime::createFromFormat('H:i:s', 
                $serviceStartTimeString);
        
        $totalTime = $route->getTotalRunTime();
        
        // In order to obtain time interval for adding
        $baseTime = new DateTime('00:00:00');
        $totalTimeInterval = $baseTime->diff($totalTime);
        
        $endTime = $this->getStartTime()->add($totalTimeInterval);
        
        return $endTime;
    }
    
    /**
     * Get run end time
     * 
     * * @return string -- formatted string representing Time
     */
    public function getEndTimeString()
    {  
        return $this->getEndTime()->format('H:i:s');
    }
    
    
    
}
