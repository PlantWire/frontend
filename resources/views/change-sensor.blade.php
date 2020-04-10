@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <section class="section">
        <div class="form">
            <div class="title">
                <h1>Change Sensor Details</h1>
            </div>
            <form method="post">
                @csrf
                <div class="field is-horizontal">
                    <label class="label field-label" for="sensor-name">Sensor Name</label>
                    <div class="control field-body">
                        <input type="text" id="sensor-name" name="sensor-name" value="{{$sensor->name}}">
                    </div>
                </div>
                <div class="field is-horizontal">
                    <label class="label field-label"  for="alarm-threshold">Alarm Threshold</label>
                    <div class="control field-body">
                        <input type="number" id="alarm-threshold" name="alarm-threshold" value="{{$sensor->alarm_threshold}}" min="0" max="100">
                    </div>
                </div>
                <div class="field is-horizontal">
                    <label class="label field-label"  for="note">Notes</label>
                    <div class="control field-body">
                        <textarea class="textarea" id="note" name="note" value="{{$sensor->note}}"></textarea>
                    </div>
                </div>
                <div class="field is-horizontal">
                    <label class="label field-label"  for="measurement-interval-years">Measurement Interval</label>
                    <div class="field-body">
                        <div class="control">
                                <input type="text" id="measurement-interval-years" name="measurement-interval-years" value="{{$sensor->measurement_interval}}" placeholder="e.g. d1y2m3d"><br/>
                        </div>
                    </div>
                </div>
                <div class="field is-horizontal">
                    <label class="label field-label"  for="measurement-start">Next Measurement Time</label>
                    <div class="field-body">
                        <div class="field has-addons">
                            <div class="control">
                                <input type="datetime-local" id="measurement-start" name="measurement-start" placeholder="e.g. 2020-04-15 17:45"><br/>
                                <p class="help">leave empty to not change next planned measurement time</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field is-horizontal">
                    <div class="field-label">
                        <!-- Left empty for spacing -->
                    </div>
                    <div class="field-body">
                        <div class="field control">
                            <input class="button is-primary" type="submit" value="Save changes">
                        </div>
                        <div class="field control">
                            <a href="/" class="card-footer-item">Return to Dashboard</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
