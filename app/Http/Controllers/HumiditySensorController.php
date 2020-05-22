<?php

namespace App\Http\Controllers;

use Carbon\CarbonInterval;

use App\Http\Requests\StoreHumiditySensorRequest;
use App\Http\Requests\UpdateHumiditySensorRequest;

use App\HumiditySensor;

use App\Jobs\RequestMeasurement;

use Redirect;

class HumiditySensorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['edit']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Redirect::route('dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('humiditysensor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreHumiditySensorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHumiditySensorRequest $request)
    {
        $uuid = $request->input('uuid');
        $pin = $request->input('pin');
        $name = $request->input('name');

        $humiditysensor = new HumiditySensor();;
        $humiditysensor->uuid = $uuid;
        $humiditysensor->name = $name;
        $humiditysensor->measurement_interval = new CarbonInterval('P0Y0M0DT8H0M0S');
        $humiditysensor->alarm_threshold = 0;
        $humiditysensor->notes = '';
        $humiditysensor->save();

        return Redirect::route('humiditysensor.edit', [
            'humiditysensor' => $humiditysensor
            ])->with('success', [__('New Sensor added successfully. You can add more details here')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  HumiditySensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function edit(HumiditySensor $humiditysensor)
    {
        return view('humiditysensor.edit', ['sensor' => $humiditysensor]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateHumiditySensor  $request
     * @param  HumiditySensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHumiditySensorRequest $request, HumiditySensor $humiditysensor)
    {
        $humiditysensor->name = $request->sensor_name;
        if($request->has('alarm_threshold')) {
            $humiditysensor->alarm_threshold = $request->alarm_threshold;
        }
        if($request->has('notes')) {
            $humiditysensor->notes = $request->notes ?: "";
        }
        if($request->has('measurement_interval_days') or $request->has('measurement_interval_hours')) {
            $days = $request->measurement_interval_days ?: 0;
            $hours = $request->measurement_interval_hours ?: 0;
            $humiditysensor->measurement_interval = CarbonInterval::days($days)->hours($hours);
        }
        if($request->filled('measurement_start')) {
            $humiditysensor->measurement_start = $request->measurement_start;
        }
        $humiditysensor->save();

        return Redirect::back()->with('success', [__('humidity-sensor.updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  HumiditySensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function destroy(HumiditySensor $humiditysensor)
    {
        $humiditysensor->delete();
        return Redirect::route('dashboard')->with('success', [__('humidity-sensor.removed')]);
    }

    /**
     * Perform a single measurement
     * @param  HumiditySensor $sensor
     * @return \Illuminate\Http\Response
     */
    public function measure(HumiditySensor $humiditysensor) {
        RequestMeasurement::dispatch($humiditysensor);
        return Redirect::back()->with('info', [__('humidity-sensor.measurement_requested', ['sensor_name' => $sensor->name])]);
    }
}
