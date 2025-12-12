@extends('layouts.app')

@section('styles')
<style>
    .promote_btn_container {
        text-align: center;
        margin-top: 50px !important;
    }

    .promote_btn_container .btn-primary {
        border: 0;
        padding: 15px 40px;
        border-radius: 40px;
        font-size: 25px;
        background-color: #ee4723;
    }


    .calendar-container {
        column-count: 3;
        column-gap: 30px;
        column-fill: auto;
        display: flex;
        flex-wrap: wrap;
    }

    .calendar-container .calendar-item {
        display: block;
        margin: 0 auto;
        margin-bottom: 40px;
        max-width: 100%;
        height: auto;
        position: relative;
        overflow: hidden;
        border-radius: 30px;
        break-inside: avoid-column;
        flex: 1 0 30%;
    }

    .calendar-container .calendar-item .event-img {
        width: 100%;
    }

    .calendar-container .ce_front_txt {
        padding-left: 5px;
        padding-bottom: 20px;
        /* line-height: 28px; */
        font-size: 18px;
    }

    .calendar-container .ce_back_txt {
        display: block;
        height: 100%;
        line-height: 28px;
        font-size: 18px;
        overflow-y: auto;
        padding-right: 0px;
        scroll-behavior: smooth;
        color: #E5E5E5;
    }

    .ce_back_txt::-webkit-scrollbar {
        width: 6px;
    }

    .ce_back_txt::-webkit-scrollbar-thumb {
        background-color: rgba(67, 67, 67, 0.92);
        border-radius: 3px;
    }

    .calendar-container .ce_front_txt .title,
    .calendar-container .ce_back_txt .title {
        font-weight: 400;
        font-size: 24px;
    }

    .calendar-container .ce_front_txt .location,
    .calendar-container .ce_back_txt .location,
    .calendar-container .ce_front_txt .date,
    .calendar-container .ce_back_txt .date {
        font-size: 20px;
        color: #D5D5D5;
    }


    .calendar-container .ce_front_txt .organizer,
    .calendar-container .ce_back_txt .organizer {
        margin-top: 25px;
        font-weight: bold;
        color: #FFFFFF;
    }

    .calendar-container .ce_back_txt .description {
        margin-top: 25px;
    }

    .calendar-container .ce_back_txt .fees {
        margin-top: 25px;

    }

    .calendar-container .ce_back_txt .fees span {
        font-weight: bold;
    }

    .calendar-container .ce_back_txt .spacer {
        margin-top: 25px;
    }

    .calendar-container .ce_back_txt .website,
    .calendar-container .ce_back_txt .registration_link {
        margin-top: 20px;
        text-align: center;
    }

    .calendar-container .btn-primary {
        background-color: #FFFFFF;
        color: #000000 !important;
        font-size: 20px;
        width: 100%;
    }

    .calendar-container .btn-primary:hover {
        background-color: #31A2F0 !important;
        color: #FFFFFF !important;
    }

    @media (max-width: 579px) {
        .calendar-container .calendar-item {
            flex: 1 0 90%;
        }
    }

    .calendar-table {
        border-collapse: collapse;
        /* removes gaps between cells */
    }

    .calendar-table td,
    .calendar-table th {
        height: 3.5rem;
        width: 3.5rem;
        padding: 0;
        /* removes inner gaps */
    }

    .active-h-w {
        height: 3rem;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: red;
    }

    .day-active {
        border-radius: 15px;

    }

    .day-active-start {
        background-color: red;
        border-radius: 15px 0 0 15px;
    }

    .day-active-middle {
        background-color: rgba(255, 0, 0, 0.3);
        border-radius: 0;
    }

    .day-active-end {
        background-color: red;
        border-radius: 0 15px 15px 0;
    }
</style>
@endsection
@section('scripts-bottom')

