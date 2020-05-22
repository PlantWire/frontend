
@switch($content->type)
@case('Log')
    @switch($content->content->logType)
        @case('warn')
            <article class="panel is-warning" >
            @break
        @case('info')
            <article class="panel is-info" >
            @break
        @default
            <article class="panel is-danger" >
            @break
    @endswitch
        <p class="panel-heading">
            <span class="fas fa-clock"></span>&nbsp;{{ $event->created_at->toDayDateTimeString() }}: Log
        </p>
        <div class="panel-block">
            <div class="columns" style="width: 100%;">
                <div class="column is-one-third">
                    <b>Log Level:</b>
                </div>
                <div class="column">
                    {{ $content->content->logType ?? 'Unknown' }}
                </div>
            </div>
        </div>
        <div class="panel-block">
            <div class="columns" style="width: 100%;">
                <div class="column is-one-third">
                    <b>Message:</b>
                </div>
                <div class="column">
                    {{ $content->content->message ?? 'Empty' }}
                </div>
            </div>
        </div>
    </article>
@break

@case('HumidityMeasurementResponse')
<article class="panel is-success" >
    <p class="panel-heading">
        <span class="fas fa-clock"></span>&nbsp;{{ $event->created_at->toDayDateTimeString() }}: New Measurement
    </p>
    <div class="panel-block">
        <div class="columns" style="width: 100%;">
            <div class="column is-one-third">
                <b>Sender:</b>
            </div>
            <div class="column">
                {{ $content->sender ?? 'unknown' }}
            </div>
        </div>
    </div>
    <div class="panel-block">
        <div class="columns" style="width: 100%;">
            <div class="column is-one-third">
                <b>Value:</b>
            </div>
            <div class="column">
                {{ $content->content->value ?? 'unknown' }}
            </div>
        </div>
    </div>
</article>
@break

@default
<article class="panel is-warning" >
    <p class="panel-heading">
        <span class="fas fa-clock"></span>&nbsp;{{ $event->created_at->toDayDateTimeString() }}: Unknown Event
    </p>
    <div class="panel-block">
        <div class="notification is-info" style="width: 100%;">
            Unknown event occured, maybe you are missing a plugin?
        </div>
    </div>
    <div class="panel-block">
        <div class="columns" style="width: 100%;">
            <div class="column is-one-third">
                <b>Content:</b>
            </div>
            <div class="column">
                <code>
                    {{ json_encode($content) }}
                </code>
            </div>
        </div>

    </div>
</article>
@endswitch
