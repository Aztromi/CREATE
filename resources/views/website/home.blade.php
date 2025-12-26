@extends('layouts.app')

@section('styles')
<style>
    #info-container .create-logo {
        height: 3em;
        /* Adjust this value as needed to match text height */
        width: auto;
        /* Maintain aspect ratio */
        margin-left: 0.5em;
        /* Add some space between text and image */
        margin-top: 3px;
    }

    #info-container .about-head-container {
        font-size: 25px;
    }

    #info-container .gen-text {
        display: block;
        line-height: 1.2;
    }

    #info-container .gen-text-black {
        display: block;
        line-height: 1.2;
        color: #F5F5F5;
    }





    #info-container .flip-card {
        width: 100%;
        height: 200px;
        perspective: 1000px;
        margin: auto;
    }

    #info-container .flip-card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        transition: transform 0.8s;
        transform-style: preserve-3d;
    }

    #info-container .flip-card:hover .flip-card-inner {
        transform: rotateY(180deg);
    }

    #info-container .flip-card-front {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 1rem;
    }

    #info-container .flip-card-front,
    #info-container .flip-card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        background-size: cover;
        background-position: center;
        border-radius: 12px;
        color: white;
        font-size: 1.2rem;
        text-align: center;
        /* background-color: #333; */
    }

    .flip-card-front img,
    .flip-card-back img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        border-radius: 20px;
        top: 0;
        left: 0;
        z-index: 0;
    }

    .blur {
        width: 100%;
        height: 200px;
        background-image: url("{{ asset('img/home_about/thumbnails/animation.png') }}");
        object-fit: cover;
        position: absolute;
        background-size: cover;
        background-position: center;
        border-radius: 20px;
        top: 0;
        left: 0;
        z-index: 0;
    }

    .flip-card-front .card-content,
    .flip-card-back .card-content {
        position: relative;
        z-index: 1;
        padding: 1rem;
        text-align: center;
    }

    #info-container .flip-card-back {
        transform: rotateY(180deg);
    }

    #info-container .flip-card-back .card-content {
        width: 100%;
        height: 100%;
        background-color: #333333da;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    #info-container .flip-card-front .card-content h4,
    #info-container .flip-card-back .card-content p {
        opacity: 1;
        text-shadow: 0px 2px 20px #000000, 0px 2px 20px #000000, 0px 2px 20px #000000;
    }


    #info-container .core-card-container,
    #info-container .sector-card-container {
        margin-bottom: 20px;
    }

    #info-container .core-card-container .core-card {
        height: 100%;
        box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
        border-radius: 20px;
        background-color: #333;

    }

    #info-container .core-card-container .core-card div:first-child {
        min-height: 90px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        padding-left: 10px;
        padding-right: 10px;
    }

    #info-container .core-card-container .core-card div:first-child span {
        font-weight: bold;
        font-size: 20px;
        line-height: 1.2;
    }

    #info-container .core-card-container .core-card div:last-child {
        color: #FFFFFF;
        padding: 20px;
        text-align: center;
    }
</style>
@endsection

@section('content')

{{-- Everything Creative --}}
{{-- <! <img src="{{ asset('everything-creative/ec-banner.png') }}" alt="Everything Creative" class="img-fluid"> --}}

{{-- IMAGE CAROUSEL --}}
@include('components.home_carousel')


{{-- WORKS --}}
<section class="bg_light_grey">
    <div class="container">
        <div class="row">
            <h2>CREATIVE WORKS</h2>
        </div>
        <div class="home_directory">

            <div class="image-container">
                @foreach($works as $work)
                <div class="image">
                    <a href="{{ route('creative-works.view', ['slug' => $work->homeStoryLatest->latestSlug->value]) }}">
                        <img src="{{ asset('folder_user-uploads/' . $work->id . '/stories/' . $work->homeStoryLatest->cover_image) }}" alt="{{ $work->homeStoryLatest->latestSlug->value }}" loading="lazy">
                    </a>

                    <div class="creative-details">
                        <a href="{{ route('profile', ['slug' => $work->profile->latestSlug->value]) }}">

                            {{-- ALTERNATE PROFILE PICTURE: public/img/default_profile_img.png --}}
                            <img src="
                                @if($work->profile->uindie->display_photo)
                                    {{ @asset('folder_user-uploads/' . $work->id . '/Profile/' . $work->profile->uindie->display_photo) }}
                                @else
                                    {{ @asset('/img/default_profile_img.png') }}
                                @endif
                            " alt="{{ @$work->profile->latestSlug->value  }}">
                            <span>
                                @if($work->profile->company_name)
                                By {{ $work->profile->company_name }}
                                @elseif($work->profile->first_name && $work->profile->last_name)
                                By {{ $work->profile->first_name . ' ' . $work->profile->last_name }}
                                @endif
                            </span>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
        <div class="text-center mt-60 mb-60">
            <a href="{{ route('directory') }}" class="btn btn-primary">
                VIEW MORE CREATIVE WORKS
            </a>
        </div>
    </div>
