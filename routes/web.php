<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;

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

Route::get('/', 'Dashboard@index')->name('dashboard');
Route::get('/create_sensor', 'SensorController@create')->name('create_sensor');
Route::post('/store_sensor', 'SensorController@store')->name('store_sensor');
Route::redirect('/change-sensor/', '/');
Route::get('/change-sensor/{sensor}', 'DetailView@update')->name('change-sensor');
Route::post('/store/{sensor}', 'DetailView@store');
Route::get('/measure/{sensor}', 'SensorController@measure');

Route::get('/settings', 'PlatformController@index')->name('platform_settings');
Route::post('/settings', 'PlatformController@store');

// Authentification
Auth::routes();
Route::get('/user/{user}', 'UserController@index')->name('edit_user');
Route::post('/user/{user}', 'UserController@store')->name('store_user');

// Logs
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
