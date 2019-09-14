<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\EmployeePhoneNumber;

//class User extends Authenticatable
class Employee extends Authenticatable
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'employees';
    
    /**
     * The primary key of the table.
     * 
     * @var int
     */
    protected $primaryKey = 'employeeId';
    
    /**
     *Do not require time stamps for table row
     * 
     * @var boolean
     */
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     * The attributes that can be instantiated in one go, 
     * upon initialization of a User
     * 
     * @var array
     */
    protected $fillable = [
        'firstName', 'lastName', 'userName', 'password',
    ];
    

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    /*protected $hidden = [
        'password', 'remember_token',
    ];
     */

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    /*protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    */
    
    /**
     * Function to return formatted string of phone number
     * @return string
     */
    public function getPhoneNumber()
    {
        
        $substr1 = substr($this->phoneNumber, 0, 3);
        $substr2 = substr($this->phoneNumber, 3, 4);
        return sprintf("%s-%s", $substr1, $substr2);
    }
    
    /**
     * Function to store phone number stripped of formatting
     * @var string 
     */
    public function setPhoneNumber($phoneStr)
    {
        // Take out the dash in the formatted string
        $phoneStr = str_replace('-','',$phoneStr);
        
        $this->phoneNumber = $phoneStr;
    }
    
    
    public function getEmergencyContacts()
    {
        //$contacts = EmergencyContact::all();
        $contacts = EmergencyContact::where('employeeId', $this->employeeId)->get();
        return $contacts;
    }
    
    /**
     * Function which returns an array describing the rules
     * for editing an Employee
     */
    public static function EditPersonalInfoRules()
    {
        $rules = array(
                        'firstName'=>'required|max:50',
                        'lastName'=>'required|max:50',
                        'streetNumber' => 'required|numeric|max:9999',
                        'streetName' => 'required|max:50',
                        'city' => 'required|max:50',
                        'state' => 'required|max:50',
                        'postcode' => 'required|numeric|digits:5',
                        'phoneNumber'=>'required|alpha_dash|size:8',
                        );
        return $rules;
    }
    
    public static function AddEmployeeRules()
    {
        $rules = array(
                        'employeeId' => 'required|unique:employees|numeric|digits:8',
                        'sin' => 'required|unique:employees|numeric|digits:9',
                        'employeeType' => 'required|in:admin,operator,dataAnalyst',
                        'firstName'=>'required|max:50',
                        'lastName'=>'required|max:50',
                        'streetNumber' => 'required|numeric|max:9999',
                        'streetName' => 'required|max:50',
                        'city' => 'required|max:50',
                        'state' => 'required|max:50',
                        'postcode' => 'required|numeric|digits:5',
                        'phoneNumber'=>'required|alpha_dash|size:8',
                        'userName' => 'required|max:50',
                        'password' => 'required|max:255'
            
                        );
        return $rules;
    }
    
    
    /**
     * Function which returns an array describing the rules
     * for editing an Employee
     */
    public static function EditAccountSettingsRules()
    {
        $rules = array(
                        'userName'=>'required|max:50',
                        'password'=>'required|max:255'
                        );
        return $rules;
    }
    
    
    /*
     * Messages related to validation
     */
    public static $editPersonalInfoMessages=array(
      'firstName.required' => 'Please enter first name.',       
      'firstName.max:50' => 'First name exceeds character allowance.', 
      'lastName.required' => 'Please enter last name.',   
      'lastName.max:50' => 'Last name exceeds character allowance.', 
      'phoneNumber.required' => 'Please enter phone number.',
      'phoneNumber.alpha_dash' => 'Phone number format is invalid.',
      'phoneNumber.size' => 'Phone number should only contain 7 digits.',
      'streetNumber.required' => 'Please enter street number.',
      'streetNumber.numeric' => 'Street number can only contain digits',
      'streetNumber.max:9999' => 'Street number exceeds digit allowance.',
      'streetName.required' => 'Please enter street name.',
      'streetName.max50' => 'Street name exceeds character allowance.',
      'city.required' => 'Please enter city.',     
      'city.max:50' => 'City exceeds character allowance.',
      'state.required' => 'Please enter state.',     
      'state.max:50' => 'State exceeds character allowance.',
      'postcode.required' => 'Please enter postal code.',
      'postcode.numeric' => 'Postal code should contain numbers only.',
      'postcode.digits:5' => 'Postal code must only have 5 digits.'
    );
    
    /*
     * Messages related to validation
     */
    public static $editAccountSettingsMessages=array(
      'userName.required' => 'Please enter a user name.',       
      'userName.max:50' => 'User name exceeds character allowance.', 
      'password.required' => 'Please enter a password.',       
      'password.max:255' => 'Password exceeds character allowance.', 
    );
    
    
    /**
     * Get schedules to which this employee (operator) has been assigned
     * @return collection of Schedules
     */
    public function getSchedule() 
    {
        $schedules = Schedule::where('operatorId', $this->employeeId)->get();
        return $schedules;
    }
}
