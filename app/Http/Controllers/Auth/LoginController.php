<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Session;
use Illuminate\Http\Request;
use App\Employee;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm(Request $request)
    {
        if ($request->session()->has('loggedUser'))
        {
            return redirect()->route('home');
        }
        return view('auth.login');
    }
    
    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function login(Request $request)
    {
        //Get the first user that has this userName (unique, so only one)
        $employee = Employee::where('userName', '=', $request->userName);
        
        if ($employee->exists()) {
            // user found
            $employee = $employee->first();
            //Check if the entered password is same as the stored hash
            $hashCheck = Hash::check($request->password, $employee->password);
            if ($hashCheck)
            {
                $request->session()->put('loggedUser', $employee);
                return redirect()->route('home');
            }
            
        }
        Session::flash('error', 'You have entered an invalid username or '
                                    . 'password');
        return redirect()->route('login');
    }
    
    /**
     * Handle a logout request.
     * 
     * @param Request $request
     */
    public function logout(Request $request)
    {
        // Remove all session data
        $request->session()->flush();
        
        // Redirect user to public landing page
        return redirect()->route('public');
    }
}
