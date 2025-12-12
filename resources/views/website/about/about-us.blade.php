@extends('layouts.app')

@section('styles')
    <style>
        .video-container {
            position: relative;
            width: 100%;
            max-width: 100%; /* Ensures it doesn't exceed container */
        }

        .video-container video {
            width: 100%;
            height: auto; /* Maintains aspect ratio */
            display: block;
        }
    </style>
@endsection

@section('content')

<section class="bg_black ">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-4"></div>
            <div class="col-xs-12 col-sm-4 text-center">
                <h1 class="text-center">ABOUT</h1>
                <br>
                <img src="{{ asset('img/createph-logo_horizontal.png') }}" class="img-fluid" alt="CREATEPhilippines Logo">
            </div>
        </div>
    </div> 
</section>
<section class="bg_light_grey">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6 pb-3">
                <!-- <img src="{{ asset('img/static/about_createph.png') }}" class="img-fluid" alt="CREATEPhilippines Logo"> -->
                <div class="video-container">
                    <video id="about-video" muted controls autoplay loop playsinline>
                        <source src="/img/CREATEPhilippines_BV.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>

                    
            
                </div>
            </div>
            <div class="col-12 col-lg-6">
               <p>
                    <b>CREATEPhilippines.com</b> is the country's first government-led content and community platform for the local creative industries.
                    <br><br>
                    It is the ultimate resource for stories and updates on the Philippines' creative community and a centralized directory and sourcing platform where Filipino creatives can share their portfolio to and engage with a global audience.
                    <br><br>
                    <b>CREATEPhilippines</b> is organized by the Center for International Trade Expositions and Missions (CITEM), the export marketing arm of the Philippine Department of Trade and Industry (DTI).
                    <br><br>
                    <b>CREATEPhilippines.com</b> is published by the Center for International Trade Expositions & Missions (CITEM).
                </p>
                <div>
                    @include('layouts.socials')
                </div>
            </div>
        </div>
    </div>
</section>

@endsection 