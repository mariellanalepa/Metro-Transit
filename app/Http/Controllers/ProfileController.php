<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\User;
use App\Employee;
use Auth;

class ProfileController extends Controller
{

     public function index(Request $request)
    {
        if (!$request->session()->has('loggedUser'))
             return redirect()->route('public');
        
        $employee = $request->session()->get('loggedUser');
        
        if ($employee->employeeType == "admin")
            return view('adminProfile', ['employee' => $employee]);
        else if ($employee->employeeType == "operator")
            return view('operatorProfile', ['employee' => $employee]);
    }
    
}
