<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <meta name="csrf-token" content="<?php echo csrf_token(); ?>"> --}}

    <title>{{ config('app.name'.'| Admin Dashboard', 'CreatePhilippines'.'| Admin Dashboard') }}</title>

    <link rel="apple-touch-icon" sizes="180x180" href="/img/fav/pvt/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/fav/pvt/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/fav/pvt/favicon-16x16.png">
    <link rel="manifest" href="/img/fav/pvt/site.webmanifest">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('scripts-top')
    

    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.js"></script> -->

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="{{ URL::asset('fontawesome/js/all.min.js') }}"></script>
    <script src="{{ URL::asset('js/adminlte.min.js') }}"></script>
    <!-- <script src="{{ URL::asset('js/dashboard.js') }}"></script> -->

    

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,300;0,500;0,700;1,400;1,500;1,600&display=swap" rel="stylesheet"> 

    <!-- Styles -->
    <link href="{{ URL::asset('css/adminlte.min.css?ver='.time()) }}" rel="stylesheet">
    <link href="{{ URL::asset('css/app.css?ver='.time()) }}" rel="stylesheet">
    <link href="{{ URL::asset('css/admin.css?ver='.time()) }}" rel="stylesheet">

    @yield('styles')

    <!-- Fontawesome -->
    <link href="{{ URL::asset('fontawesome/css/all.min.css') }}" rel="stylesheet">

    {{--
    <!-- TinyMCE -->
    @include('components.tinymce')
    --}}

    

</head>
<body>
  <div class="dashboard-control">
    <a href="{{ url('admin') }}" title="Dashboard">
      <div>
        <i class="fa fa-home"></i>
      </div>
    </a>
    <!-- <a href="{{ url('admin/profile') }}" title="Profile">
      <div>
        <i class="fa fa-cog"></i>
      </div>
    </a> -->
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="LOGOUT">
      <div>
        <i class="fa fa-power-off"></i>
      </div>
    </a>
    
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>


  </div>
    <div id="app">
    @yield('userDash_appRequest')

      <aside class="main-sidebar sidebar-dark-primary elevation-4 admin-sidebar"  style="list-style: none; position:fixed;">
        <!-- Brand Logo -->
        <div class="logo-holder">
          <img src="{{ url('img/createph_white.png') }}" class="img-fluid" >
        </div>

        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="{{ url('img/default_profile_img.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
              {{ Auth::user()->name}}
            </div>
          </div>

          <!-- SidebarSearch Form -->
          {{-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
              <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-sidebar">
                  <i class="fas fa-search fa-fw"></i>
                </button>
              </div>
            </div>
          </div> --}}

          <!-- Sidebar Menu -->
          @include('admin.components.navigation')
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <main class="content-wrapper">
        @yield('contentAdmin')
    </main>
        
        

        
  </div>

    <script>
      // SET SIDE Navigation Height
      $(document).ready(function() {
        var pageHeight = $(document).height();
        $("aside").height(pageHeight);
      });

      // ADD additional input for portfolio
      $('#addWorkV2').click(function(){
          $('.vWork-2').toggle();
          $('.vWork-3').hide();
          $('#addWorkV2 > svg').toggleClass('fa-minus');
          $('#addWorkV2 > svg').toggleClass('fa-plus');
      });
      $('#addWorkV3').click(function(){
          $('.vWork-3').toggle();
          $('#addWorkV3 > svg').toggleClass('fa-minus');
          $('#addWorkV3 > svg').toggleClass('fa-plus');
      });
    </script>


    @yield('scripts-bottom')

    

</body>
</html>
