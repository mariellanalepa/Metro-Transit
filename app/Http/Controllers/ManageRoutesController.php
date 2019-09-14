<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Employee;
use App\Route;
use App\Schedule;
use App\Operator;
use App\Run;
use App\Stop;
use App\Vehicle;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ManageRoutesController extends Controller
{
    
    public function index()
    {
         if ($request->session()->has('loggedUser'))
        {
            // Get the user
            $employee = $request->session()->get('loggedUser');
            // Only return view if user is admin
            if ($employee->employeeType == "admin")
                return view('viewRoutes');
        }
        
        return redirect()->route('public');
    }
    
}
