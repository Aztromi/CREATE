@extends('layouts.app')

@section('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="{{ asset('css/website/info_page.css?ver='.time()) }}" rel="stylesheet">
@endsection
 
@section('scripts-bottom')

    @include('website.info_page.sched_clark')
    @include('website.info_page.sched_dapitan')
    @include('website.info_page.sched_bohol')

    <script>
        $('.btn-colsched').click(function() {
            const clickedButton = $(this);
            const targetId = clickedButton.attr('aria-controls');

            // Remove active class from all buttons
            $('.btn-colsched').removeClass('btn_active');

            // Add active class to clicked button
            clickedButton.addClass('btn_active');

            // Hide all collapse sections
            $('.collapse').collapse('hide');

            // Show specific collapse section based on clicked button's aria-controls attribute
            $(`#${targetId}`).collapse('show');
        });

        // Location Tab Click
        $('#locationTab .nav-link').click(function() {
            if(!$(this).hasClass('active')){
                $tab = $(this).attr('id');
                if($tab == 'clark-tab'){
                    $('#locationTab #clark-tab-pane #db_id').click();
                }
                else if($tab == 'dapitan-tab'){
                    $('#locationTab #dapitan-tab-pane #db_id').click();
                }
                else if($tab  == 'bohol-tab'){
                    $('#locationTab #bohol-tab-pane #db_id').click();
                }
            }
        });
        

        // Schedule Data
        
        const containers = {
            "scheduleClarkDay1": document.getElementById('schedule-clark-container-day1'),
            "scheduleClarkDay2": document.getElementById('schedule-clark-container-day2'),
            "scheduleClarkDay3": document.getElementById('schedule-clark-container-day3'),

            "scheduleDapitanDay1": document.getElementById('schedule-dapitan-container-day1'),
            "scheduleDapitanDay2": document.getElementById('schedule-dapitan-container-day2'),
            "scheduleDapitanDay3": document.getElementById('schedule-dapitan-container-day3'),

            "scheduleBoholDay1": document.getElementById('schedule-bohol-container-day1'),
            "scheduleBoholDay2": document.getElementById('schedule-bohol-container-day2'),
            "scheduleBoholDay3": document.getElementById('schedule-bohol-container-day3')
        };

        Object.keys(scheduleDataClark).forEach(day => {
            const scheduleContainer = containers[day];
            scheduleDataClark[day].forEach(item => {
                const scheduleItem = document.createElement('div');
                scheduleItem.className = 'schedule-item';

                const time = document.createElement('div');
                time.className = 'time';
                time.innerText = `${item.timeStart} - ${item.timeEnd}`;
                scheduleItem.appendChild(time);

                const details = document.createElement('div');
                details.className = 'details';

                

                const activity = document.createElement('div');
                activity.className = 'activity';
                activity.innerHTML = item.activity;

                if(item.activity2){
                    activity.innerHTML += "<br><br>";
                    activity.innerHTML += item.activity2;
                }

                details.appendChild(activity);

                if(item.speaker){

                    const speaker = document.createElement('div');
                    speaker.className = 'speaker';
                    speaker.innerText = item.speaker;

                    details.appendChild(document.createElement('br'));
                    details.appendChild(speaker);
                }

                // const person = document.createElement('div');
                // person.className = 'person';
                // person.innerText = item.personInCharge;
                // details.appendChild(person);

                // if (item.remarks) {
                // const remarks = document.createElement('div');
                // remarks.className = 'remarks';
                // remarks.innerText = item.remarks;
                // details.appendChild(remarks);
                // }

                scheduleItem.appendChild(details);
                scheduleContainer.appendChild(scheduleItem);
            });
        });

        Object.keys(scheduleDataDapitan).forEach(day => {
            const scheduleContainer = containers[day];
            scheduleDataDapitan[day].forEach(item => {
                const scheduleItem = document.createElement('div');
                scheduleItem.className = 'schedule-item';

                const time = document.createElement('div');
                time.className = 'time';
                time.innerText = `${item.timeStart} - ${item.timeEnd}`;
                scheduleItem.appendChild(time);

                const details = document.createElement('div');
                details.className = 'details';

                const activity = document.createElement('div');
                activity.className = 'activity';
                activity.innerHTML = item.activity;

                if(item.activity2){
                    activity.innerHTML += "<br><br>";
                    activity.innerHTML += item.activity2;
                }
                
                details.appendChild(activity);

                // const person = document.createElement('div');
                // person.className = 'person';
                // person.innerText = item.personInCharge;
                // details.appendChild(person);

                // if (item.remarks) {
                // const remarks = document.createElement('div');
                // remarks.className = 'remarks';
                // remarks.innerText = item.remarks;
                // details.appendChild(remarks);
                // }

                scheduleItem.appendChild(details);
                scheduleContainer.appendChild(scheduleItem);
            });
        });

        Object.keys(scheduleDataBohol).forEach(day => {
            const scheduleContainer = containers[day];
            scheduleDataBohol[day].forEach(item => {
                const scheduleItem = document.createElement('div');
                scheduleItem.className = 'schedule-item';

                const time = document.createElement('div');
                time.className = 'time';
                time.innerText = `${item.timeStart} - ${item.timeEnd}`;
                scheduleItem.appendChild(time);

                const details = document.createElement('div');
                details.className = 'details';

                const activity = document.createElement('div');
                activity.className = 'activity';
                activity.innerHTML = item.activity;

                if(item.activity2){
                    activity.innerHTML += "<br><br>";
                    activity.innerHTML += item.activity2;
                }

                details.appendChild(activity);

                // const person = document.createElement('div');
                // person.className = 'person';
                // person.innerText = item.personInCharge;
                // details.appendChild(person);

                // if (item.remarks) {
                // const remarks = document.createElement('div');
                // remarks.className = 'remarks';
                // remarks.innerText = item.remarks;
                // details.appendChild(remarks);
                // }

                scheduleItem.appendChild(details);
                scheduleContainer.appendChild(scheduleItem);
            });
        });

        // jQuery script for smooth scrolling with padding
        $(document).ready(function() {
            $('.scroll-link').click(function(event) {
                event.preventDefault(); // Prevent default anchor click behavior
                
                // Get the target element ID from the href attribute
                var targetId = $(this).attr('href');
                
                // Scroll to the target element with padding
                $('html, body').animate({
                    scrollTop: $(targetId).offset().top - 100 // Adding 100px padding on top
                }, 2000); // Animation speed of 2 seconds
            });
        });
    </script>
@endsection

@section('content') 
    
    {{-- BANNER --}}
    <section class="fullBanner">
        <div class="container-fluid text-center ahref-light">
            <img src="{{ asset('img/static/x_mipam/cphxmipam_.webp') }}" alt="CREATEPhilippines x MIPAM logo" class="mx-auto cxm-bannerlogo">
            <br><div class="event-year">2024</div>

            <h1 class="ff-raleway-header">
                NAVIGATE THE 
                <br>TOURING CIRCUIT
            </h1>
            <div>
                <p class="subheader">
                    A Capacity-Building Program for the Performing Arts
                </p>
            </div>
            <div>
                <a href="https://bit.ly/3VFwMJR" class="btn-lg cta-register" target="_blank">
                    <div>REGISTER NOW</div>
                </a>
                <a href="#schedule" class="btn-lg cta-view scroll-link">
                    <div>VIEW 3-DAY SCHEDULE</div>
                </a>
            </div>
        </div>
    </section>
    {{-- LOCATIONS --}}
    {{-- PARALLAX VIDEO --}}
    <div class="video-container">
        <video autoplay muted loop id="banner-video">
            <!-- Replace 'your-video.mp4' with your video file -->
            <source src="{{ asset('img/static/x_mipam/createxmipam.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="overlay"></div>
        <div class="content">
            <div class="rs-container">
                <img src="{{ asset('img/static/x_mipam/ntc-loc3x.png') }}" alt="Navigating the Tour Circuit Road Show Locations" class="mx-auto img-fluid">
            </div>
        </div>
    </div>
     {{-- <section>
        <div class="container ">
            <div class="rs-container">
                <img src="{{ asset('img/static/x_mipam/ntc-loc3x.png') }}" alt="Navigating the Tour Circuit Road Show Locations" class="mx-auto img-fluid">
            </div>
        </div>
    </section>  --}}
    {{-- KICK-OFF --}} 
    <section>
        <div class="orgshp01">
            <img src="{{ asset('img/static/x_mipam/abstract/shp01-orange.png') }}" alt="organic blue shape" class="img-fluid">
        </div>
        <div class="redshp02">
            <img src="{{ asset('img/static/x_mipam/abstract/shp01-red.png') }}" alt="organic red shape" class="img-fluid">
        </div>
        <div class="note01">
            <img src="{{ asset('img/static/x_mipam/abstract/drawings/note.png') }}" alt="musical note outline drawing" class="img-fluid">
        </div>
        <div class="bulb01">
            <img src="{{ asset('img/static/x_mipam/abstract/drawings/bulb.png') }}" alt="bulb outline drawing" class="img-fluid">
        </div>
        <div class="spl07">
            <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl06.png') }}" alt="paint splashes" class="img-fluid">
        </div>
        <div class="spl08">
            <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl20.png') }}" alt="paint splashes" class="img-fluid">
        </div>
        <div class="spl09">
            <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl05.png') }}" alt="paint splashes" class="img-fluid">
        </div>
        <div class="spl10">
            <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl01.png') }}" alt="paint splashes" class="img-fluid">
        </div>
        <div class="container ahref-light kick-off-container">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-3 jkc-left">
                    <h2>KICKOFF CEREMONY</h2>
                    <p>
                        July 11, UP Manila &mdash; Little Theater
                    </p>
                </div>
                <div class="col-xs-12 col-md-1">
                    <div class="ksc-border"></div>
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 jkc-right">
                    <p class="mt-10">
                        Thank you for joining us at the kickoff event of <b>NAVIGATE THE TOURING CIRCUIT</b>! Continue elevating your career in the performing arts by participating in our next training sessions.
                    </p>
                    <a href="https://createphilippines.com/createph-x-mipam/gallery" class="btn-lg cta-view text-center">
                        <div>View Gallery</div>
                    </a>
                </div>
            </div>  
        </div>
        <div class="container mt-50">
            <div class="row pb-5">
                <div class="col-xs-12 col-md-4 text-center">
                    <h2 class="text-color-yellow">MODERATOR</h2>
                    <div class="spk-container mt-30">
                        <img src="{{ asset('img/static/x_mipam/speakers_moderators/mod_samodio.png') }}" alt="Jill Samodio, Navigating the Tour Circuit Moderator" class="mx-auto img-fluid mb-20">
                        <p>
                            <b class="text-color-yellow">Jill Samodio</b>
                            <br>DLSU Culture & Arts Director
                        </p>
                    </div>
                </div>
                <div class="col-xs-12 col-md-8">
                    <h2 class="text-color-yellow spk-holder">SPEAKERS</h2>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="spk-container">
                                <img src="{{ asset('img/static/x_mipam/speakers_moderators/spk_marasigan.png') }}" alt="Dennis Marasigan, speaker for the cretive industry and global market" class="mx-auto img-fluid mb-20">
                                <p>
                                    <b class="text-color-yellow">The Creative Industry & Global Market</b>
                                    <br><b>Mr. Dennis N. Marasigan</b>
                                    <br>CCP Vice President & Artistic Director 
                                </p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="spk-container">
                                <img src="{{ asset('img/static/x_mipam/speakers_moderators/spk_belarmino.png') }}" alt="Vanini Belarmino, speaker for Charting Alternative Paths: The Future of Performance" class="mx-auto img-fluid mt-20 mb-20">
                                <p>
                                    <b class="text-color-yellow">
                                        Charting Alternative Paths:
                                        <br>The Future of Performance
                                    </b>
                                    <br><b>Ms. Vanini B. Belarmino</b> 
                                    <br>Belarmino&Partners Founder & Managing Director
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <h2 class="text-color-green">WITH A SPECIAL PERFORMANCE FROM</h2>
                <div class="mx-auto col-xs-12 col-sm-4 col-md-3 mt-30 perf-container">
                    <img src="{{ asset('img/static/x_mipam/performer01bw.png') }}" alt="Navigating the Tour Circuit Road Show Locations" class="mx-auto img-fluid mb-20">
                    <p>
                        <b class="text-color-yellow">Christell</b>
                        <br>Singer, Salinlahi
                        <br>Opening Performance
                    </p>
                </div>
            </div>
        </div> 
    </section>  
    
    {{-- TRAINING --}}
    <section id="schedule">
        <div class="container text-center ahref-light">
            <div>
                <h2 class="text-color-yellow">ENRICH YOUR KNOWLEDGE IN THE TRADE OF PERFORMING ARTS</h2>
                <div class="incfs-25 mb-30">
                    <b>CLARK</b>●<b>DAPITAN</b>●<b>BOHOL</b>
                </div>
                <p>
                    Elevate your craft and artistry with <b>NAVIGATE THE TOURING CIRCUIT</b>, an intensive capacity-building program designed to empower Filipino performing groups and companies. Sharpen your tour planning skills and develop essential business acumen to conquer the touring circuit.
                </p>
                <h3 class="ktc-title">KEY TOPICS COVERED:</h3>
                <ul class="key-topics-list mb-40">
                    <li>
                        <div>
                            Product Management
                        </div>
                    </li>
                    <li>
                        <div>
                            Marketing
                        </div>
                    </li>
                    <li>
                        <div>
                            Pitching
                        </div>
                    </li>
                    <li>
                        <div>
                            Legal
                        </div>
                    </li>
                    <li>
                        <div>
                            Budgeting
                        </div>
                    </li>
                    <li>
                        <div>
                            Sponsorship
                        </div>
                    </li>
                    <li>
                        <div>
                            Funding
                        </div>
                    </li>
                    <li>
                        <div>
                            Branding
                        </div>
                    </li>
                    <li>
                        <div>
                            Venue Management
                        </div>
                    </li>
                    <li>
                        <div>
                            Logistics
                        </div>
                    </li>
                    <li>
                        <div>
                            Licensing
                        </div>
                    </li>
                    <li>
                        <div>
                            Personnel Management
                        </div>
                    </li>
                </ul>
                <a href="https://bit.ly/3VFwMJR" class="btn-lg cta-register-2 ">
                    <div>REGISTER FOR FREE</div>
                </a> 
                <a href="#moderators" class="btn-lg cta-view-2 scroll-link">
                    <div>VIEW SPEAKERS</div>
                </a>
            </div>
        </div>
    </section>
    {{-- SCHEDULE --}}
    <section class="nopad">
        <div class="container text-center ahref-light">
            <div>
                <h2 class="text-color-yellow mb-10">
                    Navigate the Touring Circuit
                    <br><small class="text-color-white">3-Day Program Schedule</small>
                </h2>
                <!-- <p class="mb-40">
                    <em>This schedule is for all locations:</em> Clark, Dapitan, and Bohol.
                </p> -->
                <br>

                <div id="locationTab">
                    <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="clark-tab" data-toggle="tab" href="#clark-tab-pane" role="tab" aria-controls="clark-tab-pane" aria-selected="true">
                            CLARK
                        </a>
                        </li>
                        <li class="nav-item" role="presentation">
                        <a class="nav-link" id="dapitan-tab" data-toggle="tab" href="#dapitan-tab-pane" role="tab" aria-controls="dapitan-tab-pane" aria-selected="false">
                            DAPITAN
                        </a>
                        </li>
                        <li class="nav-item" role="presentation">
                        <a class="nav-link" id="bohol-tab" data-toggle="tab" href="#bohol-tab-pane" role="tab" aria-controls="bohol-tab-pane" aria-selected="false">
                            BOHOL
                        </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="clark-tab-pane" role="tabpanel" aria-labelledby="clark-tab" tabindex="0">
                        
                        

                            <div class="my-40">
                                <div class="row">
                                    <div class="col-4">
                                        <button class="btn btn-colsched btn_active" type="button" data-toggle="collapse" data-target="#multiCollapseSchedClark1" aria-expanded="true" aria-controls="multiCollapseSchedClark1" id="db_id">
                                            <b>DAY 1</b>
                                        </button>
                                    </div>
                                    <div class="col-4">
                                        <button class="btn btn-colsched" type="button" data-toggle="collapse" data-target="#multiCollapseSchedClark2" aria-expanded="false" aria-controls="multiCollapseSchedClark2" id="ds_id">
                                            <b>DAY 2</b>
                                        </button>
                                    </div>
                                    <div class="col-4">
                                        <button class="btn btn-colsched" type="button" data-toggle="collapse" data-target="#multiCollapseSchedClark3" aria-expanded="false" aria-controls="multiCollapseSchedClark3" id="hs_id">
                                            <b>DAY 3</b>
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <div> 
                                        <div class="activities-holder collapse multi-collapse show" id="multiCollapseSchedClark1">
                                            <div id="schedule-clark-container-day1"></div>
                                        </div>
                                        <div class="activities-holder collapse multi-collapse" id="multiCollapseSchedClark2">
                                            <div id="schedule-clark-container-day2"></div>
                                        </div>
                                        <div class="activities-holder collapse multi-collapse" id="multiCollapseSchedClark3">
                                            <div id="schedule-clark-container-day3"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        


                        </div>
                        <div class="tab-pane fade" id="dapitan-tab-pane" role="tabpanel" aria-labelledby="dapitan-tab" tabindex="0">
                        
                        
                            <div class="my-40">
                                <div class="row">
                                    <div class="col-4">
                                        <button class="btn btn-colsched btn_active" type="button" data-toggle="collapse" data-target="#multiCollapseSchedDapitan1" aria-expanded="true" aria-controls="multiCollapseSchedDapitan1" id="db_id">
                                            <b>DAY 1</b>
                                        </button>
                                    </div>
                                    <div class="col-4">
                                        <button class="btn btn-colsched" type="button" data-toggle="collapse" data-target="#multiCollapseSchedDapitan2" aria-expanded="false" aria-controls="multiCollapseSchedDapitan2" id="ds_id">
                                            <b>DAY 2</b>
                                        </button>
                                    </div>
                                    <div class="col-4">
                                        <button class="btn btn-colsched" type="button" data-toggle="collapse" data-target="#multiCollapseSchedDapitan3" aria-expanded="false" aria-controls="multiCollapseSchedDapitan3" id="hs_id">
                                            <b>DAY 3</b>
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <div> 
                                        <div class="activities-holder collapse multi-collapse show" id="multiCollapseSchedDapitan1">
                                            <div id="schedule-dapitan-container-day1"></div>
                                        </div>
                                        <div class="activities-holder collapse multi-collapse" id="multiCollapseSchedDapitan2">
                                            <div id="schedule-dapitan-container-day2"></div>
                                        </div>
                                        <div class="activities-holder collapse multi-collapse" id="multiCollapseSchedDapitan3">
                                            <div id="schedule-dapitan-container-day3"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        



                        </div>
                        <div class="tab-pane fade" id="bohol-tab-pane" role="tabpanel" aria-labelledby="bohol-tab" tabindex="0">
                        
                        

                            <div class="my-40">
                                <div class="row">
                                    <div class="col-4">
                                        <button class="btn btn-colsched btn_active" type="button" data-toggle="collapse" data-target="#multiCollapseSchedBohol1" aria-expanded="true" aria-controls="multiCollapseSchedBohol1" id="db_id">
                                            <b>DAY 1</b>
                                        </button>
                                    </div>
                                    <div class="col-4">
                                        <button class="btn btn-colsched" type="button" data-toggle="collapse" data-target="#multiCollapseSchedBohol2" aria-expanded="false" aria-controls="multiCollapseSchedBohol2" id="ds_id">
                                            <b>DAY 2</b>
                                        </button>
                                    </div>
                                    <div class="col-4">
                                        <button class="btn btn-colsched" type="button" data-toggle="collapse" data-target="#multiCollapseSchedBohol3" aria-expanded="false" aria-controls="multiCollapseSchedBohol3" id="hs_id">
                                            <b>DAY 3</b>
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <div> 
                                        <div class="activities-holder collapse multi-collapse show" id="multiCollapseSchedBohol1">
                                            <div id="schedule-bohol-container-day1"></div>
                                        </div>
                                        <div class="activities-holder collapse multi-collapse" id="multiCollapseSchedBohol2">
                                            <div id="schedule-bohol-container-day2"></div>
                                        </div>
                                        <div class="activities-holder collapse multi-collapse" id="multiCollapseSchedBohol3">
                                            <div id="schedule-bohol-container-day3"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="my-5" id="moderators">
                <h2 class="text-color-yellow">MODERATED BY</h2>
                <div class="row">
                    <div class="mx-auto col-xs-12 col-sm-5 col-md-3 mt-30 perf-container">
                        <img src="{{ asset('img/static/x_mipam/speakers_moderators/mod_samodio.png') }}" alt="Jill Samodio, Navigating the Tour Circuit Moderator" class="mx-auto img-fluid mb-20">
                        <p>
                            <b class="text-color-yellow">Jill Samodio</b>
                        </p>
                    </div>
                </div>
            </div>
            <div class="my-5">
                <h2 class="text-color-yellow">SPEAKERS</h2>
                <div class="row">
                    <div class="mx-auto col-xs-12 col-sm-3 mt-30 perf-container">
                        <img src="{{ asset('img/static/x_mipam/speakers_moderators/spk_marasigan.png') }}" alt="Dennis Marasigan, speaker for the cretive industry and global market" class="mx-auto img-fluid mb-20">
                        <p>
                            <b class="text-color-yellow">Dennis Marasigan</b>
                            <br>The Creative Industry & Global Market
                        </p>
                    </div>
                    <div class="mx-auto col-xs-12 col-sm-3 mt-30 perf-container">
                        <img src="{{ asset('img/static/x_mipam/speakers_moderators/spk_belarmino.png') }}" alt="Vanini Belarmino, speaker for Charting Alternative Paths: The Future of Performance" class="mx-auto img-fluid mb-20">
                        <p>
                            <b class="text-color-yellow">Vanini Belarmino</b>
                            <br>Charting Alternative Paths:
                            <br>The Future of Performance
                        </p>
                    </div>
                </div>
            </div> --}}
        </div>
    </section>

    <!-- Speakers 2 -->
    <section>
        <div class="container my-5" id="moderators">
                <div class="col-12 text-center">
                    <h2 class="text-color-yellow spk-holder">SPEAKERS</h2>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="spk-container">
                                <img src="{{ asset('img/static/x_mipam/speakers_moderators/Tal%20de%20Guzman.png') }}" alt="speakers" class="mx-auto img-fluid mb-20">
                                <p>
                                    <b class="text-color-yellow">Audience Impact: Branding and Marketing for Arts Organization</b>
                                    <br><b class="text-color-blue">Mastering the Pitch: Storytelling & Pitching Workshop</b>
                                    <br><b>Tal de Guzman</b>
                                    <br>Founder & Designer, Risque Designs 
                                </p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="spk-container">
                                <img src="{{ asset('img/static/x_mipam/speakers_moderators/Franchesca%20Casauay.png') }}" alt="speakers" class="mx-auto img-fluid mb-20">
                                <p>
                                    <b class="text-color-yellow">The Art of Coordination: Production Management & Event Logistics</b>
                                    <br><b>Franchesca Casauay</b>
                                    <br>Independent Producer 
                                </p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="spk-container">
                                <img src="{{ asset('img/static/x_mipam/speakers_moderators/Carmencita%20Bernardo.png') }}" alt="speakers" class="mx-auto img-fluid mb-20">
                                <p>
                                    <b class="text-color-yellow">The Tour Circuit: Planning & Management Essentials</b>
                                    <br><b>Carmencita Bernardo</b>
                                    <br>Department Manager III, CCP Cultural Exchange 
                                </p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="spk-container">
                                <img src="{{ asset('img/static/x_mipam/speakers_moderators/Joey%20Vargas.png') }}" alt="speakers" class="mx-auto img-fluid mb-20">
                                <p>
                                    <b class="text-color-yellow">Case Presentation (Philippine Madrigal Singers)</b>
                                    <br><b>Joey Vargas</b>
                                    <br>Creative Director, Philippine Madrigal Singers 
                                </p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="spk-container">
                                <img src="{{ asset('img/static/x_mipam/speakers_moderators/Andy%20Alviz.png') }}" alt="speakers" class="mx-auto img-fluid mb-20">
                                <p>
                                    <b class="text-color-yellow">Case Presentation (ArtiSta. Rita)</b>
                                    <br><b>Andy Alviz</b>
                                    <br>Director 
                                </p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="spk-container">
                                <img src="{{ asset('img/static/x_mipam/speakers_moderators/Peter%20De%20Vera.png') }}" alt="speakers" class="mx-auto img-fluid mb-20">
                                <p>
                                    <b class="text-color-yellow">Case Presentation (Sinukwan Kapampangan)</b>
                                    <br><b>Peter De Vera</b>
                                    <br>Peter de Vera, Artistic Director, Sinukwan Kapampangan 
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </section>


    {{-- CTA --}}
    <section>
        <div class="container ahref-light comms-cta">
            <div class="row text-center">
                <h2 class="text-color-yellow">THE TOURING CIRCUIT AWAITS YOU</h2>
                <p>
                    Don't miss the chance to enhance your entrepreneurial skills and  business knowledge to seize the opportunities in the global touring market. The capacity-building program will conclude with CREATEPhilippines x Manila International Performing Arts Market (MIPAM) to be held next year.
                </p>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-3 col-md-3 align-center-mobile">
                    <h3 class="text-color-red">For inquiries:</h3>
                </div>
                <div class="col-xs-12 col-sm-5 col-lg-5 mb-30 align-center-mobile">
                    <a href="mailto:artseducation@culturalcenter.gov.ph">artseducation@culturalcenter.gov.ph</a>
                    <br>8 832 1125 local 1710
                    <br><i class="fab fa-facebook"></i> <a href="" target="_blank">culturalcenterofthephilippines</a>
                </div>
                <div class="col-xs-12 col-sm-4 col-lg-4 mb-30 align-center-mobile">
                    <a href="mailto:createph@citem.com.ph">createph@citem.com.ph</a>
                    <br>8 833 1258 local 306
                    <br><i class="fab fa-facebook"></i> <a href="" target="_blank">createphilippines</a>
                </div>
            </div>
        </div>
    </section>
    {{-- FOOTER --}}
    <section class="nopad">
        <div class="container ahref-light">
            <div class="row">
                <div class="col-xs-12 col-sm-5 col-lg-4 cta-socmed">
                    <div>
                        DON'T FORGET TO USE OUR HASHTAG AND FOLLOW US FOR UPDATES
                    </div>
                    <div class="smcta-hash">
                        #CREATEPHxMIPAM
                    </div>
                    <div>
                        <a href="https://www.instagram.com/createphilippines/" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.facebook.com/createphilippines/" target="_blank">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="https://x.com/CreatePHILS" target="_blank">
                            <i class="fab fa-x-twitter"></i>
                        </a>
                        <a href="https://www.linkedin.com/company/create-philippines/?viewAsMember=true" target="_blank">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="https://invite.viber.com/?g2=AQBFxC8QhimCJkzpIaSiO%2Bxwl4FN%2Fb1eGTC7ZQewPJ2SwK1iEMGfZClMJmRpoSWw" target="_blank">
                            <i class="fab fa-viber"></i>
                        </a>
                    </div>
                    <div>
                        <img src="{{ asset('img/static/x_mipam/TheFutureIsCreative.png') }}" alt="the future is creative" class="tfic-img">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-1 col-lg-1">
                    <div class="ksc-border"></div>
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-7 cta-viber">
                    <div>
                        LET'S CREATE TOGETHER
                    </div>
                    <p>
                        Join the CREATEPhilippines Viber Community to meet fellow artists and creatives, learn from experts, and find future partners.
                    </p>
                    <a href="https://invite.viber.com/?g2=AQBFxC8QhimCJkzpIaSiO%2Bxwl4FN%2Fb1eGTC7ZQewPJ2SwK1iEMGfZClMJmRpoSWw" target="_blank">
                        <img src="{{ asset('img/static/x_mipam/createph_viber.webp') }}" alt="Create Philippines Viber Community QR Code" class="viber-qr">
                    </a>
                </div>
            </div>
        </div>
    </section>
    {{-- ORGANIZERS --}}
    <section>
        <div class="container">
            <div class="row text-center">
                <h3>ORGANIZED BY</h3>
                <img src="{{ asset('img/static/x_mipam/organized_by.webp') }}" alt="CITEM logo with Cultural Center of the Philippines" class="mt-30 mb-50 mx-auto orgcoop-logos">
            </div>
            <div class="row text-center mt-50">
                <h3>IN COOPERATION WITH</h3>
                <img src="{{ asset('img/static/x_mipam/in_cooperation_with.webp') }}" alt="Kickoff Rally in Cooperation with UP Manila" class="mt-30 mx-auto orgcoop-logos">
                <img src="{{ asset('img/static/x_mipam/partners_clark.png') }}" alt="Clark Partners" class="mt-30 mx-auto orgcoop-logos">
                <img src="{{ asset('img/static/x_mipam/partners_dapitan.png') }}" alt="Dapitan Partners" class="mt-30 mx-auto orgcoop-logos">
            </div>
        </div>
    </section>
    <hr>
    {{-- MIPAM --}}
    <section class="">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-1"></div>
                <div class="col-xs-12 col-sm-2 px-5 logo-holder-left">
                    {{-- <img src="{{ asset('img/static/x_mipam/mipam_3x.webp') }}" alt="Manila International Performing Arts Market" class="img-fluid logos-mobile-mb"> --}}
                    <img src="{{ asset('img/static/x_mipam/cphxmipam_.webp') }}" alt="Manila International Performing Arts Market" class="img-fluid logos-mobile-mb">
                </div>
                <div class="col-xs-12 col-sm-8 px-5">
                    <p>
                        Organized by CITEM in partnership with CCP, CREATEPhilippines x MIPAM is an intersection of arts and business, bringing together performing arts groups and key industry players for business-matching and networking opportunities. As the culminating event of NAVIGATING THE TOURING CIRCUIT, CREATEPH x MIPAM will showcase the Philippines’ vibrant performing arts scene, featuring talents that are more than ready to take on the world.
                    </p>
                </div>
            </div>
        </div> 
    </section>
    {{-- CTA: Join Creatives Directory --}}
    <section class="nopad">
        <div class="row cta-createivesdir">
            <div>JOIN THE DIGITAL SPACE FOR FILIPINO CREATIVES</div>
        </div>
        <div class="row mostwanted-container">
            <div class="col-xs-12 col-sm-6 col-lg-2 hide-mobile"></div>
            <div class="col-xs-12 col-sm-6 col-lg-4 p-5">
                <img src="{{ asset('img/static/x_mipam/heads_3x.webp') }}" alt="Manila International Performing Arts Market" class="img-fluid">
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4 p-5">
                <div class="most-wntd">MOST WANTED CREATIVES</div>
                <div>
                    <p>
                        Share your artistry alongside other Filipino talents in the CREATEPhilippines Directory of Creatives and be ahead of the curve.
                    </p>
                    <a href="https://createphilippines.com/register/step-1" class="btn-lg cta-register-2" target="_blank">
                        <div>REGISTER NOW*</div>
                    </a>
                </div>
            </div> 
            <div class="p-5 text-end mwc-note">
                <p>
                    <em>
                        *By registering to the Directory of Creatives, you are also signing-up to the CCP Performing Arts Directory.
                    </em>
                </p>
            </div>
        </div>
    </section>
    {{-- CREATEPhilippines --}}
    <section class="">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-1"></div>
                <div class="col-xs-12 col-sm-3 px-5 logo-holder-left">
                    <img src="{{ asset('img/static/x_mipam/cphlogo_2_white.webp') }}" alt="CREATEPhilippines white logo" class="img-fluid logos-mobile-mb">
                </div>
                <div class="col-xs-12 col-sm-7 px-5">
                    <p>
                        CREATEPhilippines is organized by the Center for International Trade Expositions and Missions (CITEM), the export promotion arm of the Philippine Department of Trade and Industry (DTI).
                        <br><br>
                        CREATEPhilippines.com is the country's first government-led content and community platform for the local creative industries. It is the ultimate resource for stories and updates on the Philippines' creative community and a centralized directory and sourcing platform where Filipino creatives can share their portfolio to and engage with a global audience.
                    </p>
                </div>
            </div>
        </div> 
    </section>

