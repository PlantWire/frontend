@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <section class="section">
        <div class="container">
            <div class="columns">
                @foreach ($sensors as $sensor)
                    <measurement-display-component :sensor="{{ $sensor }}">
                    </measurement-display-component>
                @endforeach
            </div>
        </div>
    </section>
@endsection
