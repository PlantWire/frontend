<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

use App\Event;
use App\HumiditySensor;
use App\Http\Requests\StoreHumiditySensor;
use Carbon\CarbonInterval;

class DetailView extends Controller
{
    public function show(HumiditySensor $sensor)
    {
        return view('detail-view', ['sensor'=> $sensor]);
    }

    public function update(HumiditySensor $sensor) {
        return view('change-sensor', ['sensor'=> $sensor]);
    }

    public function store(HumiditySensor $sensor, StoreHumiditySensor $request) {
        $sensor->name = $request->sensor_name;
        if(isset($request->alarm_threshold)) {
            $sensor->alarm_threshold = $request->alarm_threshold;
        }
        if($request->has('notes')) {
            $sensor->notes = $request->notes ?: "";
        }
        if($request->has('measurement_interval_days') or $request->has('measurement_interval_hours')) {
            $days = $request->measurement_interval_days ?: 0;
            $hours = $request->measurement_interval_hours ?: 0;
            $sensor->measurement_interval = CarbonInterval::days($days)->hours($hours);
        }
        if($request->filled('measurement_start')) {
            $sensor->measurement_start = $request->measurement_start;
        }
        $sensor->save();

         return redirect()->back()->with('success', ['Sensor was successfully updated.']);
    }

    public function destroy(HumiditySensor $sensor) {
        $sensor->delete();
        return redirect()->route('dashboard')->with('success', ['Sensor was successfully deleted.']);
    }
}
