@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column is-one-third">
                    @foreach ($events as $event)
                        <measurement-display-component></measurement-display-component>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