</section>
{{-- WORKS End --}}


{{-- About CREATE --}}
<section id="info-container">
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <div class="about-head-container d-flex align-items-start">
                    <span>ABOUT</span><img src="{{ asset('img/logo.png') }}" alt="" loading="lazy" class="img-fluid create-logo">
                    <!-- <span>ABOUT</span> <img src="{{ asset('img/createph-logo_horizontal_black.png') }}" alt="" loading="lazy" class="img-fluid create-logo"> -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 mt-2 mx-auto">
                <div class="text-center">
                    <span class="gen-text">The country’s flagship export trade promotion program of the Department of Trade and Industry (DTI), organized by CITEM, dedicated to the promotion and support of the economic growth of the Philippine creative industries.</span>
                </div>

            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 text-center">
                <span>
                    <h3>Your Pathway to be a Global Creative!</h3>
                </span>
            </div>
            <div class="col-12 text-center">
                <p class="gen-text">Let your creative voice be amplified! At CREATEPhilippines you as a creator can collaborate with fellow enthusiastic and passionate creative communities through digital spaces and existing supported events. The platform also bridges the traditional with the current medium and encourages a culture of innovation. You can avail yourself of our added-value services to realize your vision and attain your goals.</p>
                <p class="gen-text">Utilize the CREATEPhilippines platform as your centralized creative directory and sourcing hub to reach wider audiences by building and sharing your portfolio.</p>
                <p class="gen-text"><strong>CREATEPhilippines will help you not just to express, but also to thrive and cater to the world stage. Art here is regarded more than just mere expression—it is a driver of change and catalyzes impact.</strong></p>
            </div>
        </div>
        <div class="row mt-5 core-values">
            <div class="col-12 text-center mb-2">
                <span>
                    <h3>CORE VALUES</h3>
                </span>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 core-card-container">
                <div class="core-card">
                    <div style="background-color: #3CCA92;">
                        <span>Global Excellence</span>
                    </div>
                    <div>
                        <span class="gen-text">CREATEPhilippines ensures commitment to best practices to exhibit world-class, high-standard quality or performance that makes the Philippine creative industries an export force.</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 core-card-container">
                <div class="core-card">
                    <div style="background-color: #3C9AEC;">
                        <span>Brand Building</span>
                    </div>
                    <div>
                        <span class="gen-text">CREATEPhilippines serves as the brand that defines the Philippine creative industry, promoting the country internationally and ensuring that the voices of Filipino creatives are heard in a competitive industry.</span>
                    </div>
                </div>

            </div>
            <div class="col-12 col-sm-6 col-lg-3 core-card-container">
                <div class="core-card">
                    <div style="background-color: #FFC906;">
                        <span>Inspiration</span>
                    </div>
                    <div>
                        <span class="gen-text">CREATEPhilippines supports artists by providing safe spaces for emotional storytelling and self-expression. It acts as a platform to inspire adn uplift their spirits in creating more outputs and elevating their practice.</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 core-card-container">
                <div class="core-card">
                    <div style="background-color: #DB87B8;">
                        <span>Art as a Tool for Transformation</span>
                    </div>
                    <div>
                        <span class="gen-text">Every creative idea becomes part of transforming creativity into different media that cater to advocacies and contribute to the country’s economic growth, thus rebuilding with purpose.</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 text-center">
                <span>
                    <h3>PRIORITY SECTORS</h3>
                </span>
            </div>
            <div class="col-12 text-center">
                <span class="gen-text">CREATEPhilippines supports all creative domains, but it has the following sectors as its focus:</span>
            </div>
        </div>
        <div class="row justify-content-center mt-3 priority-sectors">
            <!-- @php
            $sectors = [
            ['title' => 'Animation', 'image' => 'animation.webp', 'desc' => 'Drives digital storytelling in ads, games, and film, boosting innovation and global reach.'],
            ['title' => 'Communication Design', 'image' => 'communication_design.webp', 'desc' => 'Merges design and strategy for impactful visual messaging across platforms.'],
            ['title' => 'Game Development', 'image' => 'game_development.webp', 'desc' => 'Combines art, tech, and story to create immersive, digital interactive experiences.'],
            ['title' => 'Performing Arts and Music', 'image' => 'performing_arts.webp', 'desc' => 'Strengthens the capacities of Filipino artists and musicians and prepares the performing arts industry to dominate the global and international scene.'],
            ['title' => 'Visual Arts', 'image' => 'visual_arts.webp', 'desc' => 'Expresses culture and identity through visual storytelling and creative media.'],
            ];
            @endphp
            @foreach($sectors as $sector)
            <div class="col-12 col-sm-6 col-md-4 sector-card-container" data-image="{{ asset('img/home_about/' . $sector['image']) }}">
                <div class="flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front">
                            <div>
                                <img src="{{ asset('img/home_about/' . $sector['image']) }}" alt="{{ $sector['title'] }}">
                            </div>
                            <div class="card-content">
                                <h4>{{ $sector['title'] }}</h4>
                            </div>
                        </div>
                        <div class="flip-card-back">
                            <div>
                                <img src="{{ asset('img/home_about/' . $sector['image']) }}" alt="{{ $sector['title'] }}">
                            </div>
                            <div class="card-content">
                                <p class="gen-text-black">{{ $sector['desc'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach -->
            <div class="col-12 col-sm-6 col-md-4 sector-card-container">
                <div class="flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front">
                            <div class="blur">
                                <img src="{{ asset('img/home_about/animations.webp') }}" alt="" loading="lazy">
                            </div>
                            <div class="card-content">
                                <h4>Animation</h4>
                            </div>
                        </div>
                        <div class="flip-card-back">
                            <div>
                                <img src="{{ asset('img/home_about/animation.webp') }}" alt="" loading="lazy">
                            </div>
                            <div class="card-content">
                                <p class="gen-text-black">Drives digital storytelling in ads, games, and film, boosting innovation and global reach.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 sector-card-container">
                <div class="flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front">
                            <div>
                                <img src="{{ asset('img/home_about/communication_design.webp') }}" alt="" loading="lazy">
                            </div>
                            <div class="card-content">
                                <h4>Communication Design</h4>
                            </div>
                        </div>
                        <div class="flip-card-back">
                            <div>
                                <img src="{{ asset('img/home_about/communication_design.webp') }}" alt="" loading="lazy">
                            </div>
                            <div class="card-content">
                                <p class="gen-text-black">Merges design and strategy for impactful visual messaging across platforms.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 sector-card-container">
                <div class="flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front">
                            <div>
                                <img src="{{ asset('img/home_about/game_development.webp') }}" alt="" loading="lazy">
                            </div>
                            <div class="card-content">
                                <h4>Game Development</h4>
                            </div>
                        </div>
                        <div class="flip-card-back">
                            <div>
                                <img src="{{ asset('img/home_about/game_development.webp') }}" alt="" loading="lazy">
                            </div>
                            <div class="card-content">
                                <p class="gen-text-black">Combines art, tech, and story to create immersive, digital interactive experiences.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 sector-card-container">
                <div class="flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front">
                            <div>
                                <img src="{{ asset('img/home_about/performing_arts.webp') }}" alt="" loading="lazy">
                            </div>
                            <div class="card-content">
                                <h4>Performing Arts and Music</h4>
                            </div>
                        </div>
                        <div class="flip-card-back">
                            <div>
                                <img src="{{ asset('img/home_about/performing_arts.webp') }}" alt="" loading="lazy">
                            </div>
                            <div class="card-content">
                                <p class="gen-text-black">Strengthens the capacities of Filipino artists and musicians and prepares the performing arts industry to dominate the global and international scene</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 sector-card-container">
                <div class="flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front">
                            <div>
                                <img src="{{ asset('img/home_about/visual_arts.webp') }}" alt="" loading="lazy">
                            </div>
                            <div class="card-content">
                                <h4>Visual Arts</h4>
                            </div>
                        </div>
                        <div class="flip-card-back">
                            <div>
                                <img src="{{ asset('img/home_about/visual_arts.webp') }}" alt="" loading="lazy">
                            </div>
                            <div class="card-content">
                                <p class="gen-text-black">Expresses culture and identity through visual storytelling and creative media.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- About CREATE End --}}








{{-- CTA Viber Community --}}
@include('components.viber')

{{-- ARTICLES --}}
<section class="bg_black25">
    <div class="container">
        <div class="row">
            <h2>ARTICLES</h2>
        </div>
        <div class="home_stories stories_page">

            {{-- FEATURED ARTICLES --}}
            <a href="{{ route('articles.view', ['slug' => $featuredArticle->latestSlug->value]) }}">
                <article>
                    <div>
                        <img src="{{ asset('folder_articles/' . $featuredArticle->asset->path) }}" alt="image info" class="img-fluid">
                    </div>
                    <div>
                        <h3>{{ $featuredArticle->name }}</h3>
                        <p>By <strong>{{ $featuredArticle->author }}</strong>, {{ \Carbon\Carbon::parse($featuredArticle->date)->format('F d, Y') }}</p>
                    </div>
                </article>
            </a>

            {{-- LATEST ARTICLES --}}
            @foreach($latestArticles as $lArticle)
            <a href="{{ route('articles.view', ['slug' => $lArticle->latestSlug->value]) }}">
                <article>
                    <div>
                        <img src="{{ asset('folder_articles/' . $lArticle->asset->path) }}" alt="image info" class="img-fluid">
                    </div>
                    <div>
                        <h3>{{ $lArticle->name }}</h3>
                        <p>By <strong>{{ $lArticle->author }}</strong>, {{ \Carbon\Carbon::parse($lArticle->date)->format('F d, Y') }}</p>
                    </div>
                </article>
            </a>
            @endforeach


        </div>
        <div class="text-center mt-60 mb-60">
            <a href="{{ route('articles') }}" class="btn btn-primary">
                READ MORE ARTICLES
            </a>
        </div>
    </div>
</section>

{{-- CREATIVE FUTURES - DISCONTINUED --}}
{{--
<section class="bg_light_grey">
    <div class="container">
        <div class="row">
            <h2>Did you miss the discussions in the Creative Futures?</h2>
        </div>
        <div class="row mb-50">
            <div class="container text-center">
                <div class="row mx-auto my-auto justify-content-center">
                    
                    @if(!$creativeFutures->isEmpty())

                    <div id="recipeCarousel" class="carousel slide multi-item" data-bs-ride="carousel">
                        <div class="carousel-inner" role="listbox">



                        @foreach($creativeFutures as $cFuture)
                            <div class="carousel-item">
                                <a href="{{ route('events.creative-futures-session', ['slug' => $cFuture->latestSlug->value]) }}">
<img src="{{ asset('folder_events/' . $cFuture->asset->path) }}">
</a>
</div>
@endforeach

</div>
<a class="carousel-control-prev bg-transparent w-aut" href="#recipeCarousel" role="button" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
</a>
<a class="carousel-control-next bg-transparent w-aut" href="#recipeCarousel" role="button" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
</a>
</div>

@else
No Creative Future Events
@endif

</div>
</div>
</div>
<div class="text-center mt-60 mb-60">
    <a href="{{ route('events.creative-futures') }}" class="btn btn-primary">
        CHECK OUT THE REST OF THE CREATIVE FUTURES CONTENT HERE
    </a>
</div>
</div>
</section>
--}}

<div id="videoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel" aria-hidden="true" style="margin-top:0!important;z-index:99999!important;width: 100% !important;height: 100% !important;max-height:initial">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content p-0" style="background-color: black; border: none;">
            <div class="modal-body p-0" style="max-height:initial">
                <!-- Custom Close Button -->
                <button id="closeButton" class="btn btn-danger" style="position: absolute; bottom: 50px; right: 30px; z-index: 10000;">
                    &times;
                </button>
                <video id="modalVideo" autoplay muted controls style="width: 100%; height: 100%;">
                    <source src="https://staging.createphilippines.com/public/CPH-for-Animahinasyon.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts-bottom')
<script>
    $(document).ready(function() {
        // Unmute video when it starts playing
        // $('#modalVideo').on('play', function () {
        //     this.muted = false; // Unmute the video
        // });

        // Close modal when the custom close button is clicked
        $('#closeButton').on('click', function() {
            $('#videoModal').modal('hide');
        });

        // Pause video when the modal is hidden
        $('#videoModal').on('hide.bs.modal', function() {
            $('#modalVideo')[0].pause();
        });

        // Auto-play video on modal show
        $('#videoModal').on('shown.bs.modal', function() {
            $('#modalVideo')[0].play();
        });

        // Show the modal on page load
        $('#videoModal').modal('show');

        var idleTime = 0; // Track idle time
        var activityDetected = false; // Flag to detect activity
        var idleTimer;

        // Function to show the modal and play the video
        function showModal() {
            $('#videoModal').modal('show');
            var video = $('#modalVideo')[0];
            video.currentTime = 0; // Start video from the beginning
            video.play();
        }

        // Function to reset the idle timer
        function resetIdleTimer() {
            idleTime = 0;
            activityDetected = true;
            clearTimeout(idleTimer);
            startIdleTimer();
        }

        // Function to start the idle timer
        function startIdleTimer() {
            idleTimer = setTimeout(function() {
                if (!activityDetected) {
                    showModal();
                }
            }, 1 * 60 * 1000); // 5 minutes
        }

        // Event listeners for user activity
        $(document).on('mousemove keypress scroll', function() {
            resetIdleTimer();
        });

        // Show the modal and autoplay the video on page load
        showModal();

        // When the modal is closed, start tracking activity
        $('#videoModal').on('hidden.bs.modal', function() {
            activityDetected = false; // Reset activity flag
            startIdleTimer(); // Start idle timer
        });

        // Pause the video when the modal is hidden
        $('#videoModal').on('hide.bs.modal', function() {
            var video = $('#modalVideo')[0];
            video.pause();
        });
    });
</script>

@endpush