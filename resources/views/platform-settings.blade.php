@extends('layouts.app')

@section('title', __('Platform Settings'))

@section('content')
<section class="section container">
    <div class="box is-vcentered is-centered">
        <h1 class="title">{{ __('Platform Settings') }}</h1>
        <form method="post" action="/settings" class="is-clearfix">
            @csrf
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label" for="loglevel">{{ __('Log level') }}</label>
                </div>
                <div class="field-body">
                    <div class="control has-icons-left">
                        <div class="select is-fullwidth">
                            <select class="@error('loglevel') is-invalid @enderror"
                                id="loglevel" name="loglevel">
                                <option {{ old('loglevel', $loglevel) == 'verbose' ? 'selected' : '' }} value="verbose">{{ __('Verbose') }}</option>
                                <option {{ old('loglevel', $loglevel) == 'info' ? 'selected' : '' }} value="info">{{ __('Info') }}</option>
                                <option {{ old('loglevel', $loglevel) == 'warning' ? 'selected' : '' }} value="warning">{{ __('Warning') }}</option>
                                <option {{ old('loglevel', $loglevel) == 'error' ? 'selected' : '' }} value="error">{{ __('Error') }}</option>
                            </select>
                        </div >
                        <span class="icon is-small is-left">
                            <i class="fas fa-info-circle"></i>
                        </span>
                        @error ('loglevel')
                            <p class="help is-danger" role="alert">{{$message}}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <input type="submit" class="button is-primary is-pulled-right" value="{{ __('Save') }}" />
        </form>

    </div>
</section>
@endsection
