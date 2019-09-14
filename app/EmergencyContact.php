<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EmergencyPhoneNumber;

class EmergencyContact extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'emergencyContacts';
    
    /*
     * By default Eloquent expects created_at and updated_at
     * columns to exist in tables. To override:
     */
    public $timestamps = false;
    
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
    
    /**
     * Function which returns an array describing the rules
     * for creating an EmergencyContact
     */
    public static function Rules()
    {
        $rules = array('firstName'=>'required|alpha|max:50',
                        'lastName'=>'required|alpha|max:50',
                        'phoneNumber'=>'required|alpha_dash|size:8');
        return $rules;
    }
    
    /*
     * Messages related to validation
     */
    public static $messages=array(
      'firstName.required' => 'Please enter first name', 
      'firstName.alpha' => 'First name should contain alpha characters only', 
      'firstName.max:50' => 'First name exceeds character allowance', 
      'lastName.required' => 'Please enter last name',
      'lastName.alpha' => 'Last name should contain alpha characters only',
      'lastName.max:50' => 'Last name exceeds character allowance', 
      'phoneNumber.required' => 'Please enter phone number',
      'phoneNumber.alpha_dash' => 'Phone number format is invalid',
      'phoneNumber.size' => 'Phone number should only contain 7 digits' 
    );
    
}
