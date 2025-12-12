<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CreatePhilippines') }}</title>

    {{-- SEO / META DESCRIPTIONS --}}
    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <meta property="og:site_name" content="{{ config('app.name', 'CreatePhilippines') }}">
    <meta property="og:description" content="">
    <meta property="description" content="">
    <meta property="keywords" content="">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    @yield('scripts-top')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,300;0,500;0,700;1,400;1,500;1,600&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:wght@700&display=swap" rel="stylesheet"> 

    <!-- Styles -->
    @yield('styles')
    <link href="{{ asset('css/app.css?ver='.time()) }}" rel="stylesheet">
    <link href="{{ asset('css/site.css?ver='.time()) }}" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
    {{-- <link href="{{ asset('css/slick.css?ver='.time()) }}" rel="stylesheet"> --}}

    <!-- Fontawesome -->
    <link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet">

    

    <style>
        .btn-secondary{
            background-color: rgb(207, 58, 9);
            color: #FFFFFF;
        }
    </style>

</head>
<body style="padding-top: 0px;">

    <!-- <div id="app"> -->

        <main>
            <div class="row">
                <div class="col-12">
                    <img src="{{ asset('img/test_logo.png') }}" style="width: 200px;" alt="">
                </div>
            </div>
            
            <div class="row">
                <div class="col-1"></div>
                <div class="col-10">
                    <div class="row">
                        <div class="col-12 my-2">
                            <strong>Pages: </strong>
                            {{-- <a href="{{ route('admin.test.articles') }}" class="btn btn-primary" id="btnArticles">Articles</a>
                            <a href="{{ route('admin.test.stories') }}" class="btn btn-primary" id="btnStories">Creative Works</a>
                            <a href="{{ route('admin.test.profiles') }}" class="btn btn-primary" id="btnProfiles">Profiles</a> --}}

                            <a href="{{ route('test.articles') }}" class="btn btn-primary" id="btnArticles">Articles</a>
                            <a href="{{ route('test.stories') }}" class="btn btn-primary" id="btnStories">Creative Works</a>
                            <a href="{{ route('test.profiles') }}" class="btn btn-primary" id="btnProfiles">Profiles</a>
                            
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                        @yield('content')
                        </div>
                    </div>
                </div>
                <div class="col-1"></div>
                
            </div>
            
        </main>

        
    @yield('scripts-bottom')
        
    <!-- </div> -->


</body>
</html>
