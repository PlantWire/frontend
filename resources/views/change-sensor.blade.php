@extends('layouts.app')

@section('title', __('Change Sensor Details'))

@section('content')
<section class="section container">
    <div class="box is-vcentered is-centered">
        <div class="form">
            <h1 class="title">{{ __('Change Sensor Details') }}</h1>
            <form method="post" action="/store/{{$sensor->id}}">
                @csrf
                <div class="field is-horizontal @error('sensor_name') is-danger @enderror">
                    <label class="label field-label column is-one-quarter" for="sensor_name">
                        {{ __('Sensor Name') }}
                    </label>
                    <div class="field-body column is-three-quarters @error('sensor_name') is-danger @enderror">
                        @guest
                            <p id="sensor_name">
                                {{$sensor->name}}
                            </p>
                        @endguest
                        @auth
                            <div class="control">
                                <input type="text" id="sensor_name" name="sensor_name"
                                    value="{{old('sensor_name', $sensor->name)}}">
                                @error ('sensor_name')
                                    <p class="help is-danger" role="alert">
                                        {{$message}}
                                    </p>
                                @enderror
                            </div>
                        @endauth
                    </div>
                </div>
                <div class="field is-horizontal">
                    <label class="label field-label column is-one-quarter"
                        for="alarm_threshold">{{ __('Alarm Threshold') }}</label>
                    <div class="field-body column is-three-quarters @error('alarm_threshold') is-danger @enderror">
                        @guest
                            <p id="notes">
                                {{$sensor->alarm_threshold}}
                            </p>
                        @endguest
                        @auth
                            <div class="control">
                                <input type="number" id="alarm_threshold" name="alarm_threshold"
                                    value="{{old('alarm_threshold', $sensor->alarm_threshold)}}" min="0" max="100"
                                    maxlength="2" size="2">
                                @error ('alarm_threshold')
                                    <p class="help is-danger" role="alert">
                                        {{$message}}
                                    </p>
                                @enderror
                            </div>
                        @endauth
                    </div>
                </div>
                <div class="field is-horizontal">
                    <label class="label field-label column is-one-quarter"  for="notes">{{ __('Notes') }}</label>
                    <div class="field-body column is-three-quarters @error('note') is-danger @enderror">
                        @guest
                            <p id="notes">
                                {{$sensor->notes}}
                            </p>
                        @endguest
                        @auth
                            <div class="control is-expanded">
                                <textarea class="textarea" id="notes" name="notes">
                                    {{old('notes', $sensor->notes)}}
                                </textarea>
                                @error ('notes')
                                    <p class="help is-danger" role="alert">
                                        {{$message}}
                                    </p>
                                @enderror
                            </div>
                        @endauth
                    </div>
                </div>
                <div class="field is-horizontal">
                    <label class="label field-label column is-one-quarter"  for="measurement_interval_days">
                        {{ __('Measurement Interval') }}
                    </label>
                    <div class="field-body column is-three-quarters">
                        @guest
                            <p id="measurement_interval">
                                {{($mi = $sensor->measurement_interval) ? $mi->d : null}}&nbsp; days &nbsp;
                                {{($mi = $sensor->measurement_interval) ? $mi->h : null}}&nbsp; hours
                            </p>
                        @endguest
                        @auth
                            <div class="control @error('measurement_interval_days') is-danger @enderror
                                @error('measurement_interval_hours') is-danger @enderror">
                                <input type="number" id="measurement_interval_days" name="measurement_interval_days"
                                    value="{{old(
                                        'measurement_interval_days',
                                        ($mi = $sensor->measurement_interval) ? $mi->d : null
                                    )}}" min="0" max="30" maxlength="2" size="2">&nbsp; {{ __('days') }} &nbsp;
                                <input type="number" id="measurement_interval_hours" name="measurement_interval_hours"
                                    value="{{old(
                                        'measurement_interval_hours',
                                        ($mi = $sensor->measurement_interval) ? $mi->h : null
                                    )}}" min="0" max="23" maxlength="2" size="2">&nbsp; {{ __('hours') }}
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
                        @endauth
                    </div>
                </div>
                <div class="field is-horizontal">
                    <label class="label field-label column is-one-quarter"  for="measurement_start">
                        {{ __('Next Measurement Time') }}
                    </label>
                    <div class="field-body column is-three-quarters has-addons
                        @error('measurement_start') is-danger @enderror">
                        @guest
                            <p id="measurement_start">
                                {{$sensor->measurement_start}}
                            </p>
                        @endguest
                        @auth
                            <div class="control">
                                <input type="datetime-local" id="measurement_start" name="measurement_start"
                                    value="{{old('measurement_start', $sensor->measurement_start)}}"
                                    placeholder="{{ __('e.g.') }} 2020-04-15 17:45">
                                @error ('measurement_start')
                                    <p class="help is-danger" role="alert">
                                        {{$message}}
                                    </p>
                                @enderror
                                <p class="help">{{
                                    __('control-elements.no_changes_when_empty',
                                    ['value_name' => __('Next Measurement Time')])
                                }}</p>
                            </div>
                        @endauth
                    </div>
                </div>
                <div class="field is-horizontal">
                    <div class="field-body control column is-three-quarters is-offset-one-quarter">
                        <a href="/" class="button">{{ __('control-elements.return_to_dashboard') }}</a>&nbsp;
                        @auth
                            <input class="button is-primary" id="submit" type="submit"
                                value="{{ __('control-elements.save_changes') }}">
                        @endauth
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
