<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\User;
use App\Employee;
use Redirect;
use Response;
use Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountSettingsController extends Controller
{

     public function index(Request $request)
    {
         if (!$request->session()->has('loggedUser'))
             return redirect()->route('public');
             
        $employee = $request->session()->get('loggedUser');
        
        if ($employee->employeeType == "admin")
        {
            return view('adminAccountSettings', ['employee' => $employee]);
        }
        else if ($employee->employeeType == "operator")
         {
            return view('operatorAccountSettings', ['employee' => $employee]);
        }
        
    }
    
    public function updateInfo(Request $request)
    {         
        $employee = $request->session()->get('loggedUser');
        
        $hashCheck = Hash::check($request->oldPassword, $employee->password);
        
        if (!$hashCheck)
        {
            // Old password was incorrect
            Session::flash('error', 'Failed to update account settings ;).');
            // Logout user for security
            return redirect()->route('accountSettings');
        }
                
        
        $validator = Validator::make(['userName' => $request->userName,
                'password' => $request->newPassword], 
                Employee::EditAccountSettingsRules(),
                Employee::$editAccountSettingsMessages);

        if ($validator->fails()) {
            return redirect()->route('accountSettings')
                ->withInput()
                ->withErrors($validator);
        }
        

        $employee = $request->session()->get('loggedUser');
        $employee->userName = $request->userName;
        $employee->password = Hash::make($request->newPassword);
        
        if ($employee->save()) 
        {
            Session::flash('success', 'Your settings have been updated.');
        }
        else
        {
            Session::flash('error', 'Failed to update account settings.');
        }

        
        
        return redirect()->route('accountSettings');
    }
    
}
