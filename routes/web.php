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

Route::get('/', 'DashboardController@index')->name('dashboard');

Route::resource('/humiditysensor', 'HumiditySensorController')->except(['index', 'show']);
Route::get('/humiditysensor/{sensor}/measure', 'HumiditySensorController@measure')->name('humiditysensor.measure');
Route::resource('/settings', 'SettingsController')->only(['index', 'store']);
Route::resource('/user', 'UserController')->only('store', 'edit', 'update');

// Authentification
//Auth::routes();

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('auth')->name('logs');