<script src="{{ asset('infinite_scroll/infinite_scroll.min.js') }}"></script>`
<script>
    let nextPageURL = document.getElementById('past-events-next-url').value;
    let isLoading = false;

    async function loadPastEvents() {
        if (!nextPageURL || isLoading) return;

        isLoading = true;
        document.getElementById('loading').style.display = 'block';

        // Convert the pagination URL to API URL
        let apiUrl = nextPageURL.replace('/creative-events', '/past-creative-events');

        let response = await fetch(apiUrl);
        let data = await response.json();

        const container = document.getElementById('past-events-container');

        data.data.forEach(item => {
            container.insertAdjacentHTML('beforeend', `
            <div id="event-${item.id}" class="calendar-item">
                <div>
                    <img src="${item.image_url}" class="event-img" alt="Event title" loading="lazy">
                </div>

                <div class="row ce_front_txt">
                    <div class="col-12 date">${item.date_label}${item.time_label ? " | " + item.time_label : ""}</div>
                    <div class="col-12 title">${item.name}</div>
                    <div class="col-12 location">${item.location}</div>
                </div>

                <div>
                    <div class="row ce_back_txt">
                        <div class="col-12 date">${item.date_label}${item.time_label ? " | " + item.time_label : ""}</div>
                        <div class="col-12 title">${item.name}</div>
                        <div class="col-12 location">${item.location}</div>

                        ${item.organizer ? `<div class="col-12 organizer">Organized by ${item.organizer}</div>` : ""}
                        ${item.description ? `<div class="col-12 description">${item.description}</div>` : ""}
                        ${item.fees ? `<div class="col-12 fees"><span>FEES</span><br>${item.fees}</div>` : ""}

                        <div class="spacer"></div>

                        <div class="col-10 mx-auto">
                            ${item.website ? `<div class="col-12 website"><a href="${item.website}" class="btn btn-primary" target="_blank">Click to learn more</a></div>` : ""}
                            ${item.registration_link ? `<div class="col-12 registration_link"><a href="${item.registration_link}" class="btn btn-primary" target="_blank">Click to Register</a></div>` : ""}
                        </div>
                    </div>
                </div>
            </div>
        `);
        });

        nextPageURL = data.next_page_url;

        isLoading = false;
        document.getElementById('loading').style.display = 'none';
    }

    window.addEventListener("scroll", () => {
        if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 200) {
            loadPastEvents();
        }
    });
</script>

@endsection
@section('content')

<section class="bg_black25">
    <div class="container">
        <div class="row text-center">
            <div class="col-xs-1 col-sm-8 center-block">
                <h1 class="text-center">Calendar of Events</h1>
                <p class="text-center">
                    Join us in these creative events celebrating art and culture where you can immerse yourself, amaze your senses, and take you on a journey of discovery.
                </p>
            </div>
            <div class="col-xs-1 col-sm-8 mt-4 mb-2">
                <h2 class="text-start">Upcoming/Ongoing Events</h2>
            </div>
        </div>
        <div class="row">
            <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                <ol class="carousel-indicators" style="bottom: -50px;">
                    @foreach($creative_events as $event)
                    @php

                    $date_start = $event->date_start;
                    $date_today = date("Y-m-d");
                    $event_start_date = date('Y-m-d',strtotime($date_start));
                    @endphp
                    @if (strtotime($event_start_date) >= strtotime($date_today))

                    <li data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="{{ $loop->index}}" class="{{ $loop->first ? 'active' : "" }}"></li>
                    @endif
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    @foreach($creative_events as $event)
                    @php

                    $date_start = $event->date_start;
                    $date_end = $event->date_end;
                    $date_today = date("Y-m-d");
                    $event_start_date = date('Y-m-d',strtotime($date_start));
                    // Correct PHP date formats
                    $event_month = date('m', strtotime($date_start));
                    $event_year = date('Y', strtotime($date_start));
                    $event_start_day = date('d', strtotime($date_start));
                    $event_end_day = date('d', strtotime($date_end));
                    $event_week = date('w', strtotime($date_start));
                    $event_month_full = date('F', strtotime($date_start));
                    $firstDayTimeStamp = strtotime("$event_year-$event_month-01");
                    $firstDayOfWeek = date('w', $firstDayTimeStamp);
                    // Number of days in the month
                    $numDays = cal_days_in_month(CAL_GREGORIAN, $event_month, $event_year);
                    $day_active_class = "";
                    @endphp
                    @if (strtotime($event_start_date) >= strtotime($date_today))
                    <div class="carousel-item container row {{ $loop->first ? 'active' : "" }}" id="event-{{ $event->id }}">
                        <div class="container text-center">
                            <div class="row">
                                <div class="col-12 col-md-6 d-flex justify-content-center justify-content-md-start">
                                    <img src="{{ asset('/folder_events/creative-events/' . $event->img) }}" class="img-fluid w-100" alt="Event title" loading="lazy">
                                </div>
                                <div class="col-12 col-md-6">
                                    <h3>
                                        {{ $event_month_full }} {{ $event_year }}
                                    </h3>
                                    <table class="calendar-table w-100">
                                        <thead>
                                            @foreach ($weeks as $week)
                                            <th>{{ $week }}</th>
                                            @endforeach
                                        </thead>
                                        <tbody>
                                            <tr>
                                                @for ($i = 0; $i < $firstDayOfWeek;$i++)
                                                    <td>
                                                    </td>
                                                    @endfor
                                                    @for ($day = 1; $day<= $numDays; $day++)
                                                        @php
                                                        if($day==$event_start_day && $day==$event_end_day){
                                                        $day_active_class='day-active active-h-w' ;
                                                        }
                                                        elseif($day==$event_start_day){
                                                        $day_active_class='day-active-start active-h-w' ;
                                                        }
                                                        elseif($day==$event_end_day){
                                                        $day_active_class='day-active-end  active-h-w' ;
                                                        }

                                                        elseif($day> $event_start_day && $day < $event_end_day){
                                                            $day_active_class='day-active-middle active-h-w' ;
                                                            }
                                                            else{
                                                            $day_active_class="" ;
                                                            }

                                                            @endphp
                                                            <td>
                                                            <div class="{{ $day_active_class }}">
                                                                {{ $day }}
                                                            </div>
                                                            </td>
                                                            @if (($firstDayOfWeek + $day) % 7 == 0)
                                            </tr>
                                            <tr>
                                                @endif
                                                @endfor
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="text-start fs-4 fw-bold">{{ $event->name }}</div>
                                    <div class="row text-start" style="height: 300px; overflow:scroll;">
                                        <div class=""><strong>Date|Time:</strong> {{ $event->date_label }}@if($event->time_label) | {{ $event->time_label }}@endif</div>
                                        <div class=""><strong>Location:</strong> {{ $event->location }}</div>
                                        @if($event->organizer)<div><strong>Organized by:</strong> {{ $event->organizer }}</div>@endif
                                        @if($event->description)<div>{!! $event->description !!}</div>@endif
                                        @if($event->fees)<div class=" col-12 fees"><span>FEES</span><br>{!! $event->fees !!}</div>@endif
                                    </div>
                                    <div class="col-10 mx-auto mt-2">
                                        @if($event->website)<div class="col-12 website"><a href="{{ e($event->website) }}" class="btn btn-primary" target="_blank">Click to learn more</a></div>@endif
                                        @if($event->registration_link)<div class="col-12 registration_link"><a href="{{ e($event->registration_link) }}" class="btn btn-primary" target="_blank">Click to Register</a></div>@endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                    <div class="d-flex align-items-center justify-content-center bg-black p-2 rounded-5">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </div>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                    <div class="d-flex align-items-center justify-content-center bg-black p-2 rounded-5">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </div>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="col-12 promote_btn_container">
                <a href="https://forms.gle/1qxP2LQLVEYSuWay5" class="btn btn-primary" target="_blank">Promote your Events</a>
            </div>
        </div>
        <div class="col-xs-1 col-sm-8 mt-4 mb-2">
            <h2 class="text-start">Past Events</h2>
        </div>
        <div class="row mt-60">
            <div id="past-events-container" class="calendar-container">
                @foreach($past_creative_events as $event)
                <div id="event-{{ $event->id }}" class="calendar-item">
                    <!-- <div class="icon_holder conference_icon">
                        <span></span>
                    </div> -->
                    <div>
                        <img src="{{ asset('/folder_events/creative-events/' . $event->img) }}" class="event-img" alt="Event title" loading="lazy">
                    </div>
                    <div class="row ce_front_txt">
                        <!-- FRONT -->
                        <div class="col-12 date">{{ $event->date_label }}@if($event->time_label) | {{ $event->time_label }}@endif</div>
                        <div class="col-12 title">{{ $event->name }}</div>
                        <div class="col-12 location">{{ $event->location }}</div>

                    </div>
                    <div>
                        <div class="row ce_back_txt">
                            <div class="col-12 date">{{ $event->date_label }}@if($event->time_label) | {{ $event->time_label }}@endif</div>
                            <div class="col-12 title">{{ $event->name }}</div>
                            <div class="col-12 location">{{ $event->location }}</div>
                            @if($event->organizer)<div class="col-12 organizer">Organized by {{ $event->organizer }}</div>@endif
                            @if($event->description)<div class="col-12 description">{!! $event->description !!}</div>@endif
                            @if($event->fees)<div class="col-12 fees"><span>FEES</span><br>{!! $event->fees !!}</div>@endif
                            <div class="spacer"></div>
                            <div class="col-10 mx-auto">
                                @if($event->website)<div class="col-12 website"><a href="{{ e($event->website) }}" class="btn btn-primary" target="_blank">Click to learn more</a></div>@endif
                                @if($event->registration_link)<div class="col-12 registration_link"><a href="{{ e($event->registration_link) }}" class="btn btn-primary" target="_blank">Click to Register</a></div>@endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <input type="hidden" id="past-events-next-url" value="{{ $past_creative_events->nextPageURL() }}" />
            <div id="loading" class="spinner-border mx-auto" role="status" style="display: none;">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
</section>
@endsection