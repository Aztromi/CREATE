@extends('layouts.app')

@section('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100..900;1,100..900&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!-- <link href="{{ asset('css/website/info_page.css?ver=' . time()) }}" rel="stylesheet"> -->
    <style>
        #banner {
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }

        #banner .container-fluid {
            padding: 0;
        }

        #banner .container-fluid img {
            width: 100%;
            height: auto;
        }

        #vidSection {
            background-color: #3364AC;

            border-bottom: 3px solid #FEBC4C;
        }

        #imgSection {
            background-color: #19418C;

            border-bottom: 3px solid #FEBC4C;
        }

        #events {
            background-color: #3364AC;
        }

        #partners {
            background-color: #19418C;
        }

        .head01 {
            font-family: "Urbanist", sans-serif;
            font-optical-sizing: auto;
            font-weight: 600;
            font-style: normal;
            font-size: 48px;
            line-height: 1.1;

            color: #FEBC4C;
        }

        .head01 {
            font-family: "Urbanist", sans-serif;
            font-optical-sizing: auto;
            font-weight: 600;
            font-style: normal;
            font-size: 36px;
            line-height: 1.1;

            color: #FEBC4C;
        }

        p {
            font-family: "Work Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;
            font-size: 20px;
            line-height: 1.2;

            color: #FFF;
        }

        .p2 {
            font-family: "Work Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 600;
            font-style: normal;
            font-size: 20px;
            line-height: 1.2;

            color: #EAAE49;
        }

        .txt01 {
            font-family: "Urbanist", sans-serif;
            font-optical-sizing: auto;
            font-weight: 600;
            font-style: normal;
            font-size: 20px;
            line-height: 1.2;

            color: #F9FBB2;
        }

        .btn-primary {
            width: 100%;
            color: #FFF !important;
            background-color: #0E2F6D !important;
            border: 0 !important;

            font-family: "Work Sans", sans-serif !important;
            font-optical-sizing: auto;
            font-weight: 500 !important;
            font-style: normal;
            font-size: 20px !important;
            line-height: 1.2;

            padding-top: 10px !important;
            padding-bottom: 10px !important;
        }

        .btn-secondary {
            width: 100%;
            color: #0E2F6D !important;
            background-color: #D4A557 !important;
            border: 0 !important;

            font-family: "Work Sans", sans-serif !important;
            font-optical-sizing: auto;
            font-weight: 500 !important;
            font-style: normal;
            font-size: 20px !important;
            line-height: 1.2;

            padding-top: 10px !important;
            padding-bottom: 10px !important;
        }

        #imgSection .col {
            height: 100%;
            margin-bottom: 50px;
        }

        #imgSection .img-container {
            border-radius: 20px;
            width: 100%;
            height: 250px;
            overflow: hidden;
            position: relative;

            margin-bottom: 10px;
        }

        #imgSection .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        /* #imgSection .txt01 {
            display: block;
        } */

        #events .cards .col {
            margin: 0 auto;
            margin-bottom: 20px;
        }

        #events .cards .col .card-container {
            /* margin: 5px; */
            padding: 50px;
            height: 100%;
            border: 2px solid #CC9A6A;
            border-radius: 20px;
            background-color: #2F5498;
        }

        #events .cards .col .img-container{
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #events .cards .col .img-container img{
            width: 100%;
            max-width: 200px;
            height: auto;
            
        }

        #events .cards .col .title-container {
            margin-top: 20px;
            height: 100px;

            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;


            font-family: "Urbanist", sans-serif;
            font-optical-sizing: auto;
            font-weight: 600;
            font-style: normal;
            font-size: 26px;
            line-height: 1.1;

            color: #FFF;
        }

        #events .cards .col .detail-container {
            margin-top: 20px;
            /* height: 120px;

            display: flex;
            align-items: center;
            justify-content: center; */
            text-align: center;


            font-family: "Work Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;
            font-size: 20px;
            line-height: 1.1;

            color: #FFF;
        }

        #events .small01 {
            text-align: center;
            font-family: "Work Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 300;
            font-style: italic;
            font-size: 16px;
            line-height: 1;

            color: #99BDFF;
        }

        #partners .container {
            background-color: #FFFFFF;
            padding: 50px;
            border: 3px solid #FEBC4C;
            border-radius: 20px;
        }

        #partners .col {
            margin-top: 40px;
        }

        #partners .col {
            vertical-align: top;
        }

        #partners .label {
            width: 100%;

            text-align: center;
            font-family: "Work Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 600;
            font-size: 20px;
            line-height: 1;
            color: #825C1D;
        }

        #partners .img-row {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        #partners .img-row .img-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #partners .img-row .img-container img {
            width: 100%;
            height: auto;
            max-width: 250px;
            object-fit: contain;
        }
        
    </style>
@endsection

@section('scripts-bottom')
@endsection

