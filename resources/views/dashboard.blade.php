@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <section class="section">
        <div class="container">
            <div class="columns is-multiline">
                @foreach ($sensors as $sensor)
                    <measurement-display-component :sensor="{{ $sensor }}" :max-amount-of-measurements-to-display="{{ $maxAmountOfMeasurementsToDisplay }}">
                    </measurement-display-component>
                @endforeach

                @auth
                    <add-sensor-card-component></add-sensor-card-component>
                @endauth
            </div>
        </div>
    </section>
@endsection

