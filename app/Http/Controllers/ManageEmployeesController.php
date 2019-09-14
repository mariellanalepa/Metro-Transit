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
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ManageEmployeesController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->session()->has('loggedUser'))
        {
           if ($request->session()->get('loggedUser')->employeeType == "admin")
           {
               $employees = Employee::all();
               return view('viewEmployees', ['employees'=>$employees]); 
           }       
        }
                  
        return redirect()->route('public');
    }
    
    public function addEmployee(Request $request)
    {
        if ($request->session()->has('loggedUser'))
        {
           if ($request->session()->get('loggedUser')->employeeType == "admin")
           {
               return view('addEmployee');
           }       
        }
                  
        return redirect()->route('public');
        
    }
    
    public function confirmEmployee(Request $request)
    {
        $validator = Validator::make($request->all(), 
                Employee::AddEmployeeRules());

        if ($validator->fails()) {
            return redirect()->route('addEmployee')
                ->withInput()
                ->withErrors($validator);
        }

        $employee = new Employee();
        $employee->employeeId = $request->employeeId;
        $employee->sin = $request->sin;
        $employee->employeeType = $request->employeeType;
        $employee->firstName = $request->firstName;
        $employee->lastName = $request->lastName;
        $employee->streetNumber = $request->streetNumber;
        $employee->streetName = $request->streetName;
        $employee->city = $request->city;
        $employee->state = $request->state;
        $employee->postcode = $request->postcode;
        $employee->setPhoneNumber($request->phoneNumber);
        $employee->userName = $request->userName;
        $employee->password = Hash::make($request->password);
        
        if ($employee->save()) 
        {
            Session::flash('success', 'Employee has been added');
        }
        else
        {
            Session::flash('error', 'Failed to add employee');
        }

        
        
        return redirect()->route('addEmployee');
    }
    
}
