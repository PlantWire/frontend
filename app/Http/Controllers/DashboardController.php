<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Event;
use App\User;
use App\HumiditySensor;

use Carbon\CarbonInterval;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'maxAmountOfMeasurementsToDisplay' => env("MAX_AMOUNT_OF_MEASUREMENTS_PER_SENSOR_TO_DISPLAY", 15),
            'sensors'=> HumiditySensor
                ::with(array('measurements' => function($query) {
                    $query
                        ->orderBy('created_at', 'ASC')
                    ;
                }))
                ->orderBy('name', 'ASC')
                ->get(),
            'freshInstall' => User::all()->count() == 0
        ]);
    }
}