{{-- Shapes, outlines, splashes --}}
<div class="ballerina">
    <img src="{{ asset('img/static/x_mipam/abstract/ballet2.png') }}" alt="ballerina outline drawing" class="img-fluid">
</div>
<div class="dancew">
    <img src="{{ asset('img/static/x_mipam/abstract/dancew.png') }}" alt="woman bowing outline drawing" class="img-fluid">
</div>
<div class="dancem">
    <img src="{{ asset('img/static/x_mipam/abstract/dancem2.png') }}" alt="male dancing outline drawing" class="img-fluid">
</div>
<div class="gymnast">
    <img src="{{ asset('img/static/x_mipam/abstract/gymnast2.png') }}" alt="woman dancing outline drawing" class="img-fluid">
</div>


<div class="ylwshp01">
    <img src="{{ asset('img/static/x_mipam/abstract/shp05-y.png') }}" alt="organic yellow shape" class="img-fluid">
</div>
<div class="redshp01">
    <img src="{{ asset('img/static/x_mipam/abstract/red02.png') }}" alt="organic red shape" class="img-fluid">
</div>
<div class="ylwshp02">
    <img src="{{ asset('img/static/x_mipam/abstract/shp03-yellow.png') }}" alt="organic yellow shape" class="img-fluid">
</div>
<div class="grnshp01">
    <img src="{{ asset('img/static/x_mipam/abstract/shp03-green.png') }}" alt="organic green shape" class="img-fluid">
</div>
<div class="blushp01">
    <img src="{{ asset('img/static/x_mipam/abstract/shp01-blue.png') }}" alt="organic blue shape" class="img-fluid">
</div>


<div class="spl01">
    <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl02.png') }}" alt="paint splashes" class="img-fluid">
</div>
<div class="spl01-rev">
    <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl02.png') }}" alt="paint splashes" class="img-fluid">
</div>
<div class="spl02">
    <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl07.png') }}" alt="paint splashes" class="img-fluid">
</div>
<div class="spl02-rev">
    <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl07.png') }}" alt="paint splashes" class="img-fluid">
</div>
<div class="spl03">
    <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl01.png') }}" alt="paint splashes" class="img-fluid">
</div>
<div class="spl03-rev">
    <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl01.png') }}" alt="paint splashes" class="img-fluid">
</div>
<div class="spl04">
    <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl21.png') }}" alt="paint splashes" class="img-fluid">
</div>
<div class="spl05">
    <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl22.png') }}" alt="paint splashes" class="img-fluid">
</div>
<div class="spl06">
    <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl16.png') }}" alt="paint splashes" class="img-fluid">
</div>




@endsection