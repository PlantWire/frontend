@extends('layouts.app')

@section('title', __('Logs'))

@section('content')
<div class="container box" >
    <div class="columns">
        <div class="column is-one-quarter">
            <aside class="menu">
                <p class="menu-label">
                    Available Logs
                </p>
                <ul class="menu-list">
                    @foreach($folders as $folder)
                    <li>
                        <p class="meunu-label">
                            <a href="?f={{ \Illuminate\Support\Facades\Crypt::encrypt($folder) }}">
                                <span class="fa fa-folder"></span> {{ $folder }}
                            </a>
                        </p>
                        @if ($current_folder == $folder)
                            <ul class="meunu-list">
                                @foreach($folder_files as $file)
                                    <li>
                                        <a href="?l={{ \Illuminate\Support\Facades\Crypt::encrypt($file) }}&f={{ \Illuminate\Support\Facades\Crypt::encrypt($folder) }}" class="list-group-item @if ($current_file == $file) is-active @endif">
                                            {{ $file }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                    @endforeach
                    @foreach($files as $file)
                    <li>
                        <a href="?l={{ \Illuminate\Support\Facades\Crypt::encrypt($file) }}" class="list-group-item @if ($current_file == $file) is-active @endif">
                            {{$file}}
                        </a>
                    </li>
                    @endforeach
            </aside>
        </div>
        <div class="column is-three-quarters">
            <div class="card">
                @if ($logs === null)
                <div>
                    Log file >50M, please download it.
                </div>
                @else
                    <div class="card-header" style="padding: 1rem;">
                        @if($current_file)
                            <p class="card-header-title">
                                {{ $current_file }}

                                <div class="is-pulled-right">
                                    <button class="button">
                                        <a href="?dl={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                                            <span class="fa fa-download"></span> Download file
                                        </a>
                                    </button>

                                    <button class="button">
                                        <a id="clean-log" href="?clean={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                                            <span class="fa fa-sync"></span> Clean file
                                        </a>
                                    </button>

                                    <button class="button is-danger">
                                        <a id="delete-log"  class="has-text-white" href="?del={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                                            <span class="fa fa-trash"></span> Delete file
                                        </a>
                                    </button>
                                    @if(count($files) > 1)
                                        <button class="button is-danger">
                                            <a id="delete-all-log" class="has-text-white" href="?delall=true{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                                                <span class="fa fa-trash-alt"></span> Delete all files
                                            </a>
                                        </button>
                                    @endif
                                </div>
                            </p>
                        @endif
                    </div>
                    @if(sizeof($logs) < 1 || (sizeof($logs) == 1 && trim($logs[0]['text']) == '')  )
                        <div class="columns is-centered">
                            <div class="column is-one-third" style="padding: 1rem;">
                                <span style="position: relative; top: .75rem;" class="fas fa-3x fa-times"></span> <span style="margin: 1rem;">This file is empty</span>
                            </div>
                        </div>
                    @else
                        <div class="card-content">
                            <table class="table table-striped is-narrow is-fullwidth" style=" width: 100%; max-width:100%;">
                                <thead>
                                    <tr>
                                        @if ($standardFormat)
                                        <th>Level</th>
                                        <th>Context</th>
                                        <th>Date</th>
                                        @else
                                        <th>Line number</th>
                                        @endif
                                        <th>Content</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $key => $log)
                                    <tr class="{{ $log['level'] }}">
                                        @if ($standardFormat)
                                        <td>
                                            <span class="fa fa-{{{ $log['level_img'] }}}" aria-hidden="true"></span><br> {{ $log['level'] }}
                                        </td>
                                        <td class="text">{{ $log['context'] }}</td>
                                        @endif
                                        <td class="date">{{{ $log['date'] }}}</td>
                                        <td class="text" style="line-break: anywhere;">
                                            {{{ $log['text'] }}}
                                            @if (isset($log['in_file']))
                                            <br />{{{ $log['in_file'] }}}
                                            @endif
                                            @if ($log['stack'])
                                            <button id="stackToggle{{{$key}}}" type="button" class="button is-fullwidth" onclick="document.getElementById('stack{{{$key}}}').classList.toggle('is-hidden'); this.classList.toggle('is-hidden')">
                                                <span class="fa fa-arrow-down"></span>&nbsp; <span>Show full Stacktrace</span>
                                            </button>
                                            <div class="stack is-hidden" id="stack{{{$key}}}">
                                                <hr>
                                                <code>
                                                    {{{ trim($log['stack']) }}}
                                                </code>
                                                <button type="button" class="button is-fullwidth" onclick="this.parentElement.classList.toggle('is-hidden'); document.getElementById('stackToggle{{{$key}}}').classList.toggle('is-hidden')">
                                                    <span class="fa fa-arrow-up"></span>&nbsp; <span>Show full Stacktrace</span>
                                                </button>
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
