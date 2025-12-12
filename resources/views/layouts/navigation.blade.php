<!-- Left Side Of Navbar -->
<ul class="navbar-nav mx-auto">
    {{-- <li class="nav-item {{ (Request::segment(1) == 'newsfeed') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('newsfeed/articles') }}">Newsfeed</a>
    </li> --}}

    <li class="nav-item {{ (Request::segment(1) == 'directory' || Request::segment(1) == 'story') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('directory') }}">Directory of Creatives</a>
    </li>

    <li class="nav-item dropdown {{ Request::segment(1) == 'events' ? 'active' : '' }}">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            CREATEPH x
            </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            
            <div class="dropdown-submenu">
                <a class="dropdown-item dropdown-toggle" href="#">Animation </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('events.animahenasyon') }}">Animahenasyon</a>
                </div>
            </div>

            <div class="dropdown-submenu">
                <a class="dropdown-item dropdown-toggle" href="#">Communication Design </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('events.create-lab') }}">CREATELab</a>
                </div>
            </div>

            <div class="dropdown-submenu">
                <a class="dropdown-item dropdown-toggle" href="#">Game Development </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('events.pgdx-2025') }}">PGDX</a>
                </div>
            </div>

            <div class="dropdown-submenu">
                <a class="dropdown-item dropdown-toggle" href="#">Music and Performing Arts </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('events.bmc-2026') }}">BMC</a>
                    <a class="dropdown-item" href="{{ route('events.createph-x-mipam') }}#sonik-sessions">MIPAM</a>
                </div>
            </div>

            <div class="dropdown-submenu">
                <a class="dropdown-item dropdown-toggle" href="#">Visual Arts </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Coming Soon</a>
                </div>
            </div>




        
            {{--
                
                
            --}}
            {{--
            <a class="dropdown-item" href="{{ route('events.creative-futures') }}">Creative Futures</a>
            <a class="dropdown-item" href="{{ route('events.calendar') }}">Calendar</a>
            --}}
        </div>
    </li>

    <li class="nav-item dropdown {{ Request::segment(1) == 'discover' ? 'active' : '' }}">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Discover
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('articles') }}">Articles</a>
            <a class="dropdown-item" href="{{ route('events.creative-events') }}">Creative Events</a>
            <a class="dropdown-item" href="{{ route('featuredCreatives') }}">Creative Features</a>
            <a class="dropdown-item" href="{{ route('connect-creative.index') }}">Connect with a Creative</a>
        </div>
    </li>

    <li class="nav-item dropdown {{ Request::segment(1) == 'resources' ? 'active' : '' }}">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Resources
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('resources.helpful-links') }}">Helpful Learning Links</a>
        </div>
    </li>

    <li class="nav-item dropdown {{ Request::segment(1) == 'about-us' ? 'active' : '' }}">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          About Us
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ route('about-us.create-philippines') }}">About CREATEPhilippines</a>
          <a class="dropdown-item" href="{{ route('about-us.organizers') }}">About CITEM</a>
          <!-- <a class="dropdown-item" href="{{ route('about-us.partners') }}">Partners</a> -->
        </div>
    </li> 

    <li class="nav-item {{ Request::segment(1) == 'contact-us' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('contact-us') }}">Contact Us</a>
    </li>


    


    {{--

    <!-- <li class="nav-item {{ (Request::segment(1) == 'everything-creative' || Request::segment(1) == 'everything_creative') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('everything-creative') }}"><b>Everything Creative</b></a>
        <div class="new">NEW</div>
    </li> -->
    
    
    <li class="nav-item dropdown {{ Request::segment(1) == 'resources' ? 'active' : '' }}">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Resources
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <!-- <a class="dropdown-item" href="{{ route('resources.laws-and-bills') }}">Related Laws & Bills</a>
            <a class="dropdown-item" href="{{ route('resources.news') }}">Industry News</a>
            <div class="dropdown-divider"></div> -->
            <a class="dropdown-item" href="https://business.gov.ph/">Philippine Business Hub</a>
            <a class="dropdown-item" href="https://www.taxumo.com/">Taxumo</a>
        </div>
    </li>
    <!-- <li class="nav-item dropdown {{ Request::segment(1) == 'business-solutions-services' ? 'active' : '' }}">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Services
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ route('business-solutions-services.about') }}">About Business Solutions Services</a>
          <a class="dropdown-item" href="{{ route('business-solutions-services.directory') }}">Business Solutions Partners</a>
          <a class="dropdown-item" href="{{ route('business-solutions-services.programs-and-offers') }}">Programs and Offers</a>
        </div>
    </li> -->
    

    --}}
</ul>
 
<!-- Right Side Of Navbar -->
<ul class="navbar-nav mx-auto">

    <li class="nav-item search_nav">
        <form class="navbar-form navbar-left" role="search" method="GET" id="navSearchForm" action="{{ route('search') }}">
            <div class="form-group">
              <input type="text" class="form-control" id="search" name="search" placeholder="Search">
              <button type="submit" id="navSearchBtn" class="btn btn-default"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>
    </li>
    
    <!-- Authentication Links -->
    
    @guest
        @if (Route::has('login'))
            <li class="nav-item {{ (Request::segment(1) == 'login') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
        @endif

        @if (Route::has('register.step-one'))
            <li class="nav-item {{ (Request::segment(1) == 'register') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('register.step-one') }}">{{ __('Register') }}</a>
            </li>
        @endif
    @else
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }}
            </a>

            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                @userverifiedunverified
                {{--
                <a class="dropdown-item" href="{{ route('profile') }}">Profile</a>
                <a class="dropdown-item" href="{{ route('newsfeed.index') }}">Newsfeed</a>
                <a class="dropdown-item" href="{{ route('dashboard.index') }}">Dashboard</a>
                --}}
                @enduserverifiedunverified

                @admin
                    <a class="dropdown-item" href="{{ route('admin.index') }}">Admin Dashboard</a>
                @endadmin

                @user
                    <a class="dropdown-item" href="{{ route('user.index') }}">User Dashboard</a>
                @enduser



                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    @endguest

    <li class="nav-item">
        <div id="google_translate_element"></div>
    </li>
    
</ul> 