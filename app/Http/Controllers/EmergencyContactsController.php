<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\User;
use App\Employee;
use App\EmergencyContact;
use Auth;
use Redirect;
use Response;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class EmergencyContactsController extends Controller
{
    /**
     * Function to display the list of the user's emergency
     * contacts
     * @return array of type EmergencyContact
     */
     public function index(Request $request)
    {
        if (!$request->session()->has('loggedUser'))
             return redirect()->route('public');
        
        $employee = $request->session()->get('loggedUser');
        $contacts = $employee->getEmergencyContacts();
        
        $request->session()->reflash();
        
        if ($employee->employeeType == "admin")
        {
            return view('adminEmergencyContacts', ['employee' => $employee, 
            'contacts' => $contacts]);
        }
        else if ($employee->employeeType == "operator")
        {
            return view('operatorEmergencyContacts', ['employee' => $employee, 
            'contacts' => $contacts]);
        }
        
    }
    
    public function addContact(Request $request)
    {
        
        $validator = Validator::make($request->all(), EmergencyContact::Rules(),
                EmergencyContact::$messages);

        if ($validator->fails()) {
            return redirect()->route('emergencyContacts')
                ->withInput()
                ->withErrors($validator);
        }
        
        $contact = new EmergencyContact();
        // Work around for session finicky-ness
        $employee = Employee::find($request->employeeId);
        $contact->employeeId = $employee->employeeId;
        $contact->firstName = $request->firstName;
        $contact->lastName = $request->lastName;
        $contact->setPhoneNumber($request->phoneNumber);
        
        if ($contact->save()) 
        {
            Session::flash('success', 'Contact has been added');
        }
        else
        {
            Session::flash('error', 'Failed to add contact');
        }

        return redirect()->route('emergencyContacts');
    }
    
    public function deleteContact($id)
    {
        EmergencyContact::where('id', $id)->first()->delete();
        
        return redirect()->route('emergencyContacts');
    }
    
}
