<aside class="main-sidebar control-sidebar sidebar-dark-primary elevation-4 admin-sidebar" id="control-sidebar" style="list-style: none; position:fixed;">
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
          {{ Auth::user()->name }}
        </div>
        
      </div>

     

      <!-- Sidebar Menu -->
      @include('dashboard.components.navigation')
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<div class="aside-button-holder">
  <a class="btn btn-primary aside-button" data-widget="control-sidebar" href="#">
    <i class="fas fa-bars"></i>
  </a>
</div>