<h1>{{$board->locationName}} - Departures</h1>

@if (isset($board->nrccMessages))
<div>
    <ul>
        @foreach ($board->nrccMessages->message as $message)
        <li>{{$message->_}}</li>
        @endforeach
    </ul>
</div>
@endif

<div>
    @foreach ($board->trainServices->service as $service)
    <div>
        <span>{{$service->std}}</span>
        <span>{{implode(' and ', array_map(fn (stdClass $location) => $location->locationName, $service->destination->location))}}</span>
        @if (isset($service->platform))
        <span>{{$service->platform}}</span>
        @endif
        @if (isset($service->etd))
        <span>{{$service->etd}}</span>
        @endif
    </div>
    @endforeach
</div>

<pre>

@php
var_dump($board);
@endphp