@extends('layouts.app')

@section('title', __('Sensor Settings'))

@section('content')
<section class="section container">
    <div class="box is-vcentered is-centered">
        <h1 class="title">{{ __('Sensor Settings') }}</h1>
        <form method="POST" action="{{route('humiditysensor.update', ['humiditysensor' => $sensor])}}">
            @method('PATCH')
            @csrf
            <div class="field">
                <label class="label" for="sensor_name">{{ __('Sensor Name') }}</label>
                @guest
                    <p id="sensor_name">{{$sensor->name}}</p>
                @endguest
                @auth
                    <p class="control has-icons-left">
                        <input class="input @error('sensor_name') is-invalid @enderror"
                            type="text" id="sensor_name" name="sensor_name"
                            value="{{old('sensor_name', $sensor->name)}}">
                        <span class="icon is-small is-left">
                            <i class="fas fa-seedling"></i>
                        </span>
                        @error ('sensor_name')
                            <p class="help is-danger" role="alert">{{$message}}</p>
                        @enderror
                    </p>
                @endauth
            </div>
            <div class="field">
                <label class="label" for="alarm_threshold">{{ __('Alarm Threshold') }}</label>
                @guest
                    <p id="alarm_threshold">{{$sensor->alarm_threshold}}</p>
                @endguest
                @auth
                    <div class="control has-icons-left">
                         <input class="input @error('alarm_threshold') is-invalid @enderror" type="number"
                            id="alarm_threshold" name="alarm_threshold"
                            value="{{old('alarm_threshold', $sensor->alarm_threshold)}}" min="0" max="100"
                            maxlength="2" size="2">
                        <span class="icon is-small is-left">
                            <i class="fas fa-tint-slash"></i>
                        </span>
                        @error ('alarm_threshold')
                            <p class="help is-danger" role="alert">{{$message}}</p>
                        @enderror
                    </div>
                @endauth
            </div>
            <div class="field">
                <label class="label"  for="notes">{{ __('Notes') }}</label>
                @guest
                    <p id="notes">{{$sensor->notes}}</p>
                @endguest
                @auth
                    <div class="control is-expanded">
                        <textarea class="textarea" id="notes" name="notes">{{old('notes', $sensor->notes)}}</textarea>
                        @error ('notes')
                            <p class="help is-danger" role="alert">{{$message}}</p>
                        @enderror
                    </div>
                @endauth
            </div>
            <div class="field">
                <label class="label"  for="measurement_interval_days">{{ __('Measurement Interval') }}</label>
                @guest
                    <p id="measurement_interval">
                        {{(($mi = $sensor->measurement_interval) ? $mi->d : null) . " " . __('days') . " "
                        . (($mi = $sensor->measurement_interval) ? $mi->h : null) . " " . __('hours') }}
                    </p>
                @endguest
                @auth
                    <div class="control">
                        <div class="field has-addons">
                            <p class="control has-icons-left">
                                <input class="input @error('measurement_interval_days') is-invalid @enderror"
                                    type="number" id="measurement_interval_days" name="measurement_interval_days"
                                    value="{{old(
                                        'measurement_interval_days',
                                        ($mi = $sensor->measurement_interval) ? $mi->d : null
                                    )}}" min="0" max="30" maxlength="2" size="2">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-clock"></i>
                                </span>
                            </p>
                            <p class="control">
                                <a class="button is-static">{{ " " . __('days') . " " }}</a>
                            </p>
                            <p class="control has-icons-left">
                                <input class="input @error('measurement_interval_hours') is-invalid @enderror"
                                    type="number" id="measurement_interval_hours" name="measurement_interval_hours"
                                    value="{{old(
                                        'measurement_interval_hours',
                                        ($mi = $sensor->measurement_interval) ? $mi->h : null
                                    )}}" min="0" max="23" maxlength="2" size="2">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-clock"></i>
                                </span>
                            </p>
                            <p class="control">
                                <a class="button is-static">{{ " " . __('hours') . " " }}</a>
                            </p>
                        </div>
                        @error ('measurement_interval_days')
                            <p class="help is-danger" role="alert">{{$message}}</p>
                        @enderror
                        @error ('measurement_interval_hours')
                            <p class="help is-danger" role="alert">{{$message}}</p>
                        @enderror
                    </div>
                @endauth
            </div>
            <div class="field">
                <label class="label"  for="measurement_start">{{ __('Next Measurement Time') }}</label>
                @guest
                    <p id="measurement_start">{{$sensor->measurement_start}}</p>
                @endguest
                @auth
                    <span class="help is-info" role="alert">
                        {{
                            __('control-elements.no_changes_when_empty',
                            ['value_name' => __('Next Measurement Time')])
                        }}
                    </span>
                    <div class="control has-icons-left">
                        <input class="input @error('measurement_start') is-invalid @enderror" type="datetime-local"
                            id="measurement_start" name="measurement_start"
                            value="{{old('measurement_start', $sensor->measurement_start)}}"
                            placeholder="{{ __('e.g.') }} 2020-01-14 02:25">
                        <span class="icon is-small is-left">
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                        @error ('measurement_start')
                            <p class="help is-danger" role="alert">{{$message}}</p>
                        @enderror
                    </div>
                @endauth
            </div>
            <div class="field is-grouped is-grouped-right" style="position: relative; top: 2.5rem;">
                <p class="control">
                    <a href="/" class="button">{{ __('control-elements.return_to_dashboard') }}</a>
                </p>
                @auth
                    <p class="control">
                        <input class="button is-primary" id="submit" type="submit"
                            value="{{ __('control-elements.save_changes') }}">
                    </p>
                @endauth
            </div>
        </form>
        @auth
            <p class="control is-pulled-left">
                <form action="{{route('humiditysensor.destroy', ['humiditysensor' => $sensor]) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" class="button is-danger" value="{{ __('control-elements.delete') }}"/>
                </form>
            </p>
        @endauth
    </div>
</section>
@endsection
