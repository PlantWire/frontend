<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

use App\Event;
use App\HumiditySensor;
use App\Http\Requests\StoreHumiditySensor;

class DetailView extends Controller
{
    public function view(HumiditySensor $sensor)
    {
        return view('detail-view', ['events' => Event::all(), 'sensor'=> $sensor]);
    }

    public function update(HumiditySensor $sensor) {
        return view('change-sensor', ['sensor'=> $sensor]);
    }

    public function store(HumiditySensor $sensor, StoreHumiditySensor $request) {
        $sensor->name=$request->sensor_name;
        $sensor->save();

         return redirect()->back()->with('success', 'Sensor was successfully updated.');
     }
}
