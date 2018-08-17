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

Route::get('projects/{id}/projects', 'ProjectController@projects');
Route::get('task/{id}', 'TaskController@projectTasks');
Route::get('users/{id}/task', 'TaskController@userTasks');

Route::post('/user/update', 'UserController@update');
Route::get('/user/edit', 'UserController@edit');

Route::post('/project/update', 'ProjectController@update');
Route::get('/project/edit', 'ProjectController@edit');


Route::get('/task/edit', 'TaskController@edit');
Route::post('/task/update', 'TaskController@update');


