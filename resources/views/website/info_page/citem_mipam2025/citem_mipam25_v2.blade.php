@extends('layouts.app')

@section('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link href="{{ asset('css/website/info_page.css?ver=' . time()) }}" rel="stylesheet">
    <style>
        .tbl-mipam {
            width: 100%;
            background: rgb(33, 124, 205);
            border-radius: 20px;
        }

        .tbl-mipam thead tr th {
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .tbl-mipam tr td:first-child {
            width: 30%;
        }

        .tbl-mipam tr td:last-child {
            width: 70%;
        }

        .tbl-mipam tr:last-child td:first-child {
            border-bottom-left-radius: 20px;
        }

        .tbl-mipam tr:last-child td:last-child {
            border-bottom-right-radius: 20px;
        }

        .tbl-mipam tr td {
            padding: 7px 6px;
        }

        .tbl-mipam tr.alt-1 td {
            background: rgb(33, 142, 238);
        }

        .tbl-mipam tr.alt-2 td {
            background: rgb(33, 124, 205);
        }

        .fullBanner {
            z-index: 1;

        }

        .orgcoop-logos-2 {
            height: 120px !important;
            width: auto !important;
        }

        #schedule {
            width: 100%;
        }

        .carousel-inner {
            border-radius: 24px;
        }

        .carousel-section {
            padding-top: 0px !important;
        }
    </style>
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
            if (!$(this).hasClass('active')) {
                $tab = $(this).attr('id');
                if ($tab == 'clark-tab') {
                    $('#locationTab #clark-tab-pane #db_id').click();
                } else if ($tab == 'dapitan-tab') {
                    $('#locationTab #dapitan-tab-pane #db_id').click();
                } else if ($tab == 'bohol-tab') {
                    $('#locationTab #bohol-tab-pane #db_id').click();
                }
            }
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
    {{-- !!!!! VERSION 2: UPDATED FOR LEG 2 !!!!! --}}
    {{-- BANNER --}}
    <section class="fullBanner">
        <div class="container-fluid text-center ahref-light">
            <img src="{{ asset('img/static/x_mipam/cphxmipam_.webp') }}" alt="CREATEPhilippines x MIPAM logo"
                class="mx-auto cxm-bannerlogo">
            <br>
            <div class="event-year">2025</div>

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
                <a href="https://citem.ph/p/5ae656" class="btn-lg cta-register" target="_blank">
                    <div>REGISTER FOR PHASE II LEG 2 NOW</div>
                </a>
            </div>
    </section>
    {{-- LOCATIONS --}}
    {{-- PARALLAX VIDEO --}}
    <div class="video-container d-flex align-items-center justify-content-center">
        <video autoplay muted loop id="banner-video">
            <!-- Replace 'your-video.mp4' with your video file -->
            <source src="{{ asset('img/static/x_mipam/createxmipam.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="overlay"></div>
        <div class="content">

            <section id="schedule">
                <div class="container text-center ahref-light">
                    <div>
                        <h2 class="text-color-yellow mt-3">ENRICH YOUR SKILLS IN THE TRADE OF PERFORMING ARTS </h2>
                        <br>
                        <p>
                            Following the successful completion of Phase I in 2024—which began in Manila and extended to
                            regional
                            stops in Clark, Dapitan, and Bohol—CREATEPhilippines is moving forward with its next stage.
                        </p>
                        <p>
                            Building on the strong foundation established in the earlier legs, the second phase will feature
                            intensive workshops designed to enhance pitching techniques and client engagement skills.
                        </p>
                        <p>
                            This program seeks to prepare our Philippine Performing Arts Groups to do business with local
                            and
                            international clients to be invited during the CREATEPhilippines X Manila International
                            Performing Arts
                            Market in 2026 and beyond.
                        </p>
                        <br>
                        <h2 class="text-color-yellow">
                            <br><small class="text-color-white">PHASE II LEG 2 2025</small>
                        </h2>
                        <span>*ALL SESSIONS WILL BE DONE THROUGH ZOOM</span>
                        <p>
                        <table class="tbl-mipam">
                            <thead>
                                <tr>
                                    <th colspan="2">MUSIC SUPERVISION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="alt-1">
                                    <td>March 18<br>3:00 - 6:30pm</td>
                                    <td>Setting the Stage, Market Research Essentials</td>
                                </tr>
                                <tr class="alt-2">
                                    <td>March 20<br>3:00 - 6:30pm</td>
                                    <td>Defining Your Ideal Customer, Attracting Clients Using Storytelling</td>
                                </tr>
                                <tr class="alt-1">
                                    <td>March 24<br>3:00 - 6:30pm</td>
                                    <td>Building Your Pitch Portfolio, Engaging Your Audience</td>
                                </tr>
                                <tr class="alt-2">
                                    <td>March 26<br>3:00 - 6:30pm</td>
                                    <td>Final Pitches and Feedback, Q&A with International Panelists</td>
                                </tr>
                            </tbody>

                        </table>
                        </p>
                        <h3 class="ktc-title">NEXT LEG: JUNE </h3>
                        <span>Navigate the Touring Circuit Phase II</span>
                        <br><br>
                        <a href="https://citem.ph/p/5ae656" class="btn-lg cta-register" target="_blank">
                            <div>Secure your spot for the Leg 2 sessions Now</div>
                        </a>

                    </div>
                </div>
            </section>
            {{-- <div class="rs-container">
                <img src="{{ asset('img/static/x_mipam/ntc-loc3x.png') }}" alt="Navigating the Tour Circuit Road Show Locations" class="mx-auto img-fluid">
            </div> --}}
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
            <img src="{{ asset('img/static/x_mipam/abstract/shp01-orange.png') }}" alt="organic blue shape"
                class="img-fluid">
        </div>
        <div class="redshp02">
            <img src="{{ asset('img/static/x_mipam/abstract/shp01-red.png') }}" alt="organic red shape" class="img-fluid">
        </div>
        <div class="note01">
            <img src="{{ asset('img/static/x_mipam/abstract/drawings/note.png') }}" alt="musical note outline drawing"
                class="img-fluid">
        </div>
        <div class="bulb01">
            <img src="{{ asset('img/static/x_mipam/abstract/drawings/bulb.png') }}" alt="bulb outline drawing"
                class="img-fluid">
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
            <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl01.png') }}" alt="paint splashes"
                class="img-fluid">
        </div>
    </section>

    <section class="carousel-section">

        <div class="row d-flex justify-content-center">
            <div class="col-lg-8 col-md-11 col-sm-11">



            </div>
        </div>
    </section>
    {{-- TRAINING --}}
    <section id="schedule">
        <div class="container text-center ahref-light">
            <div>
                <h2 class="text-color-yellow">Check Out the Results of Past Legs
                    <br><br><small class="text-color-white">PHASE I 2024</small>
                </h2>
                <br>
                <h4>MANILA: Kickoff July 11 2024 </h4>
                <h4>CLARK: Learning Session July 28-30, 2024 </h4>
                <h4>BOHOL: Learning Session August 28-30, 2024 </h4>
                <br>
                <div class="row leg-1">
                    <div class="col-lg-4 col-sm-12">
                        <h2>564</h2>
                        <p>PARTICIPANTS</p>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <h2>9</h2>
                        <p>TOPICS</p>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <h2>9</h2>
                        <p>SPEAKERS</p>
                    </div>
                </div>

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
                {{-- <a href="https://bit.ly/3VFwMJR" class="btn-lg cta-register-2 ">
                    <div>REGISTER FOR FREE</div>
                </a>
                <a href="#moderators" class="btn-lg cta-view-2 scroll-link">
                    <div>VIEW SPEAKERS</div>
                </a> --}}
                <h2 class="text-color-yellow">
                    <small class="text-color-white">PHASE II Leg 1 2025</small>
                </h2>
                <br>
                <h4>PASAY: Intensive Learning Session January 30-31, 2025</h4>
                <br>
                
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2096.png') }}"
                                alt="First slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2095.png') }}"
                                alt="Second slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2094.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2093.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2092.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2091.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2090.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2089.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2088.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2082.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2078.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2077.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2075.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2074.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2073.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2072.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2071.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2069.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2068.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2063.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2061.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2058.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2055.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2052.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2050.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2048.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2044.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2041.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2040.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2039.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%2037.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20178.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20177.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20176.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20175.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20174.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20173.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20172.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20171.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">

                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20170.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20169.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20168.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20167.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20166.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20165.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20164.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20163.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20162.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20161.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20160.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20159.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20158.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20156.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20154.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20153.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20150.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20148.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20146.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20145.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20144.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20142.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20141.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20140.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20139.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20136.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="{{ asset('img/static/x_mipam2025/carousel_img/Frame%20133.png') }}"
                                alt="CreatePhilippinesxMIPAM02025">
                        </div>
                    </div>


                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <br>
                <p>Thank you for joining us at the previous legs of Navigate the Touring Circuit! Continue elevating your
                    career in the performing arts by participating in our next training sessions.</p>
                <div>
                    <a href="https://createphilippines.com/createph-x-mipam/gallery" class="btn-lg cta-view scroll-link">
                        <div>VIEW GALLERY</div>
                    </a>
                    <a href="https://citem.ph/p/5ae656" class="btn-lg cta-register" target="_blank">
                        <div>REGISTER FOR PHASE II LEG 2 NOW</div>
                    </a>

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
                    Don't miss the chance to enhance your entrepreneurial skills and business knowledge to seize the
                    opportunities in the global touring market. The capacity-building program will conclude with
                    CREATEPhilippines x Manila International Performing Arts Market (MIPAM) to be held next year.
                </p>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-3 col-md-3 align-center-mobile">
                    <h3 class="text-color-red">For inquiries:</h3>
                </div>
                <div class="col-xs-12 col-sm-5 col-lg-5 mb-30 align-center-mobile">
                    <a href="mailto:artseducation@culturalcenter.gov.ph">artseducation@culturalcenter.gov.ph</a>
                    <br>8 832 1125 local 1710
                    <br><i class="fab fa-facebook"></i> <a href=""
                        target="_blank">culturalcenterofthephilippines</a>
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
                        <a href="https://invite.viber.com/?g2=AQBFxC8QhimCJkzpIaSiO%2Bxwl4FN%2Fb1eGTC7ZQewPJ2SwK1iEMGfZClMJmRpoSWw"
                            target="_blank">
                            <i class="fab fa-viber"></i>
                        </a>
                    </div>
                    <div>
                        <img src="{{ asset('img/static/x_mipam/TheFutureIsCreative.png') }}" alt="the future is creative"
                            class="tfic-img">
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
                        Join the CREATEPhilippines Viber Community to meet fellow artists and creatives, learn from experts,
                        and find future partners.
                    </p>
                    <a href="https://invite.viber.com/?g2=AQBFxC8QhimCJkzpIaSiO%2Bxwl4FN%2Fb1eGTC7ZQewPJ2SwK1iEMGfZClMJmRpoSWw"
                        target="_blank">
                        <img src="{{ asset('img/static/x_mipam/createph_viber.webp') }}"
                            alt="Create Philippines Viber Community QR Code" class="viber-qr">
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
                <div class="d-flex justify-content-center align-items-center">
                    <img src="{{ asset('img/static/x_mipam2025/organized.png') }}"
                        alt="CITEM logo with Cultural Center of the Philippines" class=" orgcoop-logos me-3">
                    <img src="{{ asset('img/static/x_mipam2025/SONIK%20Logo.png') }}"
                        alt="CITEM logo with Cultural Center of the Philippines" class="orgcoop-logos-2 sonik m-0 p-0">
                </div>
            </div>
            {{-- <div class="row text-center mt-50">
                <h3>IN COOPERATION WITH</h3>
                <img src="{{ asset('img/static/x_mipam/in_cooperation_with.webp') }}"
                    alt="Kickoff Rally in Cooperation with UP Manila" class="mt-30 mx-auto orgcoop-logos">
                <img src="{{ asset('img/static/x_mipam/partners_clark.png') }}" alt="Clark Partners"
                    class="mt-30 mx-auto orgcoop-logos">
                <img src="{{ asset('img/static/x_mipam/partners_dapitan.png') }}" alt="Dapitan Partners"
                    class="mt-30 mx-auto orgcoop-logos">
            </div> --}}
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
                    <img src="{{ asset('img/static/x_mipam/cphxmipam_.webp') }}"
                        alt="Manila International Performing Arts Market" class="img-fluid logos-mobile-mb">
                </div>
                <div class="col-xs-12 col-sm-8 px-5">
                    <p>
                        Organized by CITEM in partnership with CCP, CREATEPhilippines x MIPAM is an intersection of arts and
                        business, bringing together performing arts groups and key industry players for business-matching
                        and networking opportunities. As the culminating event of NAVIGATING THE TOURING CIRCUIT, CREATEPH x
                        MIPAM will showcase the Philippines’ vibrant performing arts scene, featuring talents that are more
                        than ready to take on the world.
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
                <img src="{{ asset('img/static/x_mipam/heads_3x.webp') }}"
                    alt="Manila International Performing Arts Market" class="img-fluid">
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4 p-5">
                <div class="most-wntd">MOST WANTED CREATIVES</div>
                <div>
                    <p>
                        Share your artistry alongside other Filipino talents in the CREATEPhilippines Directory of Creatives
                        and be ahead of the curve.
                    </p>
                    <a href="https://createphilippines.com/register/step-1" class="btn-lg cta-register-2"
                        target="_blank">
                        <div>REGISTER NOW*</div>
                    </a>
                </div>
            </div>
            <div class="p-5 text-end mwc-note">
                <p>
                    <em>
                        *By registering to the Directory of Creatives, you are also signing-up to the CCP Performing Arts
                        Directory.
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
                    <img src="{{ asset('img/static/x_mipam/cphlogo_2_white.webp') }}" alt="CREATEPhilippines white logo"
                        class="img-fluid logos-mobile-mb">
                </div>
                <div class="col-xs-12 col-sm-7 px-5">
                    <p>
                        CREATEPhilippines is organized by the Center for International Trade Expositions and Missions
                        (CITEM), the export promotion arm of the Philippine Department of Trade and Industry (DTI).
                        <br><br>
                        CREATEPhilippines.com is the country's first government-led content and community platform for the
                        local creative industries. It is the ultimate resource for stories and updates on the Philippines'
                        creative community and a centralized directory and sourcing platform where Filipino creatives can
                        share their portfolio to and engage with a global audience.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Shapes, outlines, splashes --}}
    <div class="ballerina">
        <img src="{{ asset('img/static/x_mipam/abstract/ballet2.png') }}" alt="ballerina outline drawing"
            class="img-fluid">
    </div>
    <div class="dancew">
        <img src="{{ asset('img/static/x_mipam/abstract/dancew.png') }}" alt="woman bowing outline drawing"
            class="img-fluid">
    </div>
    <div class="dancem">
        <img src="{{ asset('img/static/x_mipam/abstract/dancem2.png') }}" alt="male dancing outline drawing"
            class="img-fluid">
    </div>
    <div class="gymnast">
        <img src="{{ asset('img/static/x_mipam/abstract/gymnast2.png') }}" alt="woman dancing outline drawing"
            class="img-fluid">
    </div>


    <div class="ylwshp01">
        <img src="{{ asset('img/static/x_mipam/abstract/shp05-y.png') }}" alt="organic yellow shape" class="img-fluid">
    </div>
    <div class="redshp01">
        <img src="{{ asset('img/static/x_mipam/abstract/red02.png') }}" alt="organic red shape" class="img-fluid">
    </div>
    <div class="ylwshp02">
        <img src="{{ asset('img/static/x_mipam/abstract/shp03-yellow.png') }}" alt="organic yellow shape"
            class="img-fluid">
    </div>
    <div class="grnshp01">
        <img src="{{ asset('img/static/x_mipam/abstract/shp03-green.png') }}" alt="organic green shape"
            class="img-fluid">
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
        <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl01.png') }}" alt="paint splashes"
            class="img-fluid">
    </div>
    <div class="spl03-rev">
        <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl01.png') }}" alt="paint splashes"
            class="img-fluid">
    </div>
    <div class="spl04">
        <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl21.png') }}" alt="paint splashes"
            class="img-fluid">
    </div>
    <div class="spl05">
        <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl22.png') }}" alt="paint splashes"
            class="img-fluid">
    </div>
    <div class="spl06">
        <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl16.png') }}" alt="paint splashes"
            class="img-fluid">
    </div>
@endsection
