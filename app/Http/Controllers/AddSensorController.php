<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\HumiditySensor;
use App\Http\Requests\AddSensorRequest;

class AddSensorController extends Controller
{
    /*public function __construct () {
        $this->middleware('auth');
    }*/

    public function addSensor()
    {
        return view('add-sensor');
    }

    public function saveSensor(AddSensorRequest $request) {

        $uuid = $request->input('uuid');
        $pin = $request->input('pin');
        $name = $request->input('name');

        $humiditySensor = new HumiditySensor();;
        $humiditySensor->uuid = $uuid;
        $humiditySensor->name = $name;
        $humiditySensor->measurement_interval = 'P0Y0M0DT8H0M0S'; //every 8 hours
        $humiditySensor->alarm_threshold = 0;
        $humiditySensor->notes = '';
        $humiditySensor->save();

        return redirect()->action('Dashboard@index')/*->with('success', [__('New Sensor added successfully')])*/;
    }
}
