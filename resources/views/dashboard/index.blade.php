<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> 

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name'.' | User Dashboard', 'CreatePhilippines'.' | User Dashboard') }}</title>


    <link rel="apple-touch-icon" sizes="180x180" href="/img/fav/pbc/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/fav/pbc/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/fav/pbc/favicon-16x16.png">
    <link rel="manifest" href="/img/fav/pbc/site.webmanifest">
    
    

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,300;0,500;0,700;1,400;1,500;1,600&display=swap" rel="stylesheet"> 

    <!-- Styles -->
    <link href="{{ URL::asset('css/adminlte.min.css?ver='.time()) }}" rel="stylesheet">
    <link href="{{ URL::asset('css/adminlte.min.css.map?ver='.time()) }}" rel="stylesheet">
    <link href="{{ URL::asset('css/app.css?ver='.time()) }}" rel="stylesheet">
    <link href="{{ URL::asset('css/admin.css?ver='.time()) }}" rel="stylesheet">
    <link href="{{ URL::asset('css/user-dashboard.css?ver='.time()) }}" rel="stylesheet">

    <!-- Fontawesome -->
    <link href="{{ URL::asset('fontawesome/css/all.min.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('scripts-top')

    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.js"></script> -->

    {{--
    <!-- TinyMCE -->
    @include('dashboard.components.tinymce')
    --}}

    @yield('styles')
    
</head>
<body>
    <div id="app">

      @include('dashboard.components.sidebar')

      <main class="content-wrapper">
        <header>
          <div class="row">
            <div class="container">
              <div class="col">
                <div class="logo-holder">
                  <img src="{{ url('img/logo.png') }}" >
                </div>
              </div>
            </div>
          </div>
        </header>
        {{-- Content --}}
        @yield('userDashboard')
    </main>
        
        

        
  </div>

  @include('dashboard.components.script')
  @yield('scripts-bottom')

</body>
</html>
