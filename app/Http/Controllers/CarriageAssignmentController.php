<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\User;
use App\Employee;
use App\Carriage;
use App\Train;
use Auth;
use Redirect;
use Response;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CarriageAssignmentController extends Controller
{
    /**
     * Function to display the list of the train's carriages
     * @return array of type Carriage
     */
     public function index(Request $request)
    {
        if ($request->session()->has('loggedUser'))
        {
            // Determine if logged user is admin
            $employee = $request->session()->get('loggedUser');
            if ($employee->employeeType == "admin")
            {
                $train = $request->session()->get('trainForAssignment');
               // Get all current carriage assignments
               $carriages = $train->getCarriages();
               // Get free carriages
               $freeCarriages = Carriage::getUnassignedCarriages();
               return view('viewCarriageAssignments', ['train' => $train,
                   'carriages' => $carriages, 'freeCarriages' => $freeCarriages]);
            }
        }
             
      return redirect()->route('public');
        
        
    }
   
    /*
     * Make carriage assignment to train
     */
    public function assignCarriage(Request $request)
    {
        $carriage = Carriage::find($request->carriageId);
        $train = $request->session()->get('trainForAssignment');
        $carriage->trainId = $train->vehicleId;
        
        if ($carriage->save()) 
        {
            Session::flash('success', 'Carriage assignment has been made');
        }
        else
        {
            Session::flash('error', 'Failed to assign carriage');
        }

        return redirect()->route('viewCarriageAssignments');
    }
    
    
}