@section('content')
    {{-- BANNER --}}
    <section id="banner">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <img src="{{ asset('img/static/2025_animahenasyon/animahenasyon_banner.png') }}" alt="">
                </div>
            </div>
        </div>
    </section>

    <section id="vidSection">
        <div class="container">
            <div class="row d-flex align-items-center justify-content-center mb-5">
                <div class="col text-center">
                    <span class="head01">CREATEPhilippines and the Animation Council of the Philippines, Inc. are set to take you to a world of pure imagination.</span>
                </div>
            </div>
            <div class="row d-flex align-items-center justify-content-center mb-5">
                <div class="col text-center">
                    <p>The country’s premier annual event dedicated to celebrating and showcasing the talent, creativity, and innovation of the Filipino animation industry is dreaming up something fantastical to further energize the local animation scene.</p>
                </div>
            </div>
            <div class="row d-flex align-items-center justify-content-center mb-5">
                <div class="col-11">
                    <div style="position: relative; width: 100%; padding-bottom: 56.25%; height: 0; overflow: hidden;">
                        <iframe 
                            src="https://www.facebook.com/plugins/video.php?height=314&href=https%3A%2F%2Fwww.facebook.com%2Freel%2F1493314505223139%2F&show_text=false&width=560&t=0" 
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none; overflow: hidden;" 
                            scrolling="no" 
                            frameborder="0" 
                            allowfullscreen="true" 
                            allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
                        </iframe>
                    </div>

                    
                </div>
            </div>
            <div class="row d-flex align-items-center justify-content-center">
                <div class="col-10 col-md-5 mb-3">
                    <a href="https://www.animationcouncil.org/animahenasyon2025" class="btn btn-primary">Learn More</a>
                </div>

                <div class="col-10 col-md-5 mb-3">
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLSeGCPUTeBgmJBDEbeDs9_VgQL3H96U90xk_l8E9EFXppL82SA/viewform" class="btn btn-primary">Register as Delegate</a>
                </div>
            </div>
        </div>
    </section>

    <section id="imgSection">
        <div class="container">
            <div class="row d-flex align-items-center justify-content-center mb-5">
                <div class="col text-center">
                    <p>For its 19th edition, Animahenasyon takes a big leap. With an eye on conquering the international industry, the Philippine Animation Festival is set to bring these goals to life: </p>
                </div>
            </div>
            <div class="row d-flex align-items-top justify-content-center">
                <div class="col col-6 col-md-4 text-center">
                    <div class="img-container">
                        <img src="{{ asset('img/static/2025_animahenasyon/img_01.jpg') }}" alt="">
                    </div>
                    
                    <span class="txt01">Develop the Philippine animation industry and promote it in the global scene</span>
                </div>

                <div class="col col-6 col-md-4 text-center">
                    <div class="img-container">
                        <img src="{{ asset('img/static/2025_animahenasyon/img_02.jpg') }}" alt="">
                    </div>
                    <span class="txt01">Provide animators, producers, industry supporters, investors, and stakeholders a venue for networking and business matching</span>
                </div>
                <div class="col col-6 col-md-4 text-center">
                    <div class="img-container">
                        <img src="{{ asset('img/static/2025_animahenasyon/img_03.png') }}" alt="">
                    </div>
                    <span class="txt01">Provide access to locally produced animation content</span>
                </div>
                <div class="col col-6 col-md-4 text-center">
                    <div class="img-container">
                        <img src="{{ asset('img/static/2025_animahenasyon/img_04.jpg') }}" alt="">
                    </div>
                    <span class="txt01">Set the direction for the development of the animation industry through international and business conference forums</span>
                </div>
                <div class="col col-6 col-md-4 text-center">
                    <div class="img-container">
                        <img src="{{ asset('img/static/2025_animahenasyon/img_05.jpg') }}" alt="">
                    </div>
                    <span class="txt01">Encourage potential talents to explore career opportunities and hone their skills through competition</span>
                </div>

            </div>
        </div>

    </section>

    <section id="events">
        <div class="container">
            <div class="row d-flex align-items-center justify-content-center mb-5">
                <div class="col text-center">
                    <span class="head01">SCHEDULE OF EVENTS</span>
                </div>
            </div>
            <div class="row mb-5 cards">
                <div class="col col-6 col-md-4 col-lg-3">
                    <div class="card-container">
                        <div class="img-container">
                            <img src="{{ asset('img/static/2025_animahenasyon/ico_01.png') }}" alt="">
                        </div>
                        <div class="title-container">
                            <span>AniSine</span>
                        </div>
                        <div class="detail-container">
                            <span>24 November 2025<br />the Shangri-La Red Carpet</span>
                        </div>
                    </div>
                </div>
                <div class="col col-6 col-md-4 col-lg-3">
                    <div class="card-container">
                        <div class="img-container">
                            <img src="{{ asset('img/static/2025_animahenasyon/ico_02.png') }}" alt="">
                        </div>
                        <div class="title-container">
                            <span>AniTalk & AniKompetisyon Awarding</span>
                        </div>
                        <div class="detail-container">
                            <span>25 November 2025<br />The Samsung Hall, SM Aura Premiere, Taguig City</span>
                        </div>
                    </div>
                </div>
                <div class="col col-6 col-md-4 col-lg-3">
                    <div class="card-container">
                        <div class="img-container">
                            <img src="{{ asset('img/static/2025_animahenasyon/ico_03.png') }}" alt="">
                        </div>
                        <div class="title-container">
                            <span>AniBusiness</span>
                        </div>
                        <div class="detail-container">
                            <span>26 November 2025<br />Seda BGC</span>
                            <br>
                        </div>
                        <br>
                        <center>
                            <span class="small01">Note: For confirmed buyers and delegates only.</span>
                        </center>
                    </div>
                </div>
                <div class="col col-6 col-md-4 col-lg-3">
                    <div class="card-container">
                        <div class="img-container">
                            <img src="{{ asset('img/static/2025_animahenasyon/ico_04.png') }}" alt="">
                        </div>
                        <div class="title-container">
                            <span>AniXperience</span>
                        </div>
                        <div class="detail-container">
                            <span>27-28 November 2025</span>
                            <br>
                        </div>
                        <br>
                        <center>
                            <span class="small01">Note: For confirmed buyers and delegates only.</span>
                        </center>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col text-center mb-3">
                    <p>With CREATEPhilippines as a co-presenter, Animahenasyon will transform the local animation industry from being a center for outsourced creative talents to becoming the new international animation hub.</p>
                </div>
            </div>
            <div class="row">
                <div class="col text-center mb-3">
                    <p><b>Meet Filipino animation talents! Connect with local studios and producers!<br />Discover all-original animation titles and content!</b></p>
                </div>
            </div>
            <div class="row">
                <div class="col text-center mb-3">
                    <p>
                        We’re rolling out the red carpet for participating buyers, production houses, and publishers!
                        <br />
                        Submit your intent to be an Animahenasyon buyer here and immerse yourself in the best of what world-class Filipino animation has to offer.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col text-center mb-3">
                    <span class="p2">Conference | Film festival | Business matching | Buyer servicing & incentives | Business + leisure experience</span>
                </div>
            </div>

            <div class="row">
                <div class="col text-center mb-5">
                    <p>Come join Animahenasyon and be part of setting up the next stage of the evolving Philippine animation industry!</p>
                </div>
            </div>

            <div class="row d-flex align-items-center justify-content-center">
                <div class="col-8 col-md-6">
                    <a href="https://bit.ly/Ani2025Tickets" class="btn btn-secondary" target="_blank" rel="noopener noreferrer">Get your tickets now</a>
                </div>
            </div>
        </div>
    </section>

    <section id="partners">
        <div class="container">
            <div class="row d-flex align-items-start justify-content-center">
                <div class="col col-12 col-md-4">
                    <div class="label">Event Organizer</div>
                    <div class="img-row">
                        <div class="img-container">
                            <img src="{{ asset('img/static/2025_animahenasyon/Acpi.png') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col col-12 col-md-8">
                    <div class="label">Event Co-Presenter</div>
                    <div class="img-row">
                        <div class="img-container">
                            <img src="{{ asset('img/static/2025_animahenasyon/Dti_Citem.png') }}" alt="">
                        </div>
                        <div class="img-container">
                            <img src="{{ asset('img/static/2025_animahenasyon/CPH.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex align-items-start justify-content-center">
                <div class="col col-12">
                    <div class="label">Government Partners</div>
                    <div class="img-row">
                        <div class="img-container">
                            <img src="{{ asset('img/static/2025_animahenasyon/DICT.png') }}" alt="">
                            <img src="{{ asset('img/static/2025_animahenasyon/FDCP.png') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col col-12" style="margin-top: 0 !important;">
                    <div class="img-row">
                        <div class="img-container">
                            <img src="{{ asset('img/static/2025_animahenasyon/intramuros.png') }}" alt="">
                            <img src="{{ asset('img/static/2025_animahenasyon/gsis.jpg') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col col-12" style="margin-top: 0 !important;">
                    <div class="img-row">
                        <div class="img-container">
                            <img src="{{ asset('img/static/2025_animahenasyon/san_fernando_lgu.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex align-items-start justify-content-center">
                <div class="col col-12 col-md-6">
                    <div class="label">Venue Partner</div>
                    <div class="img-row">
                        <div class="img-container">
                            <img src="{{ asset('img/static/2025_animahenasyon/shangrila.png') }}" alt="">
                            <img src="{{ asset('img/static/2025_animahenasyon/redcarpet.png') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col col-12 col-md-6">
                    <div class="label">Film Screening Partners</div>
                    <div class="img-row">
                        <div class="img-container">
                            <img src="{{ asset('img/static/2025_animahenasyon/Cinematheque.png') }}" alt="">
                            <img src="{{ asset('img/static/2025_animahenasyon/Juanflix.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
@endsection
