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

use App\User;
use Illuminate\Support\Facades\Input;


Route::get('/', function () {
    return view('welcome');
});

Route::post('post', 'UserController@update');
Route::get('/index', 'UserController@index');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('dashboard', function () {
    return redirect('index');
});
Route::resource('users', 'UserController');
Route::resource('projects', 'ProjectController');
Route::resource('tasks', 'TaskController');

Route::get('projects/{id}/info', 'ProjectController@projects');
Route::get('tasks/{id}/info', 'TaskController@projtask');
Route::get('users/{id}/tasks', 'TaskController@tasks');

Route::post('/updateUser', 'UserController@update');
Route::get('/editUser', 'UserController@edit');

Route::post('/updateProj', 'ProjectController@update');
Route::get('/editProj', 'ProjectController@edit');


Route::get('/editTask', 'TaskController@edit');
Route::post('/updateTask', 'TaskController@update');


