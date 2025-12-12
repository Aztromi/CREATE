<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
      <li class="nav-item">
        CREATIVES
      </li>

      @adminog
      <li class="nav-item">
        <a href="{{ url('admin/application-requests') }}" class="nav-link">
          <i class="nav-icon fa fa-paintbrush"></i>
          <p>
            Creatives
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('admin.creativeWorks.index') }}" class="nav-link">
          <i class="nav-icon fa fa-swatchbook"></i>
          <p>
            Creative Works
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('admin.connect-creative.list') }}" class="nav-link">
          <i class="nav-icon fa fa-users-line"></i>
          <p>
            Connect Creatives
          </p>
        </a>
      </li>
      <hr>
      @endadminog
      
      @admineditor
      <li class="nav-item">
        <a href="{{ route('admin.article-list') }}" class="nav-link">
          <i class="nav-icon fa fa-book-open"></i>
          <p>
            Articles
          </p>
        </a>
      </li>
      @endadmineditor

      <!-- <li class="nav-item">
        CATEGORY
      </li>
      <li class="nav-item">
        <a href="{{ url('admin/creative-industries') }}" class="nav-link">
          <i class="nav-icon fa fa-swatchbook"></i>
          <p>
            Creative Industries
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ url('admin/creative-fields') }}" class="nav-link">
          <i class="nav-icon fa fa-tags"></i>
          <p>
            Creative Fields
          </p>
        </a>
      </li>
      <hr> -->

      <!-- <li class="nav-item">
        PARTNERS
      </li>
      <li class="nav-item">
        <a href="{{ url('admin/partners') }}" class="nav-link">
          <i class="nav-icon fa fa-globe-asia"></i>
          <p>
            Partner List
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ url('admin/business-solutions-services') }}" class="nav-link">
          <i class="nav-icon fa fa-hands-helping"></i>
          <p>
            Business Solutions Services
          </p>
        </a>
      </li>
      <hr>
      <li class="nav-item">
        EVENTS
      </li>
      <li class="nav-item">
        <a href="{{ url('admin/calendar') }}" class="nav-link">
          <i class="nav-icon fa fa-calendar"></i>
          <p>
            Calendar
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ url('admin/creative-futures') }}" class="nav-link">
          <i class="nav-icon fa fa-route"></i>
          <p>
            Creative Futures
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ url('admin/speakers') }}" class="nav-link">
          <i class="nav-icon fa fa-address-card"></i>
          <p>
            Creative Futures: Speakers
          </p>
        </a>
      </li>
      <hr>
      <li class="nav-item">
        USERS
      </li>
      <li class="nav-item">
        <a href="{{ url('admin/user-list') }}" class="nav-link">
          <i class="nav-icon fa fa-users-cog"></i>
          <p>
            User List
          </p>
        </a>
      </li>
      <hr>
      <li class="nav-item">
        PAGES
      </li> -->


      <!-- <li class="nav-item">
          <a class="nav-link" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
              USERS
          </a>
          <div class="collapse" id="collapseExample">
              <div class="card card-body bg-transparent">
                <a class="nav-link" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    USERS
                </a>
              </div>
          </div>
      </li> -->
      @adminsuper
      <li class="nav-item">
        <a href="{{ url('admin/user-list') }}" class="nav-link">
          <i class="nav-icon fa fa-users-cog"></i>
          <p>
            Users
          </p>
        </a>
      </li>
      @endadminsuper
           
      <li class="nav-item">
        <a href="{{ route('admin.changePassword') }}" class="nav-link">
          <i class="nav-icon fa fa-key"></i>
          <p>
            Change Password
          </p>
        </a>
      </li>



      <!-- <li class="nav-item">
        <a href="{{ route('user.index') }}" class="nav-link">
          <i class="nav-icon fa fa-home"></i>
          <p>
            Home
          </p>
        </a>
      </li> -->
    </ul>
  </nav>