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
Route::get('/publish/{message}', 'Dashboard@publish')->name('dashboard');
Route::get('/add_sensor', 'AddSensorController@addSensor')->name('add_sensor');
Route::post('/save_sensor', 'AddSensorController@saveSensor')->name('save_sensor');
