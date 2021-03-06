@extends('layouts.errors')
@section('title', __('Not Found'))
@section('content')
<div class="flex-center position-ref full-height">
    <div class="column is-full">
        <div class="field">
            <div class="code is-inline">404</div>
            <div class="message is-inline">{{ __('Not Found') }}</div>
        </div>
        <div class="field">
            <a href="/" class="button">{{ __('control-elements.return_to_dashboard') }}</a>&nbsp;
        </div>
    </div>
</div>
@endsection
