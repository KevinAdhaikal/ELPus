<!-- resources/views/layouts/sidebar.blade.php -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="/" class="brand-link">
    <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <li class="section_check" data-value="0">
        <ul class="nav nav-pills nav-sidebar flex-column">
          <li class="nav-header">DASHBOARD</li>
          <li class="nav-item">
            <a href="{{ isRoute('dashboard') }}" class="nav-link {{ isActive('dashboard') }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
        </ul>
      </li>
      <li class="section_check" data-value="0">
        <ul class="nav nav-pills nav-sidebar flex-column">
          <li class="nav-item">
            <hr style="border-color: rgba(255,255,255,0.1); margin: 8px 0;">
          </li>
          <li class="nav-header">ADMIN</li>
          <li class="nav-item">
            <a href="{{ isRoute("admin.users") }}" class="nav-link {{ isActive('admin.users') }}" data-url="/users">
              <i class="nav-icon fas fa-users"></i>
              <p>Users</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ isRoute("admin.rp") }}" class="nav-link {{ isActive('admin.rp') }}" data-url="/rp">
              <i class="nav-icon fas fa-user-tag"></i>
              <p>Roles & Permissions</p>
            </a>
          </li>
        </ul>
      </li>
    </nav>
  </div>
</aside>