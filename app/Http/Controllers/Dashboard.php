<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Event;
use App\HumiditySensor;

use Carbon\CarbonInterval;

class Dashboard extends Controller
{
    public function index()
    {
        $measurements = HumiditySensor::with('measurements')->get();
        $measurements->each(function ($item, $key) {
            $item->measurement_interval = CarbonInterval::hour(1);
            $item->save();
        });
        return view('dashboard', ['events' => Event::all(), 'sensors'=> HumiditySensor::with('measurements')->get()]);
    }
}
