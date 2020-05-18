@extends('layouts.errors')
@section('title', __('Not Found'))
@section('content')
<div class="flex-center position-ref full-height">
    <div class="column is-full">
        <div class="field">
            <div class="code is-inline">400</div>
            <div class="message is-inline">{{ __('Bad Request') }}</div>
        </div>
        <div class="field">
            <a href="/" class="button">{{ __('control-elements.return_to_dashboard') }}</a>&nbsp;
        </div>
    </div>
</div>
@endsection
