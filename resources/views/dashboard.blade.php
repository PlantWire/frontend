@extends('layouts.app')

@section('title', 'Dashboard')

@section('sidebar')
    @parent

    <p>Manage plants with ease.</p>
@endsection

@section('content')
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Recorded Events</div>

                    <div class="card-body">
                        @foreach ($events as $event)
                            <p>Recorded at: {{ $event->created_at }} Content: {{ $event->content }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="border-top my-3"></div>

        <h2>My plants</h2>

        <div class="row row-cols-1 row-cols-md-2">
            @foreach ($events as $event)
                <measurement-display-component></measurement-display-component>
            @endforeach
        </div>
    </div>
@endsection
