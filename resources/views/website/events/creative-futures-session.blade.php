@extends('layouts.app')

@section('content')

<section class="bg_black25">
    <div class="container">
        
    </div>
</section>
<section class="bg_black25">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-10 center-block">
                <div>
                    <iframe class="embed-responsive-item" src="{{ $event->event_link }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
                <div class="session-details mt-50">
                    <p>
                        <span>{{ \Carbon\Carbon::parse($event->event_start)->format('F d, Y') }}</span> | {{ $event->location }}
                    </p>
                    <h1>
                        {{ $event->name }}
                    </h1>
                    <div class="mt-50 row">
                        <div class="col-xs-12 col-sm-5">
                            <img src="{{ asset('folder_events/' . $event->asset->path) }}" alt="Event title" class="img-fluid">
                        </div>
                        <div class="col-xs-12 col-sm-7">
                            {!! $event->description !!}
                            <!-- <p>
                                Creative Futures is CREATEPhilippines' flagship event that gathers the creative ecosystem to shape the future of the Philippine creative economy. 
                                <br><br>
                                The online event promotes and presents opportunities to Filipino creatives through knowledge sharing, business development, networking, and an expo component. Topbilled by local and international resources from the public and private sectors, it offers insight on the current status and future potential of the various creative domains. It likewise fosters community—bridging creatives, policy makers, investors, the academe, et al to develop and promote our creative sectors to the world.
                            </p> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@if(!$randomEvents->isEmpty())
<section class="bg_black25">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-10 center-block">
                <h2>
                    Sessions related to this one...
                </h2>
                <div class="events-container">
                    @foreach($randomEvents as $rEvent)
                    <article>
                        <div class="session">
                            <p>{{ \Carbon\Carbon::parse($rEvent->event_start)->format('F d, Y') }}</p>
                            <img src="{{ asset('folder_events/' . $rEvent->asset->path) }}" alt="Event title" class="img-fluid">
                            <h3>
                                {{ $rEvent->name }}
                            </h3>
                        </div>
                        <a href="{{ route('events.creative-futures-session', ['slug' => $rEvent->latestSlug->value]) }}" style="text-decoration: none;">
                            <div class="link-to-session">
                                <h4>
                                    {{ $rEvent->blurb }}<span class="fas fa-external-link-square-alt"></span>
                                </h4> 
                            </div>
                        </a>
                    </article>
                    @endforeach
                    <!-- <article>
                        <div class="session">
                            <p>Month XX, XXXX</p>
                            <img src="https://createphilippines.com/upload/assets/KeWoVh0MLiLNyZH4sJtk7Rt6HzxBWURafGyUCp2i2Za15C2OM7.jpg" alt="Event title" class="img-fluid">
                            <h3>
                                Event title 
                                <br>Event randomlongtextforchecking
                                <br>Event title
                            </h3>
                        </div>
                        <a href="{{ url('events/creative-futures/asf') }}">
                            <div class="link-to-session">
                                <h4>
                                    Event description<span class="fas fa-external-link-square-alt"></span>
                                </h4> 
                            </div>
                        </a>
                    </article> -->
                
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@endsection