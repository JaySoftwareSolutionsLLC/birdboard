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

Route::get('/', function () { // When there is an unnamed function referenced like this, it is called a Closure
    //return view('welcome');
    // Tested & verified (T&V) | return 'Hello, world!';
});

/* T&V Laravel Up & Running (LU&R) pg 27.
$router->get('/test-route', function ()
{
    return 'Pat to sponge...testing, testing, 1,2,3 testing....DO YOU READ?!?!';
});
*/
// // T&V LU&R pg 35 | Adding rate limiting (more common with APIs (auth:api) to limit accessing a certain route more than :x tries ,y minutes before allowing additional tries)Route::middleware('auth', 'throttle:1,1')->group(function () { 
    Route::group(['middleware' => 'auth'], function() {
        // Project routes
        // LU&R pg 29 | the ControllerName@methodName naming schema explanation
        // T&V LU&R pg 29
        /*
        Route::get('/projects/{project?}', function($project = '4') {
            if ($project != 4) {
                return "Project # $project";
            }
            return "There was no project passed so the function defaulted to 4";
        });
        */
        // T&V LU&R pg 48 | Route::resource('projects', 'ProjectsController');
        // LU&R pg 49 | Route::apiResource('projects', 'ProjectsController');
        Route::prefix('/projects')->group(function () { // T&V LU&R pg 36 | 
            Route::get('/', 'ProjectsController@index');//->middleware('auth');
            Route::get('/create', 'ProjectsController@create'); // Order of these may matter?
            Route::get('/{project}', 'ProjectsController@show')
                ->name('projects.show');
                //T&V LU&R pg 30 | ->where('project', '[0-1]');
                //->middleware('auth');
                //T&V LU&R pg 40 | ->middleware('signed');
            Route::patch('/{project}', 'ProjectsController@update');
            Route::post('/', 'ProjectsController@store');//->middleware('auth');
            // Task routes
            Route::post('/{project}/tasks', 'ProjectTasksController@store');
            Route::patch('/{project}/tasks/{task}', 'ProjectTasksController@update');
        });
        // T&V LU&R pg 44 | Laravel prepends App\Http\Controllers to controller name (2nd arg.)
        Route::get('/home', 'HomeController@index')->name('home');
    });
    /* NOT T|V LU&R pg 37
    Route::domain('{?$account}.{?$path}', function($account = 'BuffaloState', $path = 'sociphoria.com') {
        Route::get('/', function() {
            return "Welcome to the page for {$account}.";
        });
    });
    */

    // T&V LU&R pg 37 | Adding fallback route
    Route::fallback(function() {
        return "Howdy partner. What you're looking for doesn't exist.";
    });
// });
Auth::routes();

