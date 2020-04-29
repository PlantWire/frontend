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
        $sensor->name = $request->sensor_name;
        if(isset($request->alarm_threshold)) {
            $sensor->alarm_threshold = $request->alarm_threshold;
        }
        if(isset($request->note)) {
            $sensor->note = $request->note;
        }
        if(isset($request->measurement_interval_years) or isset($request->measurement_interval_months) or isset($request->measurement_interval_days)) {
            $years = 0;
            $days = 0;
            $months = 0;
            if(isset($request->measurement_interval_years)) {
                $years = $request->measurement_interval_years;
            }
            if(isset($request->measurement_interval_months)) {
                $months = $request->measurement_interval_months;
            }
            if(isset($request->measurement_interval_days)) {
                $days = $request->measurement_interval_days;
            }
            $sensor->measurement_interval = $years . 'y' . $months . 'm' . $days . 'd';
        }
        if(isset($request->measurement_start)) {
            $sensor->measurement_start = $request->measurement_start;
        }
        $sensor->save();

         return redirect()->back()->with('success', 'Sensor was successfully updated.');
     }
}
