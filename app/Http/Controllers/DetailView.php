<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

use App\Event;
use App\HumiditySensor;

class DetailView extends Controller
{
    public function view(HumiditySensor $sensor)
    {
        return view('detail-view', ['events' => Event::all(), 'sensor'=> $sensor]);
    }

    public function change(HumiditySensor $sensor) {
        echo("Sensor Change form requested for pWire Sensor " . $sensor->name . ".");
        return view('change-sensor', ['sensor'=> $sensor]);
    }
}
