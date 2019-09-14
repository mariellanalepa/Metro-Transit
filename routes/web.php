<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\EmergencyContact;
use App\Carriage;


/* PUBLICALLY AVAILABLE ********************************************************
*******************************************************************************/

/* Route for public landing page */
Route::get('/', 'PublicSchedulesController@index')->name('public');

/* Route for displaying route schedule*/
Route::post('/stopSchedule', 'PublicSchedulesController@getStopSchedule')
        ->name('stopSchedule');

/* Route for displaying route schedule*/
Route::post('/routeSchedule', 'PublicSchedulesController@getRouteSchedule')
        ->name('routeSchedule');

/* REGISTERED ONLY *************************************************************
 ******************************************************************************/

/* LOGIN **********************************************************************/

 Route::get('/auth/login', 'Auth\LoginController@showLoginForm')->name('login');
 
 Route::post('/auth/login', 'Auth\LoginController@login');
 
 Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Workaround because in Laravel 5.3+, uses post method for logout
//Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')
//->name('logout');

/* Route for home page of logged users (employees) */
Route::get('/home', 'HomeController@index')->name('home');

/* EMPLOYEE MANAGEMENT ********************************************************/

/* Route for viewing employee table */
Route::get('/viewEmployees', 'ManageEmployeesController@index')
        ->name('viewEmployees');

/* Route for accessing add an employee */
Route::get('/addEmployee', 'ManageEmployeesController@addEmployee')
        ->name('addEmployee');

/* POST route for adding an employee */
Route::post('/addEmployee', 'ManageEmployeesController@confirmEmployee');

/* ROUTE PLANNING *************************************************************/

/* Route for route planning */
Route::get('/routePlanning', 'RoutePlanningController@index')
        ->name('routePlanning');

/* Route for viewing fleet table */
Route::get('/viewFleet', 'RoutePlanningController@showFleet')
        ->name('viewFleet');

Route::get('/manageFleet', 'RoutePlanningController@manageFleet')
        ->name('manageFleet');

Route::get('/addCarriage', 'RoutePlanningController@addCarriage')
        ->name('addCarriage');

Route::get('/chooseTrain', 'RoutePlanningController@chooseTrain')
        ->name('chooseTrain');

Route::post('/chooseTrain', 'RoutePlanningController@getCarriageAssignments');

Route::get('/viewCarriageAssignments', 'CarriageAssignmentController@index')
        ->name('viewCarriageAssignments');


Route::delete('/carriageAssignments/{id}', function($id) {
        $carriage = Carriage::findOrFail($id);
        $carriage->trainId = null;
        $carriage->save();
        return redirect()->back()->withInput();
});

Route::post('/viewCarriageAssignments', 'CarriageAssignmentController@assignCarriage');


Route::post('/addCarriage', 'RoutePlanningController@confirmCarriage');

Route::get('/viewStops', 'ManageStopsController@showStops')
        ->name('viewStops');

Route::get('/addStop', 'ManageStopsController@addStop')
        ->name('addStop');

Route::post('/addStop', 'ManageStopsController@confirmStop');

Route::post('/deleteStop', 'ManageStopsController@deleteStop');

Route::get('/addTrain', 'RoutePlanningController@addTrain')
        ->name('addTrain');

Route::post('/addTrain', 'RoutePlanningController@confirmTrain');

Route::get('/addBus', 'RoutePlanningController@addBus')
        ->name('addBus');

Route::post('/addBus', 'RoutePlanningController@confirmBus');

Route::get('/addCarriage', 'RoutePlanningController@addCarriage')
        ->name('addCarriage');

Route::post('/deleteVehicle', 'RoutePlanningController@deleteVehicle')
        ->name('deleteVehicle');

/* SCHEDULING *****************************************************************/

/* Route for admin scheduling function */
Route::get('/scheduling', 'SchedulingController@index')
        ->name('scheduling');

/* Route for operator schedule view */
Route::get('/operatorSchedule', 'OperatorScheduleController@index')
        ->name('operatorSchedule');

/* Route for deleting a schedule instance */
Route::post('/deleteSchedule', 'SchedulingController@deleteSchedule');

/* Route for choosing a route to schedule */
Route::get('/scheduleRoute', 'SchedulingController@showRoutes')
        ->name('scheduleRoute');

/* Route for choosing an employee to schedule */
Route::post('/scheduleEmployee', 'SchedulingController@showEmployees')
        ->name('scheduleEmployee');


Route::post('/scheduleRun', 'SchedulingController@showRuns');

Route::post('/scheduleVehicle', 'SchedulingController@showVehicles');

Route::post('/confirmSchedule', 'SchedulingController@showConfirmSchedule');

Route::post('/scheduleConfirmed', 'SchedulingController@confirmSchedule');

/* PROFILE ********************************************************************/

/**
 * GET route for profile page
 */
Route::get('/profile', 'ProfileController@index')
        ->name('profile');

/**
 * GET route for personal info page
 */
Route::get('/personalInfo', 'PersonalInfoController@index')
        ->name('personalInfo');

/**
 * POST route for updating personal information
 */
Route::post('/personalInfo', 'PersonalInfoController@updateInfo');

/**
 * GET route for account settings page
 */
Route::get('/accountSettings', 'AccountSettingsController@index')
        ->name('accountSettings');

/**
 * POST route for updating account settings
 */
Route::post('/accountSettings', 'AccountSettingsController@updateInfo');

/**
 * GET route for emergency contacts page
 */
Route::get('/emergencyContacts', 'EmergencyContactsController@index')
        ->name('emergencyContacts');

/**
 * DELETE route for delete emergency contact
 */
Route::delete('/emergencyContacts/{id}', function($id) {
        EmergencyContact::findOrFail($id)->delete();
        
        return redirect()->route('emergencyContacts');
});

/**
 * POST route for add emergency contact
 */
Route::post('/emergencyContacts', 'EmergencyContactsController@addContact');





