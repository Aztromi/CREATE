@extends('layouts.app')

@section('styles')
    <style>
        article {
            height: 100%;
        }

        /* nav > div:first-child {
            display: none;
        }

        nav a {
            text-decoration: none;
            color: #000;
            background-color: #FFF;
        }

        nav a:hover {
            color: #FFF;
            font-weight: bold;
            background-color: #31A2F0 !important;
        }

        nav > div:nth-child(2) > div:nth-child(2) > span > span > span {
            background-color: #E5E5E5 !important;
            color: #A5A5A5 !important;
        } */

        .pagination nav[role="navigation"] .flex a:first-of-type,
        .pagination nav[role="navigation"] .flex a:last-of-type,
        .pagination nav[role="navigation"] .flex span:first-of-type,
        .pagination nav[role="navigation"] .flex span:last-of-type {
            display: none;
        }

        .pagination a {
            background-color: transparent !important;
            color: #151515;
            border: 0 !important;
            text-decoration: none;
            margin-top: 10px;
        }

        .pagination a:hover {
            background-color: #31A2F0 !important;
            color: #FFFFFF;
            font-weight: bold;
            border: 0 !important;
            text-decoration: none;
            border-radius: 999px;
        }

        .pagination span[aria-disabled="true"] > span, .pagination span[aria-current="page"] > span {
            background-color:transparent !important;
            border: 0 !important;
            color: #A9A9A9;
        }

        .pagination .shadow-sm {
            box-shadow: none !important;
        }



        .custm-crd-cntainr {
            margin: 15px 0;
        }

        .custm-crd-cntainr a {
            text-decoration: none;
        }

        .custm-crd-cntainr .card {
            display: flex;
            flex-direction: column;
            height: 100%;
            border-radius: 20px;
            border: 0;

            box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;

            box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px,
                    rgba(0, 0, 0, 0.23) 0px 3px 6px;

            transition: background-color 0.3s ease,
                    color 0.3s ease,
                    transform 0.3s ease,
                    box-shadow 0.3s ease;
        }

        .custm-crd-cntainr .card:hover {
            background-color: #151515;
            color: #FFFFFF;

            transform: translateY(-4px);
            box-shadow: rgba(0, 0, 0, 0.25) 0px 6px 12px,
                    rgba(0, 0, 0, 0.3) 0px 6px 12px;
        }

        .custm-crd-cntainr .card .card-body {
            flex: 1 1 auto;
            padding-bottom: 0;
            background-color: transparent;
        }

        .custm-crd-cntainr .card .card-footer {
            border: 0;
            margin-top: auto;
            padding-top: 0;
            background-color: transparent;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        .custm-crd-cntainr .card .img-container {
            height: 300px;
            width: 100%;

            overflow: hidden;
        }

        .custm-crd-cntainr .card .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;

            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .custm-crd-cntainr .card:hover .img-container img {
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
        }




    </style>
@endsection

@section('content')

<section class="bg_black ">
    <div class="container">
        <div class="row text-center">
            <div class="col-xs-12 center-block col-sm-8">
                <h1 class="text-center">ARTICLES</h1>
                <p class="text-center">
                    Discover a wealth of knowledge and inspiration from industry experts and thought leaders through CREATEPhilippines' collection of articles.
                </p>
            </div>
        </div>
    </div>
</section>
<section >
    <div class="container">
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="container">
                    <!-- <div class="home_stories stories_page"> -->
                    <div class="row justify-content-center">

                        {{-- FEATURED ARTICLES --}}
                        <div class="col-12 custm-crd-cntainr">
                            <a href="{{ route('articles.view', ['slug' => $featuredArticle->latestSlug->value]) }}">
                                <div class="card">
                                    <div class="img-container" style="height: 450px !important;">
                                        <img src="{{ asset('folder_articles/' . $featuredArticle->asset->path) }}" 
                                            alt="image info" 
                                            class="img-fluid"
                                            onerror="this.onerror=null; this.src='{{ asset('img/banner-default.jpg') }}';"
                                            >
                                    </div>
                                    <div class="card-body">
                                        <h3>{{ $featuredArticle->name }}</h3>
                                    </div>
                                    <div class="card-footer">
                                        <p> @if($featuredArticle->author) By <strong>{{ $featuredArticle->author }}</strong>, @endif {{ \Carbon\Carbon::parse($featuredArticle->date)->format('F d, Y') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        
                        {{-- LATEST ARTICLES --}}
                        @foreach($latestArticles as $lArticle)

                        <div class="col col-12 col-md-6 custm-crd-cntainr">
                            <a href="{{ route('articles.view', ['slug' => $lArticle->latestSlug->value]) }}">
                                <div class="card">
                                    <div class="img-container">
                                        <img src="{{ asset('folder_articles/' . $lArticle->asset->path) }}" 
                                            alt="image info" 
                                            class="img-fluid"
                                            onerror="this.onerror=null; this.src='{{ asset('img/banner-default.jpg') }}';"
                                            >
                                    </div>
                                    <div class="card-body">
                                        <h3>{{ $lArticle->name }}</h3>
                                    </div>
                                    <div class="card-footer">
                                        <p> @if($lArticle->author) By <strong>{{ $lArticle->author }}</strong>, @endif {{ \Carbon\Carbon::parse($lArticle->date)->format('F d, Y') }}</p>
                                    </div>
                                </div>
                            </a> 
                        </div>
                        @endforeach
                    <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row pagination mt-5">
            <div class="col-12">
                <center>{{ $latestArticles->links() }}</center>
                
            </div>
        </div>

    </div>
</section>

@endsection