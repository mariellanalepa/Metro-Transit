<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carriage extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'carriages';
    
    /**
     * The primary key of the table.
     * 
     * @var int
     */
    protected $primaryKey = 'carriageId';
    
    /**
     *Do not require time stamps for table row
     * 
     * @var boolean
     */
    public $timestamps = false;
    
    /*
     * Return list of carriages that have not been assigned to a train
     */
    public static function getUnassignedCarriages()
    {
        return Carriage::whereNull('trainId')->get();
    }
    
    /*
     * Rules for validator to add carriage
     */
    public static function addCarriageRules()
    {
        $rules = array(
                        'carriageId' => 'required|unique:carriages|numeric|digits:4',
                        'capacity' => 'required|numeric|digits:2'
                        );
        return $rules;
    }
}
