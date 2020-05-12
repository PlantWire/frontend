@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <section class="section">
        <div class="container">
            <div class="columns is-multiline">
                @guest
                    <welcome-text-component></welcome-text-component>
                @endguest

                @auth
                    @if(empty($sensors))
                        <no-sensors-text-component></no-sensors-text-component>
                    @else
                        @foreach ($sensors as $sensor)
                            <measurement-display-component :sensor="{{ $sensor }}">
                            </measurement-display-component>
                        @endforeach
                        <add-sensor-card-component></add-sensor-card-component>
                    @endif
                @endauth
            </div>
        </div>
    </section>
@endsection
