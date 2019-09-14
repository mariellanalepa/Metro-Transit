<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// Database support for raw queries
use Illuminate\Support\Facades\DB;
use App\Schedule;

class Operator extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'operators';
    
    /**
     * The primary key of the table.
     * 
     * @var int
     */
    protected $primaryKey = 'employeeId';
    
    /**
     *Do not require time stamps for table row
     * 
     * @var boolean
     */
    public $timestamps = false;
    
    /*
     * Returns first name of employee
     */
    public function getFirstName()
    {
        return Employee::find($this->employeeId)->firstName;
    }
    
    /*
     * Returns first name of employee
     */
    public function getLastName()
    {
        return Employee::find($this->employeeId)->lastName;
    }
    
    /**
     * Check to see which operators are not scheduled
     * during the runtime period
     * @param DateTime $runtime
     */
    public static function getUnscheduledOperators($selectedRun, $selectedDate)
    {
        // Get the selected runs start and end times
        $startTime = $selectedRun->getStartTimeString();
        $endTime = $selectedRun->getEndTimeString();
             
        // First find which operators are scheduled during this time 
        $scheduledOperators = DB::table('operators')
                                ->join('schedules', 'operators.employeeId', '=', 'schedules.operatorId')
                                ->join('runs', 'schedules.runId', '=', 'runs.id')
                                ->select('operators.employeeId')
                                ->whereDate('schedules.date', '=', $selectedDate)
                                ->whereTime('runs.startTime', '<=', $endTime)
                                ->whereTime('runs.endTime', '>=', $startTime)
                                ->get();
                        
        // Get ids of scheduled operators
        $id = array();
        $i = 0;
        foreach ($scheduledOperators as $scheduledOperator)
        {   
            $id[$i] = $scheduledOperator->employeeId;
            $i = $i + 1;
        }
        
        // Find all unscheduled operators
        // Must use Operator class to retrieve Operator objects
        $unscheduledOperators = Operator::whereNotIn('employeeId', $id)->get();
         
        return $unscheduledOperators;
    }
    
    
}
