<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;


class HomeController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (!$request->session()->has('loggedUser'))
             return redirect()->route('public');
        
        // Retrieve the user from session data
        $user = $request->session()->get('loggedUser');
        // Determine the employee type
        $employeeType = $user->employeeType;
        
        if ($employeeType == "admin")
        {
            return view('adminHome', ['firstName' => $user->firstName, 
                                    'lastName' => $user->lastName]);
        }
        else if ($employeeType == "operator")
        {
            return view('operatorHome', ['firstName' => $user->firstName, 
                                    'lastName' => $user->lastName]);
        }
            
    }
}
