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

                @guest
                    @if(sizeof($sensors) == 0)
                        <div class="column is-full">
                            <div class="column is-three-fifths is-offset-one-fifth">

                                <h1 class="title is-1 is-spaced">Welcome to pWire!</h1>

                                <h2 class="subtitle is-3 is-spaced">

                                    <i class="fas fa-leaf"></i> Every year, countless plants and flowers die because of improper treatment.
                                    <br/><br/>
                                    <i class="fas fa-smile-beam"></i> pWire wants to make your plants happy.
                                    <br/><br/>
                                    <i class="fas fa-tint"></i> It measures the humidity in the pot so you know when to add water.
                                    <br/><br/>
                                </h2>

                                <h2 class="subtitle is-5">
                                    @if($freshInstall)
                                        <h1 class="title">Setup</h1>
                                        <form action="{{route('user.store')}}" method="POST">
                                            @csrf
                                            <div class="field">
                                                <label class="label">{{ __('Your Name') }}</label>
                                                <div class="control">
                                                    <input class="input" type="text" placeholder="e.g Sir. Catson" name="name" value="{{ old('name') }}">
                                                </div>
                                                @error ('name')
                                                    <p class="help is-danger" role="alert">{{$message}}</p>
                                                @enderror
                                            </div>

                                            <div class="field">
                                                <label class="label">{{ __('Email') }}</label>
                                                <div class="control">
                                                    <input class="input" type="email" placeholder="e.g. example@pwire.com" name="email" value="{{ old('email') }}">
                                                </div>
                                                @error ('email')
                                                    <p class="help is-danger" role="alert">{{$message}}</p>
                                                @enderror
                                            </div>

                                            <div class="field">
                                                <label class="label">{{ __('Password') }}</label>
                                                <div class="control">
                                                    <input class="input" type="password" name="password" value="{{ old('password') }}">
                                                </div>
                                                @error ('password')
                                                    <p class="help is-danger" role="alert">{{$message}}</p>
                                                @enderror
                                            </div>

                                            <div class="field">
                                                <label class="label">{{ __('Password confirmation') }}</label>
                                                <div class="control">
                                                    <input class="input" type="password" name="password_confirmation" value="{{ old('password_confirmation') }}">
                                                </div>
                                                @error ('password_confirmation')
                                                    <p class="help is-danger" role="alert">{{$message}}</p>
                                                @enderror
                                            </div>
                                            <div class="control">
                                                <input type="submit" class="button is-fullwidth is-primary"  value="{{ __("Let's Go!") }}"/>
                                            </div>
                                        </div>
                                    @else
                                        <p>Please <a href="{{route('login')}}">log in to add your first sensor</a></p>
                                    @endif
                                </h2>
                            </div>
                        </div>
                    @endif
                @endguest

                @auth
                    @if(sizeof($sensors) == 0)
                        <div class="column is-full">
                            <div class="column is-three-fifths is-offset-one-fifth">

                                <h1 class="title is-1 is-spaced has-text-centered">You have no sensors yet</h1>

                                <a class="button is-primary is-medium is-fullwidth" href="{{route('humiditysensor.create')}}">
                                    Click here to add your first sensor
                                </a>

                            </div>
                        </div>
                    @else
                        <div class="column is-one-third">
                            <div class="card">
                                <header class="card-header">
                                    <p class="card-header-title">
                                         New Sensor
                                    </p>
                                </header>

                                <div class="card-content">
                                    <div class="content">
                                        <a class="button is-primary" href="{{route('humiditysensor.create')}}">
                                             Add a new sensor
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </section>
@endsection
