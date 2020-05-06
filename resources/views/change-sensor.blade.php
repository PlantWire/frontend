@extends('layouts.app')

@section('title', 'Change Sensor Details')

@section('content')
<section class="section container">
    <div class="box is-vcentered is-centered">
        <div class="form">
            <h1 class="title">{{ __('Change Sensor Details') }}</h1>
            <form method="post" action="/store/{{$sensor->id}}">
                @csrf
                <div class="field is-horizontal @error('sensor_name') is-danger @enderror">
                    <label class="label field-label" for="sensor_name">Sensor Name</label>
                    <div class="field-body @error('sensor_name') has-addons is-danger @enderror">
                        <div class="control">
                            <input type="text" id="sensor_name" name="sensor_name" value="{{old('sensor_name', $sensor->name)}}">
                            @error ('sensor_name')
                                <p class="help is-danger" role="alert">
                                    {{$message}}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="field is-horizontal">
                    <label class="label field-label"  for="alarm_threshold">Alarm Threshold</label>
                    <div class="field-body @error('alarm_threshold') has-addons is-danger @enderror">
                        <div class="control">
                            <input type="number" id="alarm_threshold" name="alarm_threshold" value="{{old('alarm_threshold', $sensor->alarm_threshold)}}" min="0" max="100" maxlength="2" size="2">
                            @error ('alarm_threshold')
                                <p class="help is-danger" role="alert">
                                    {{$message}}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="field is-horizontal">
                    <label class="label field-label"  for="notes">Notes</label>
                    <div class="field-body @error('note') has-addons is-danger @enderror">
                        <div class="control is-expanded">
                            <textarea class="textarea" id="notes" name="notes">{{old('notes', $sensor->notes)}}</textarea>
                            @error ('notes')
                                <p class="help is-danger" role="alert">
                                    {{$message}}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="field is-horizontal">
                    <label class="label field-label"  for="measurement_interval_days">Measurement Interval</label>
                    <div class="field-body">
                        <div class="control @error('measurement_interval_days') has-addons is-danger @enderror @error('measurement_interval_hours') has-addons is-danger @enderror">
                            <input type="number" id="measurement_interval_days" name="measurement_interval_days" value="{{old('measurement_interval_days', ($mi = $sensor->measurement_interval) ? $mi->d : null)}}" min="0" max="30" maxlength="2" size="2">&nbsp; days &nbsp;
                            <input type="number" id="measurement_interval_hours" name="measurement_interval_hours" value="{{old('measurement_interval_hours', ($mi = $sensor->measurement_interval) ? $mi->h : null)}}" min="0" max="23" maxlength="2" size="2">&nbsp; hours
                            @error ('measurement_interval_days')
                                <p class="help is-danger" role="alert">
                                    {{$message}}
                                </p>
                            @enderror
                            @error ('measurement_interval_hours')
                                <p class="help is-danger" role="alert">
                                    {{$message}}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="field is-horizontal">
                    <label class="label field-label"  for="measurement_start">Next Measurement Time</label>
                    <div class="field-body has-addons @error('measurement_start') is-danger @enderror">
                        <div class="control">
                            <input type="datetime-local" id="measurement_start" name="measurement_start" value="{{old('measurement_start', $sensor->measurement_start)}}" placeholder="e.g. 2020-04-15 17:45">
                            @error ('measurement_start')
                                <p class="help is-danger" role="alert">
                                    {{$message}}
                                </p>
                            @enderror
                            <p class="help">leave empty to not change next planned measurement time</p>
                        </div>
                    </div>
                </div>
                <div class="field is-horizontal">
                    <label class="label field-label" for="submit">
                        <!-- Left empty for spacing -->
                    </label>
                    <div class="field-body control">
                        <a href="/" class="button">Return to Dashboard</a>&nbsp;
                        <input class="button is-primary" id="submit" type="submit" value="Save changes">
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
