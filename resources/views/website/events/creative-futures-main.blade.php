@extends('layouts.app')

@section('content')

<section class="bg_black25">
    <div class="container">
        <div class="row text-center">
            <div class="col-xs-12 col-sm-8 center-block">
                <h1 class="text-center">Creative Futures</h1>
                <p class="text-center">
                    Gain insights from industry experts and thought leaders through CREATEPhilippines' library of past Creative Futures' sessions for the creative industry.
                </p>
            </div>
        </div>
    </div>
</section>
<section class="bg_black25">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2 events-year">
                <h2>PAST EVENTS</h2>
                @foreach($years as $year)
                <a href="{{  route('events.creative-futures', ['lyear' => $year->year])  }}" class="btn btn-primary">{{ $year->year }}</a>
                @endforeach
                <!-- <a href="{{ url('events/creative-futures/speakers/asdf') }}" class="btn btn-primary"><span>Year - Speakers</span></a> -->
            </div>
            <div class="col-xs-12 col-sm-8">
                <!-- @if(Request::url()==url('/events/creative-futures/'))
                    @include('website.events.creative-futures')
                @endif
                @if(str_contains(url()->current(), '/events/creative-futures/speakers/'))
                    @include('website.events.creative-futures-speakers')
                @endif -->

                @if($page == "main")
                    @include('website.events.creative-futures')
                @elseif($page == "speakers")
                    @include('website.events.creative-futures-speakers')
                @endif
            </div>
            <div class="col-xs-12 col-sm-1"></div>
        </div>
    </div>
</section>

@endsection