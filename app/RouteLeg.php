<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RouteLeg extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'routeLegs';
    
    /**
     * The primary key of the table.
     * 
     * @var int
     */
    protected $primaryKey = 'id';
    
    /**
     *Do not require time stamps for table row
     * 
     * @var boolean
     */
    public $timestamps = false;
}
