@extends('layouts.app')

@section('title', 'Events')

@section('content')
<div class="section container">
    <div class="columns is-one-third is-vcentered is-centered">
        <div class="box">
            <h1 class="title">{{ __('Events') }}</h1>
            @foreach ($events as $key => $event)
            <x-event :event="$event"></x-event>
            @endforeach
            <hr>
            {{ $events->links('vendor.pagination.default') }}
        </div>
    </div>

</div>
</section>
@endsection
