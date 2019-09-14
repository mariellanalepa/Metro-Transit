<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Run;

class Schedule extends Model
{
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'schedules';
    
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
    
    /*
     * Determine which route this schedule is for
     */
    public function getRoute() 
    {
        $routeNumber = Run::find($this->runId)->routeNumber;
        return $routeNumber;
    }
    
    /*
     * Return the start time of this Schedule instance
     */
    public function getStartTimeString()
    {
        $startTime = Run::find($this->runId)->getStartTimeString();
        return $startTime;
    }
    
    /*
     * Return the end time of this Schedule instance
     */
    public function getEndTimeString()
    {
        $startTime = Run::find($this->runId)->getEndTimeString();
        return $startTime;
    }
    
    /*
     * Function to get run number (vs run id) of schedule
     */
    public function getRun()
    {
        return Run::find($this->runId)->runNumber;
    }
            
}
