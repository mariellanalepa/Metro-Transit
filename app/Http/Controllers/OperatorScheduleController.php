<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Employee;
use App\Route;
use App\Schedule;
use App\Operator;
use App\Run;
use App\Vehicle;

class OperatorScheduleController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->session()->has('loggedUser'))
        {
           if ($request->session()->get('loggedUser')->employeeType == "operator")
           {
               $employee = $request->session()->get('loggedUser');
           
               $schedules = $employee->getSchedule();
               
               return view('operatorSchedule', ['schedules'=>$schedules]); 
           }       
        }
                  
        return redirect()->route('public');
    }
    
   
}
