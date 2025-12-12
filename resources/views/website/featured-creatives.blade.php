@extends('layouts.app')

@section('styles')
    <style>

        .head-banner {
            max-width: 700px !important;
        }

        .featured-creatives>.row>.col {
            margin-bottom: 20px;
        }

        .featured-creatives .register-cta {
            min-width: 380px;
            max-width: 900px;
            background-color: #231f20;
            border-radius: 30px;
        }

        .featured-creatives .register-cta .row .col {
            padding: 20px;
        }

        .featured-creatives .register-cta .img {
            padding: 20px;
            padding: 0 auto;
        }

        .featured-creatives .register-cta .img .img-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .featured-creatives .register-cta .img .img-container img {
            max-width: 250px;
            width: 100%
        }

        .featured-creatives .register-cta .text {
            color: #FFFFFF;
            font-size: 18px;
            font-weight: 400;
            margin: auto 0;
            padding-left: 40px !important;
            padding-right: 40px !important;
        }

        .featured-creatives .register-cta .text a {
            text-decoration: none;
            color: #31A2F0;
            font-size: 21px;
            font-weight: 600;
        }
        
        .featured-creative {
            background-color: #252525;
            height: 100%;
            border-radius: 30px;
            min-width: 380px;

            overflow-y: hidden;

            box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
        }

        .featured-creative .month {
            text-align: center;
            margin: 0 auto;
            padding: 10px 0; 
            border-top-left-radius: 30px;

            height: 120px;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .featured-creative .month .container-fluid{
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        .featured-creative .month .month-ribbon {
            padding-top: 8px;
            padding-bottom: 8px;
        }

        .featured-creative .month .row .col {
            padding: 0;
            margin: 0;
        }

        .featured-creative .month .month-short{
            font-size: 30px;
            font-weight: bold;
            
        }

        .featured-creative .month .month-long {
            font-size: 12px;
            font-weight: bold;
            line-height: normal;
        }

        .featured-creative .img-cover {
            color: white;
            /* padding: 40px 15px; */
            margin: 0;

            border-top-right-radius: 30px;
            font-size: clamp(30px, 5vw, 40px);
            line-height: 1;
            font-weight: bold;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .featured-creative .img-cover .creative-name {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.9);
        }

        .featured-creative .yt-row {
            background-color: #252525;
        }

        .featured-creative .article-row {
            padding: 15px 15px 30px 15px;
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;

            height: 100%;

            transition: background-color 0.3s ease, border 0.3s ease;
        }

        .featured-creative .article-row:hover {
            background-color: #31A2F0;
            /* border: 3px solid #31A2F0; */
        }

        .featured-creative .article-row a {
            text-decoration: none;
        }

        .featured-creative .article-row .label {
            margin-bottom: 10px;
        }
        
        .featured-creative .article-row .label span {
            font-weight: bold;
            font-size: 12px;
            color: #FFFFFF;
            padding: 6px 10px;
            border-radius: 20px;
            background-color: #31A2F0;

            transition: background-color 0.3s ease;
        }

        .featured-creative .article-row:hover .label span {
            background-color: #252525;
        }

        .featured-creative .article-row .content {
            font-weight: bold;
            color: #FFFFFF;
            line-height: 1.2;
            font-size: clamp(20px, 3vw, 30px);

            margin-bottom: 0;
        }
        

    </style>
@endsection

@section('content')

<section class="bg_black pt-5 pb-4">
    <div class="container head-banner">
        <div class="row text-center">
            <h1 class="text-center">An Imaginative Nation: Creative Features by CREATEPhilippines</h1>
            <p class="text-center">Welcome to our monthly section where we put the spotlight on some of the country’s most inspiring creatives.</p>
            <p class="text-center">This initiative is part of CREATEPhilippines’ work to uplift the talent, passion, and ingenuity of the Filipino creative community. By sharing the unique stories behind the artistic purpose, perspective, and practices of these individuals and collectives from across different creative domains, we celebrate the depth and diversity they bring to their respective industries and put the country on the global creative map.</p>
        </div>
    </div>
</section>
<section>

    
    @if($creatives)
        <div class="container featured-creatives">
            <div class="row justify-content-center">
                @foreach($creatives as $creative)
                    <div class="col col-12 col-lg-6">
                        <div class="container featured-creative">
                            <div class="row">
                                <div class="col col-3 month">
                                    <div class="container-fluid" style="background-color: {{ $creative->background_color }};">
                                        <div class="row month-ribbon">
                                            <div class="col col-12 month-short">{{ $creative->month_short }}</div>
                                            <div class="col col-12 month-long">{{ $creative->month_long }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-9 img-cover">
                                    <span class="creative-name">
                                        {{ $creative->name }}
                                    </span>
                                </div>
                            </div>
                            <div class="row yt-row">
                                <div class="col col-12 yt-container p-0 m-0">
                                    <div class="ratio ratio-16x9">
                                        <iframe 
                                            src="https://www.youtube.com/embed/{{ $creative->yt_id }}" 
                                            title="YouTube video" 
                                            allowfullscreen>
                                        </iframe>
                                    </div>

                                </div>
                            </div>
                            <div class="row article-row">
                                <a href="{{ $creative->article_link }}" target="_blank" rel="noopener noreferrer">
                                    <div class="col col-12 label">
                                        <span>ARTICLE</span>
                                    </div>
                                    <div class="col col-12 content">
                                        {{ $creative->article_title }}
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
                    <div class="col col-12 post-text mt-5">
                        <div class="container-fluid register-cta">
                            <div class="row">
                                <div class="col col-12 col-md-4 img">
                                    <div class="img-container">
                                        <img src="{{ asset('img/register_cta_img.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="col col-12 col-md-8 text">
                                    The subjects of our monthly Creative Feature are also members of CREATEPhilippines’ Directory of Creatives. To get the opportunity to tell the story of your creative journey, too,  <a href="{{ route('register.index') }}" target="_blank" rel="noopener noreferrer">register here</a> and be part of our vibrant community.
                                </div>
                            </div>
                        </div>
                        
                    </div>
            </div>
        </div>
    @else
        <center>No Featured Creatives at the moment</center>
    @endif
    
</section>

@endsection