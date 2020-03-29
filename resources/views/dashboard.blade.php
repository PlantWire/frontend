@extends('layouts.app')

@section('title', 'Dashboard')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
    <div class="content">
        <div class="title m-b-md">
            Recorded Events
        </div>

        <div class="links">
            @foreach ($events as $event)
                <p>Recorded at: {{ $event->created_at }} Content: {{ $event->content }}</p>
            @endforeach
        </div>
    </div>
    <example-component></example-component>
@endsection
