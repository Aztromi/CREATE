<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->

      <!-- <li class="nav-item">
        <a href="{{ url('dashboard/announcements') }}" class="nav-link">
          <i class="nav-icon fa fa-exclamation-circle"></i>
          <p>
            Announcements
          </p>
        </a>
      </li>
      <hr> -->
      <li class="nav-item">
        <a href="{{ route('user.edit-account') }}" class="nav-link">
          <i class="nav-icon fa fa-user-shield"></i>
          <p>
            Account
          </p>
        </a>
      </li>
      <hr>


      @userverifiedunverified    
      <li class="nav-item">
        <a href="{{ route('user.creativeWorks.index') }}" class="nav-link">
          <i class="nav-icon fa fa-swatchbook"></i>
          <p>
            Creative Works
          </p>
        </a>
      </li>
      @enduserverifiedunverified

      <li class="nav-item">
        <a href="{{ route('user.connect-creative.memberAdd') }}" class="nav-link">
          <i class="nav-icon fa fa-users-line"></i>
          <p>
            Connect with Creatives
          </p>
        </a>
      </li>


      <li class="nav-item">
        <a href="{{ route('user.bookmarks.index') }}" class="nav-link">
          <i class="nav-icon fa fa-bookmark"></i>
          <p>
            Bookmarks
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('user.changePassword') }}" class="nav-link">
          <i class="nav-icon fa fa-key"></i>
          <p>
            Change Password
          </p>
        </a>
      </li>

      <!-- <li class="nav-item">
        <a href="{{ url('dashboard/engagements') }}" class="nav-link">
          <i class="nav-icon fa fa-chart-line"></i>
          <p>
            Engagements
          </p>
        </a>
      </li>
      <hr> -->

      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
      </form>

      <li class="nav-item">
        <a href="#" 
          onclick="event.preventDefault();
          document.getElementById('logout-form').submit();" class="nav-link">
          <i class="nav-icon fa fa-power-off"></i>
          <p>
            LOGOUT
          </p>
        </a>
      </li>
    </ul>
  </nav>