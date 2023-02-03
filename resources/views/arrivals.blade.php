<h1>{{$board->locationName}} - Arrivals</h1>

<div>
    @foreach ($board->trainServices->service as $service)
    <div>
        <span>{{$service->sta}}</span>
        <span>{{$service->origin->location[0]->locationName}}</span>
        <span>{{$service->platform}}</span>
        <span>{{$service->eta}}</span>
    </div>
    @endforeach
</div>

<pre>

@php
var_dump($board);
@endphp