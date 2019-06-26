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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function() {
    
    Route::get('/projects', 'ProjectsController@index');//->middleware('auth');
    Route::get('/projects/create', 'ProjectsController@create'); // Order of these may matter?
    Route::get('/projects/{project}', 'ProjectsController@show');//->middleware('auth');
    Route::post('/projects/{project}/tasks', 'ProjectTasksController@store');
    Route::post('/projects', 'ProjectsController@store');//->middleware('auth');

});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
