@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/website/info_page.css?ver=' . time()) }}" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'Nine by Five';
            src: url('/fonts/nine0.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        .press-start-regular {
            font-family: "Press Start 2P", system-ui;
            font-weight: 400;
            font-style: normal;
        }
        
        .work-sans-400 {
            font-family: "Work Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;
        }

        section {
            background-color: #000000;
            padding-left: clamp(20px, 5vw, 80px) !important;
            padding-right: clamp(20px, 5vw, 80px) !important;
        }

        .ps01 {
            font-family: "Press Start 2P", system-ui;
            font-weight: 400;
            font-style: normal;
            font-size: clamp(20px, 3vw, 36px);
        }

        .ps02 {
            font-family: "Press Start 2P", system-ui;
            font-weight: 400;
            font-style: normal;
            font-size: clamp(16px, 2vw, 32px);
        }

        .nf01 {
            font-family: "Nine by Five", system-ui;
            font-weight: 400;
            font-style: normal;
            font-size: clamp(25px, 2vw, 40px);
            letter-spacing: 2px;

        }

        .ws01 {
            font-family: "Work Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;
            font-size: clamp(16px, 1.5vw, 20px);
        }

        .ws02 {
            font-family: "Work Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;
            font-size: 15px;
        }

        .ws03 {
            font-family: "Work Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;
            font-size: clamp(14px, 1.5vw, 20px);
        }

        /* Gradient 1 */
        .details-bordered .container {
            position: relative;
            z-index: 1;
            background: white;
            padding: .1rem .8rem;
            border-radius: 20px;
        }

        .details-bordered .container::before {
            content: "";
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            z-index: -1;
            background: linear-gradient(270deg, #4DFF00, #4DFF00, #009E65);
            /* background: linear-gradient(270deg,rgb(176, 255, 142), #4DFF00, #009E65); */
            background-size: 400% 400%;
            animation: borderAnimation 5s ease infinite;
            border-radius: 20px;
        }
        /* Gradient 1 End */

        .details-bordered .container .row {
            background-color: #000000;
            border-radius: 20px;
            padding: 3rem;
        }

        .small-text .container {
            max-width: 1000px;
        }

        .gif-card .container {
            background-color: #CBD7CB;
            padding: clamp(30px, 0.5vw, 30px);
        }

        /* Gradient 2 */
        .gif-card .container .gif-container {
            position: relative;
            z-index: 1;
            padding: .5rem .5rem;
        }

        .gif-card .container .gif-container::before {
            content: "";
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            z-index: -1;
            background: linear-gradient(270deg, #009E65, #4DFF00, #009E65);
            /* background: linear-gradient(270deg,rgb(176, 255, 142), #4DFF00, #009E65); */
            background-size: 400% 400%;
            animation: borderAnimation 5s ease infinite;
        }
        /* Gradient 2 End */

        .gif-card .container .text-container {
            color: #000000;
            padding: clamp(15px, 0.5vw, 30px); 
        }


        /* Button Gradient 1 */
        .gif-card .btn-container, .bottom-btns .btn-container {
            position: relative;
            z-index: 1;
            padding: 0.25rem;
            display: inline-block;
            border-radius: 8px;

            height: 100%;
            max-width: 600px;
            width: 100%;
        }

        .gif-card .btn-container::before, .bottom-btns .btn-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -1;
            border-radius: 25px;
            background: linear-gradient(270deg, #009E65, #4DFF00, #009E65);
            /* background: linear-gradient(270deg,rgb(176, 255, 142), #4DFF00, #009E65); */
            background-size: 400% 400%;
            animation: borderAnimation 5s ease infinite;
        }

        .gif-card .btn-container a, .bottom-btns .btn-container a {
            display: inline-block;
            padding: 15px 15px;
            background: #000000;
            border: 1px solid #000000;
            color: #FFFFFF;
            text-decoration: none;

            border-radius: 20px;
            position: relative;
            z-index: 1;
            
            font-family: "Work Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: bold;
            font-style: normal;
            font-size: clamp(20px, 0.5vw, 26px);

            height: 100%;
            width: 100%;
            

            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .gif-card .btn-container a:hover, .bottom-btns .btn-container a:hover {
            background-color: transparent;
            color: #FFFFFF;
            border: 1px solid transparent;
        }
        /* Button Gradient 1 End */
        

        .features .card-container {
            margin-bottom: 25px;
        }

        .features .card-container .card {
            background-color: #000000;
            border-width: clamp(1px, 0.5vw, 3px);
            border-style: solid;
            border-color: #00FF00;
            border-radius: 30px;
            height: 100%;
        }

        .features .card-container .card img {
            border-top-left-radius: 30px;
            border-top-right-radius: 30px;

        }

        .features .card-container .card .card-body {
            border-top: clamp(1px, 0.5vw, 3px) solid #00FF00;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            text-align: center;
            flex-direction: column;

            text-transform: uppercase;
        }

        .spinner-icon {
            z-index: 10;
            pointer-events: none;
        }

        .lazy-load.loaded + .spinner-icon {
           display: none;
        }
        /* Animation */
        @keyframes borderAnimation {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
    </style>
@endsection

@section('scripts-bottom')
    <script>

        window.addEventListener('load', function () {
            const lazyElements = document.querySelectorAll('.lazy-load');
            let index = 0;

            function loadNext() {
                if (index >= lazyElements.length) return;

                const el = lazyElements[index];
                const src = el.getAttribute('data-src');
                if (!src) {
                    index++;
                    loadNext();
                    return;
                }

                // Set the src to start loading the image
                el.src = src;

                // Listen for load event on the actual img element
                el.onload = function () {
                    el.classList.add('loaded');

                    // Remove spinner in the same container
                    const spinner = el.parentElement.querySelector('.spinner-icon');
                    if (spinner) {
                        spinner.style.display = 'none'; // or spinner.remove();
                    }

                    index++;
                    loadNext();
                };

                el.onerror = function () {
                    const spinner = el.parentElement.querySelector('.spinner-icon');
                    if (spinner) {
                        spinner.style.display = 'none';
                    }

                    index++;
                    loadNext();
                };
            }

            loadNext();
        });
    </script>
@endsection

@section('content')
    {{-- BANNER --}}
    <section class="p-0">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">
                    <img class="w-100 banner-img" src="{{ asset('img/static/2025_PGDX/Rectangle_90.png') }}" alt="CREATEPhilippines x PGDX logo">
                </div>
            </div>
        </div>
    </section>

    <section class="p-3" style="padding-top: 60px !important;">
        <div class="container mb-3">
            <div class="row">
                <div class="col-12 text-center mb-3">
                    <span class="ps01">
                        Ready to level up?
                    </span>
                </div>
                <div class="col-12 text-center">
                    <span class="ws01">
                        Calling all game players and developers: The Philippine GameDev Expo returns for its third year even bigger and better! The country's premier expo that champions the Philippines game development industry is teaming up with CREATEPhilippines as its official event partner to give everyone a record-breaking experience.
                    </span>
                </div>
            </div>

        </div>
    </section>

    <section class="details-bordered">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-2">
                    <span class="ps01">JULY 25 - 27, 2025</span>
                </div>
                <div class="col-12 text-center">
                    <span class="ps01">SMX CONVENTION CENTER, MANILA</span>
                </div>
                <div class="col-12 text-center">
                    <span class="nf01">10:00 AM - 7:00 PM | FUNCTION ROOMS 3-5</span>
                </div>
            </div>
        </div>
    </section>

    <section class="small-text pt-0 pb-0">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <span class="ws01">Come in your best cosplay! Discover the latest indie games and the newest AAA titles! Attend learning sessions, and get a boost through networking and business opportunities!</span>
                </div>
            </div>
        </div>
    </section>

    <section class="gif-card">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6 gif-container">
                    <!-- <img 
                        class="lazy-load w-100" 
                        src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" 
                        data-src="{{ asset('img/static/2025_PGDX/pgdx_2025_gif.gif') }}" 
                        alt="..." 
                        loading="lazy"> -->

                    <img 
                        class="lazy-load w-100"
                        data-src="{{ asset('img/static/2025_PGDX/pgdx_2025_gif.gif') }}" 
                        src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" 
                        alt="Image gif">

                    <i class="fas fa-spinner fa-spin fa-2x text-muted position-absolute top-50 start-50 translate-middle spinner-icon"></i>
                </div>
                <div class="col-12 col-lg-6 align-content-center">
                    <div class="row">
                        <div class="col-12 text-container text-center">
                            <span class="ps02">CATCH CREATEPHILIPPINES AT PGDX 2025!</span>
                        </div>
                        <div class="col-12 text-container text-center pt-0">
                            <p class="ws01">Visit the CREATEPhilippines booth at the expo where you can play games and win exclusive merchandise.</p>
                            <p class="ws01">You also get more than just a 1-up, thanks to the CREATEPhilippines-hosted Meeting Area and Business Matching Hub. Here, game developers, publishers, investors, and industry stakeholders can meet and network to explore exciting new avenues together. </p>
                        </div>
                        <div class="col-12 text-center mt-2">
                            <div class="btn-container">
                                <a href="https://tickets.pgdx.ph/"  class="btn btn-primary" target="_blank" rel="noopener noreferrer">Get your tickets here</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-6 col-md-4 card-container">
                    <div class="card">
                        <img src="{{ asset('img/static/2025_PGDX/Frame_1.png') }}" alt="">
                        <div class="card-body">
                            <span class="ws03">Game / Product Showcase</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 card-container">
                    <div class="card">
                        <img src="{{ asset('img/static/2025_PGDX/Frame_2.png') }}" alt="">
                        <div class="card-body">
                            <span class="ws03">Community Gathering</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 card-container">
                    <div class="card">
                        <img src="{{ asset('img/static/2025_PGDX/Frame_3.png') }}" alt="">
                        <div class="card-body">
                            <span class="ws03">B2B/ B2C OPPORTUNITIES</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 card-container">
                    <div class="card">
                        <img src="{{ asset('img/static/2025_PGDX/Frame_4.png') }}" alt="">
                        <div class="card-body">
                            <span class="ws03">Cosplay</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 card-container">
                    <div class="card">
                        <img src="{{ asset('img/static/2025_PGDX/Frame_5.png') }}" alt="">
                        <div class="card-body">
                            <span class="ws03">Local / International Game Development</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 card-container">
                    <div class="card">
                        <img src="{{ asset('img/static/2025_PGDX/Frame_6.png') }}" alt="">
                        <div class="card-body">
                            <span class="ws03">Workshops and Conference</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 card-container">
                    <div class="card">
                        <img src="{{ asset('img/static/2025_PGDX/Frame_7.png') }}" alt="">
                        <div class="card-body">
                            <span class="ws03">Sales and Services</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 card-container">
                    <div class="card">
                        <img src="{{ asset('img/static/2025_PGDX/Frame_8.png') }}" alt="">
                        <div class="card-body">
                            <span class="ws03">WEB 3.0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="p-3">
        <div class="container mb-3">
            <div class="row">
                <div class="col-12 text-center mb-3">
                    <span class="ps01" style="line-height: 1.5em;">
                        DISCOVER. CONNECT. COLLABORATE WITH FILIPINO GAME CREATORS!
                    </span>
                </div>
                <div class="col-12 text-center">
                    <p class="ws01">Calling all game publishers, studios, founders, and industry leaders! Don’t miss the chance to discover the innovation and talent of Filipino game developers at PGDX!</p>
                    <p class="ws01">Set a meeting with PGDX exhibitors by creating your account through the Business Matching System below:</p>
                </div>
            </div>

        </div>
    </section>

    <section class="bottom-btns pt-1 pb-1">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 text-end mb-3">
                    <div class="btn-container">
                        <a href="https://b2b.pgdx.ph" target="_blank" class="btn btn-primary" rel="noopener noreferrer">Register and book a meeting</a>
                    </div>
                </div>
                <div class="col-12 col-md-6 text-start mb-3">
                    <div class="btn-container">
                        <a href="https://tickets.pgdx.ph/" class="btn btn-primary" target="_blank" rel="noopener noreferrer">Get your tickets here</a>
                         
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="small-text pt-3 pb-2">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <span class="ws01"><i>Event tickets are required to access the Expo floor and Meeting Area.</i></span>
                </div>
            </div>
        </div>
    </section>
@endsection
