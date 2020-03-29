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
        <example-component></example-component>
    </div>
@endsection
