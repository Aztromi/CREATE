@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/website/info_page.css?ver=' . time()) }}" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

<style>
    section {
        font-family: "Lato", sans-serif;
        font-style: normal;
        font-optical-sizing: auto;
        font-weight: 400;
        width: 100% !important;
    }

    .h01 {
        font-family: "Lato", sans-serif;
        font-optical-sizing: auto;
        font-weight: 800;
        font-style: normal;
        font-size: clamp(30px, 5vw, 38px);
        color: white;
    }

    .a01 {
        font-family: "Lato", sans-serif;
        font-optical-sizing: auto;
        font-weight: 800;
        font-style: normal;
        font-size: clamp(30px, 5vw, 38px);
        color: #334E45;
        text-align: center;
    }

    .h03 {
        color: #E3F797;
    }

    .h02 {
        font-family: "Lato", sans-serif !important;
        font-optical-sizing: auto;
        font-weight: 600;
        font-style: normal;
        font-size: clamp(20px, 5vw, 28px);
        color: #334E45;
    }

    .h04 {
        font-family: "Lato", sans-serif !important;
        font-optical-sizing: auto;
        font-weight: 600;
        font-style: normal;
        font-size: clamp(30px, 5vw, 38px);
        color: #F876F0;
    }

    .p01 {
        font-family: "Lato", sans-serif !important;
        font-optical-sizing: auto;
        font-weight: 400;
        font-style: normal;
        font-size: 28px;
        color: #B982BC;
    }

    .p02 {
        font-family: "Lato", sans-serif !important;
        font-optical-sizing: auto;
        font-weight: 400;
        font-style: normal;
        font-size: 20px;
        color: #334E45;
    }

    .p03 {
        font-family: "Lato", sans-serif !important;
        font-optical-sizing: auto;
        font-weight: 400;
        font-style: normal;
        font-size: 20px;
        color: #F876F0;
    }

    .banner {
        background-color: #334E45;
    }

    .header1 {
        background-color: #ECDBD3;
    }

    .header2 {
        background-color: #F8C3A0;
    }

    .header3 {
        background-color: #334E45;
    }

    .header4 {
        background-color: #ECDBD3;
    }

    .header5 {
        background-color: #334E45;
    }

    .header6 {
        background: linear-gradient(to right, #A2CBD4, #E18066);
    }

    .button {
        background-color: #B982BC;
        color: #ECDBD3;
        padding: 20px 55px 20px 55px;
        border: 2px solid transparent;
        box-shadow: #334E45;
        top: 0;
    }

    .button1 {
        background-color: transparent;
        text-decoration: none;
        color: black;
        padding: 20px 55px 20px 55px;
        border: 2px solid black;
        border-color: black;
        box-shadow: #334E45;
    }

    .button2 {
        background-color: #F8C3A0;
        text-decoration: none;
        color: black;
        padding: 20px 55px 20px 55px;
        border: 2px solid transparent;
        box-shadow: #334E45;
    }

    .button3 {
        background-color: #B982BC;
        color: #ECDBD3;
        padding: 20px 55px 20px 55px;
        border: 2px solid transparent;
        box-shadow: #334E45;
        top: 0;
    }



    .button:hover {
        background-color: transparent;
        text-decoration: none;
        color: black;
        padding: 20px 55px 20px 55px;
        border: 2px solid black;
        border-color: black;
        box-shadow: #334E45;
    }

    .button1:hover {
        border: 2px solid transparent;
        background-color: #A2CBD4;
        color: black;

    }

    .button2:hover {
        background-color: transparent;
        border: 2px solid black;
        color: black;

    }


    .button3:hover {
        background-color: transparent;
        border: 2px solid whitesmoke;
        color: whitesmoke;
    }
</style>
@endsection

@section('scripts-bottom')
<!-- <script>
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

    </script> -->

@endsection

@section('content')
{{-- BANNER --}}
<section class="banner">
    <div class="w-100 h-100 p-lg-5 d-flex flex-column justify-content-center">
        <div class="container">
            <div class="d-flex flex-column flex-lg-row mb-4">
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-6 col-md-8 col-lg-12">
                            <img class="img-fluid img-md-thumbnail" src="{{ asset('img/static/2026_BMC/BMC-img-2.png') }}" alt="2026_BMC" loading="lazy">
                        </div>
                        <div class="col-6 col-md-4 d-lg-none">
                            <img class="img-fluid img-md-thumbnail" src="{{ asset('img/static/2026_BMC/BMC-img-4.png') }}" alt="2026_BMC" loading="lazy">
                        </div>
                    </div>

                    <div class="h-50 mt-5 px-4 d-flex flex-column justify-content-lg-center">
                        <p class="fs-1 lh-sm fw-bold">
                            UNITE AT BANGKOK MUSIC CITY 2026:<br>
                            GLOBAL MUSIC, ONE STAGE
                        </p>
                        <p class="h03 fs-2">
                            Experience Thailand as your creative stage and witness the Philippines
                            step into the spotlight at Bangkok Music City 2026
                        </p>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-flex">
                    <img class="img-fluid" src="{{ asset('img/static/2026_BMC/BMC-img-3.png') }}" alt="2026_BMC" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>
{{-- HEADER TEXT --}}
<section class="header1 d-flex flex-column">
    <p class="my-3 p01 text-center">
        Bangkok Music City 2026
    </p>
    <h1 class="mt-5 a01 text-center">A Vibrant Fusion of Cultures,<br>
        Celebrating the World Through Sound
    </h1>
    <div class="container-lg my-4">
        <p class="p02 text-center px-5">
            Remarkable talent is set to electrify Bangkok’s stage as Bangkok Music City (BMC) returns on <strong>January 24–25, 2026</strong>, bringing together artists from around the world to celebrate the unifying power of music. With over 70 performers lined up, there’s no shortage of inspiration, innovation, and discovery.
            <br>
            <br>
            Take advantage of Thailand’s biggest music festival and conference to elevate your artistry and build game-changing connections that could spark your next breakthrough.
        </p>
    </div>
    <div class="my-3 d-flex align-items-center justify-content-center">
        <button type="button" class="button rounded-2">Find out more</button>
    </div>
</section>
{{-- HEADER TEXT --}}
<section class="header2 d-flex flex-column justify-content-center">
    <h1 class="mt-5 mx-2 a01 text-center">
        Filipinos Bring the Heat to Bangkok’s Music Fest
    </h1>
    <div class="container-lg my-4">
        <p class="p02">
            A strong platform for both creative expression and business growth is essential for any artist’s career, and Bangkok Music City is the right place for this. As the <strong>Charoenkrung Creative District</strong> becomes a gateway for collaboration, performance, and industry exchange, the Philippines is taking a major step toward strengthening its presence in Southeast Asian music.
            <br>
            <br>
            For the first time, the country will join Bangkok Music City through an official, country-led delegation under <Strong>CREATEPhilippines.</Strong> Through CITEM’s partnership with BMC, this initiative opens new opportunities for Filipino artists to showcase their talent, build international networks, and access regional and global markets.
        </p>
    </div>
</section>

<!-- {{-- ART SUBMISSION --}}
    <section class="p-0 artsubmission d-flex flex-column justify-content-center">
        <div class="container">
            <img class="w-100" src="{{ asset('img/static/2026_BMC/BMC-img.png') }}" alt="2026_BMC" loading="lazy">
        </div>
    </section> -->

{{-- OPPORTUNITIES --}}
<section class="header4 d-flex flex-column justify-content-center">
    <div class="container my-4">
        <h1 class="a01">Access Artist Opportunities with CREATEPhilippines</h1>
        <p class="p02">Joining the official Philippine delegation opens the door to a range of opportunities designed to elevate your career, expand your network, and immerse you in the Asian music landscape. Here’s a closer look at what awaits artists:</p>
    </div>
    <div class="container text-center mt-4">
        <div class="row">
            <div>
                <img class="img-fluid rounded-3"
                    src="{{ asset('img/static/2026_BMC/BMC-img-7.png') }}"
                    alt="2026_BMC"
                    loading="lazy">
                <p class="p03 text-start mt-2">
                    Source: @muri.music @tedorsenado.photo
                </p>
            </div>
            @php
            $content = [
            [
            "title" => "B2B Interactions & Networking",
            "description" => [
            "Connect with international counterparts in curated roundtable sessions",
            "Speak on panels and join global conversations",
            "Engage in business matching and pitching sessions with agencies, buyers, and industry partners"
            ]
            ],
            [
            "title" => "Creative Hubs & Conferences",
            "description" => [
            "Experience a festival-meets-business environment designed to foster meaningful connections",
            "Explore key creative spaces across Bangkok’s creative district",
            "Build relationships with studios, companies, and institutions",
            ]
            ],
            [
            "title" => "Talent & Artistry Showcase",
            "description" => [
            "Perform in and utilize six official Philippine showcase slots",
            "Present to over 100 festival programmers, music supervisors, and delegates from across Asia",
            "Spark collaborations and connect with industry leaders",
            ]
            ],
            ];
            @endphp
            @foreach ($content as $item)
            <div class="col-12 col-md-6 col-lg-4 d-flex flex-column align-items-center px-5">
                <h3 class="h02 my-4">{{ $item['title'] }}</h3>
                <ul class="text-start">
                    @foreach ($item['description'] as $desc)
                    @php
                    $sentence = explode(' ', $desc);
                    $first = array_shift($sentence);
                    $rest = implode(' ', $sentence)
                    @endphp
                    <li>
                        <p class="p02">
                            <strong>{{ $first }}</strong> {{ $rest }}
                        </p>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
    </div>
    <div class="container my-4">
        <p class="p02">To fully leverage these opportunities and maximize your impact, elevate your insights through the <strong>Market-Sensing Program</strong>. This is designed to deepen your understanding of industry practices and position you for success.</p>
    </div>
</section>

{{-- MARKET-SENSING --}}
<section class="header5 d-flex flex-column justify-content-center">
    <div class="container my-2">
        <div class="text-center">
            <p class="fs-1 fw-bold">
                LEVEL UP YOUR ARTISTRY THROUGH THE MARKET-SENSING PROGRAM
            </p>
            <p class="fs-5 py-2 pb-4">
                Gain crucial insights into regional creative markets to help shape your long-term strategy and creative brand.
            </p>
        </div>
        <div class="row d-flex flex-column-reverse flex-lg-row mt-5">
            <div class="col-12 col-lg-6 d-flex flex-column">
                <p class="fs-2 fw-bold">
                    Apply for the Market-Sensing Program
                </p>
                <p class="fs-5 my-4">
                    Market sensing builds brand familiarity, deepens recognition, and opens doors. At Bangkok Music City 2026, you’ll have the chance to showcase your talent, meet industry movers, and discover new pathways to success.
                    <br>
                    <br>
                    In this program, delegates can explore new markets, find potential collaborators, and expand their market reach. Elevate your artistic journey and be well-equipped for future participation in creative export initiatives.
                    <br>
                    <br>
                    Join the delegation and take the next step through our program today!
                    <br>
                    <br>
                    <strong>
                        Package Fee: USD 600
                    </strong>
                    <br>
                    <i>
                        Flights and accommodation are not included.
                    </i>
                </p>
            </div>
            <div class="col-12 col-lg-6 mb-4">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <img
                        class="img-fluid"
                        src="{{ asset('img/static/2026_BMC/BMC-img-8.png') }}"
                        alt="2026_BMC"
                        loading="lazy">
                </div>
            </div>

            <div class="row d-flex flex-column flex-lg-row mt-5">
                <div class="col-12 col-lg-6 mb-4">
                    <div class="d-flex justify-content-center align-items-center h-100">
                        <img
                            class="img-fluid"
                            src="{{ asset('img/static/2026_BMC/BMC-img-9.png') }}"
                            alt="2026_BMC"
                            loading="lazy">
                    </div>
                </div>
                <div class="col-12 col-lg-6 d-flex flex-column">
                    <p class="fs-2 lh-sm fw-bold">
                        What makes the Market Sensing Program different
                    </p>
                    <p class="fs-5 my-4">
                        More than understanding a market, this program offers a structured learning experience, including:
                    </p>
                    <ul class="fs-5">
                        <li>All-access passes to BMC conferences and showcases</li>
                        <li>Office, studio, and creative hub visits arranged by BMC</li>
                        <li>Observation slots in PH-delegation roundtable sessions</li>
                        <li>Networking access alongside the main PH delegation</li>
                        <li>Opportunities to learn about Thailand’s music and creative industries</li>
                    </ul>
                </div>
            </div>

            <div class="row d-flex flex-column-reverse flex-lg-row mt-5">
                <div class="col-12 col-lg-6 d-flex flex-column">
                    <p class="fs-2 fw-bold">
                        Apply for the Market-Sensing Program
                    </p>
                    <p class="fs-5 my-4">
                        Market sensing builds brand familiarity, deepens recognition, and opens doors. At Bangkok Music City 2026, you’ll have the chance to showcase your talent, meet industry movers, and discover new pathways to success.
                        <br>
                        <br>
                        In this program, delegates can explore new markets, find potential collaborators, and expand their market reach. Elevate your artistic journey and be well-equipped for future participation in creative export initiatives.
                        <br>
                        <br>
                        Join the delegation and take the next step through our program today!
                        <br>
                        <br>
                        <strong>
                            Package Fee: USD 600
                        </strong>
                        <br>
                        <i>
                            Flights and accommodation are not included.
                        </i>
                    </p>
                    <div class="d-flex align-items-center">
                        <button type="button" class="button3 rounded-2">Apply Now</button>
                    </div>
                </div>
                <div class="col-12 col-lg-6 mb-4">
                    <div class="d-flex justify-content-center align-items-center h-100">
                        <img
                            class="img-fluid"
                            src="{{ asset('img/static/2026_BMC/BMC-img-10.png') }}"
                            alt="2026_BMC"
                            loading="lazy">
                    </div>
                </div>
            </div>
        </div>
</section>

{{-- COLLABORATION --}}
<section class="header6 d-flex flex-column justify-content-center">
    <div
        class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-12 col-lg-8">
                <div class="container m-lg-5">
                    <p class="text-black fs-1 lh-sm fw-bold text-center text-lg-start">
                        In Collaboration With Sonik Philippines
                    </p>
                    <p class="text-black fs-3">
                        This initiative is made possible through Sonik Philippines, committed to supporting Filipino music and amplifying global exposure of Filipino creatives.
                    </p>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="h-100 mt-5 d-flex align-items-center justify-content-center">
                    <a type="button" class="button1 rounded-2" target="_blank" href="https://www.facebook.com/sonikphilippines">Explore Sonik Philippines</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- HEADER TEXT --}}
<section class="header4 d-flex flex-column justify-content-center py-5">
    <div
        class="container">
        <div class="row mx-lg-5">
            <h1 class="mt-5 h04 text-center text-md-start">
                Championing Filipino creativity on the global stage
            </h1>
            <div class="container-lg my-4">
                <p class="p02">
                    Filipino talent rises to the occasion, showcasing our signature artistry, heart, and world-class creativity to Asia and beyond.
                    <br>
                    <br>
                    Whether you're an artist, creative, student, or industry professional, Thailand becomes your stage, and the whole world becomes your audience.
                    <br>
                    <br>
                    Make your mark on the global stage and don’t miss out on this opportunity.

                </p>
            </div>
            <div class="d-flex justify-content-center justify-content-lg-start mt-5">
                <a type="button" class="button2 rounded-2" target="_blank" href="https://bangkokmusiccity.com/">Discover more about BMC</a>
            </div>
        </div>
    </div>
</section>


@endsection