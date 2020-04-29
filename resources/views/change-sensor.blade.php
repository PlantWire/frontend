@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <section class="section">
        <div class="form">
            <div class="title">
                <h1>Change Sensor Details</h1>
            </div>
            <form method="post" action="/store/{{$sensor->id}}">
                @csrf
                <div class="field is-horizontal">
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
                            <textarea class="textarea" id="notes" name="notes" value="{{old('notes', $sensor->notes)}}"></textarea>
                            @error ('notes')
                                <p class="help is-danger" role="alert">
                                    {{$message}}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="field is-horizontal">
                    <label class="label field-label"  for="measurement_interval_years">Measurement Interval</label>
                    <div class="field-body">
                        <div class="control @error('measurement_interval_years') has-addons is-danger @enderror">
                            <input type="number" id="measurement_interval_years" name="measurement_interval_years" value="{{old('measurement_interval_years', $sensor->measurement_interval_years)}}" min="0" max="99" maxlength="2" size="2">&nbsp; years
                            @error ('measurement_interval_years')
                                <p class="help is-danger" role="alert">
                                    {{$message}}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="field is-horizontal">
                    <label class="label field-label"  for="measurement_interval_months"></label>
                    <div class="field-body">
                        <div class="control @error('measurement_interval_months') has-addons is-danger @enderror">
                            <input type="number" id="measurement_interval_months" name="measurement_interval_months" value="{{old('measurement_interval_months', $sensor->measurement_interval_months)}}" min="0" max="11" maxlength="2" size="2">&nbsp; months
                            @error ('measurement_interval_months')
                                <p class="help is-danger" role="alert">
                                    {{$message}}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="field is-horizontal">
                    <label class="label field-label"  for="measurement_interval_days"></label>
                    <div class="field-body">
                        <div class="control @error('measurement_interval_days') has-addons is-danger @enderror">
                            <input type="number" id="measurement_interval_days" name="measurement_interval_days" value="{{old('measurement_interval_days', $sensor->measurement_interval_days)}}" min="0" max="30" maxlength="2" size="2">&nbsp; days
                            @error ('measurement_interval_days')
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
    </section>
@endsection
