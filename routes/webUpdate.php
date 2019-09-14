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

use App\Task;
use Illuminate\Http\Request;

/*Route::get('/', function () {
    $tasks = Task::orderBy('created_at', 'asc')->get();

    return view('tasks', [
        'tasks' => $tasks
    ]);
});*/

/**
 * Routes for Admin scheduling
 */



Route::get('/', function () {
    return view('auth.login');
});

/**
 * Add A New Task
 */
/*Route::post('/task', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
    ]);

    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }

    $task = new Task;
    $task->name = $request->name;
    $task->save();

    return redirect('/');

});
*/



/**
 * GET route for Admin main page
 */
/*Route::get('/admin/schedules', function () {
    //Blade view returning using view helper
    return view('schedules');
})->name('schedules');*/

Route::get('/admin/schedules', 'SchedulingController@showEmployeeTable')
        ->name('schedules');

/**
 * GET route for profile page
 */
Route::get('/profile', 'ProfileController@index')
        ->name('profile');

/**
 * GET route for account settings page
 */
Route::get('/accountSettings', 'AccountSettingsController@index')
        ->name('accountSettings');

/**
 * GET route for personal info page
 */
Route::get('/personalInfo', 'PersonalInfoController@index')
        ->name('personalInfo');

/**
 * GET route for account settings page
 */
Route::get('/emergencyContacts', 'EmergencyContactsController@index')
        ->name('emergencyContacts');

//Authentication routes in
// vendor/laravel/framework/src/Illuminate/Routing/Router::auth()
Auth::routes();

// Workaround because in Laravel 5.3+, uses post method for logout
//Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::get('/home', 'HomeController@index')->name('home');

