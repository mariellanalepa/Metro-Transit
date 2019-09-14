<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use Redirect;
use Response;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class PersonalInfoController extends Controller
{

     public function index(Request $request)
    {
        if (!$request->session()->has('loggedUser'))
             return redirect()->route('public'); 
         
        $employee = $request->session()->get('loggedUser');
        
        if ($employee->employeeType == "admin")
        {
            return view('adminPersonalInfo', ['employee' => $employee]);
        }
        else if ($employee->employeeType == "operator")
        {
            return view('operatorPersonalInfo', ['employee' => $employee]);
        }
    }
    
    public function updateInfo(Request $request)
    {
        /*$data = $request->all();
        dd($data);
        */
        
        /*
        $validator = Validator::make($request->all(), Employee::EditRules(),
                Employee::$messages);
         * 
         */
        $validator = Validator::make($request->all(), 
                Employee::EditPersonalInfoRules(),
                Employee::$editPersonalInfoMessages);

        if ($validator->fails()) {
            return redirect()->route('personalInfo')
                ->withInput()
                ->withErrors($validator);
        }

        $employee = $request->session()->get('loggedUser');
        $employee->firstName = $request->firstName;
        $employee->lastName = $request->lastName;
        $employee->streetNumber = $request->streetNumber;
        $employee->streetName = $request->streetName;
        $employee->city = $request->city;
        $employee->state = $request->state;
        $employee->postcode = $request->postcode;
        $employee->setPhoneNumber($request->phoneNumber);
        
        if ($employee->save()) 
        {
            Session::flash('success', 'Your information has been updated');
        }
        else
        {
            Session::flash('error', 'Failed to update personal info');
        }

        
        
        return redirect()->route('personalInfo');
    }
    
}
