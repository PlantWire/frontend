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
Route::redirect('/change-sensor/', '/');
Route::get('/change-sensor/{sensor}', 'DetailView@change')->name('change-sensor');
