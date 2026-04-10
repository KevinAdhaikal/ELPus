<!-- resources/views/layouts/navbar.blade.php -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
<!-- Left navbar links -->
<ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>
  
  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown user-menu">
      <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <img src="{{ asset('profile_img/' . Auth::user()->profile_img) }}" class="user-image img-circle elevation-2" alt="User Image">
        <span class="d-none d-md-inline" id="name_profile1"> {{ Auth::user()->full_name }}</span>
      </a>
      <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
        <!-- User image -->
        <li class="user-header text-center">
          <img id="profile_img2" src="/profile_img/default.svg" class="img-circle elevation-2 mb-2" alt="User Image">
          <h6 class="mb-2"> {{ Auth::user()->full_name }}</h6>
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
          <a href="{{ route('profile') }}" class="btn btn-default btn-flat nav-redirect" data-url="/profile">Profile</a>
          <a href="{{ route('logout') }}" class="btn btn-default btn-flat float-right" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a>
          <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display: none;">
            @csrf
          </form>
        </li>
      </ul>
    </li>
  </ul>
</nav>