@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column is-one-third">
                    @foreach ($sensors as $sensor)
                        <measurement-display-component :sensor="{{ $sensor->measurements }}" ></measurement-display-component>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
