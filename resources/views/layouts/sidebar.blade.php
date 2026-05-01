<?php
use App\Models\Roles;
?>

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
      <ul class="nav nav-pills nav-sidebar flex-column">
        @if (auth()->user()->hasPermission(Roles::DAFTAR_BUKU | Roles::ADMINISTRATOR))
        <li class="nav-item">
          <a href="{{ isRoute('daftar_buku') }}" class="nav-link {{ isActive('daftar_buku') }}">
            <i class="nav-icon fas fa-book"></i>
            <p>
              Daftar Buku
            </p>
          </a>
        </li>
        @endif
        @if (auth()->user()->hasPermission(ROLES::PINJAM_LIHAT_SENDIRI | ROLES::ADMINISTRATOR))
        <li class="nav-item">
          <a href="{{ isRoute('list_peminjaman') }}" class="nav-link {{ isActive('list_peminjaman') }}">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>
              List Peminjaman
            </p>
          </a>
        </li>
        @endif
      </ul>
      @if (auth()->user()->hasPermission(ROLES::ADMINISTRATOR | ROLES::MANAJEMEN_BUKU_LIHAT | ROLES::PINJAM_LIHAT_SEMUA))
      <li class="section_check">
        <ul class="nav nav-pills nav-sidebar flex-column">
          <li class="nav-header">ADMIN</li>
          @if (auth()->user()->hasPermission(ROLES::ADMINISTRATOR | ROLES::MANAJEMEN_BUKU_LIHAT))
          <li class="nav-item">
            <a href="{{ isRoute("admin.manage_buku") }}" class="nav-link {{ isActive('admin.manage_buku') }}">
              <i class="nav-icon fas fa-book"></i>
              <p>Manage Buku</p>
            </a>
          </li>
          @endif
          @if (auth()->user()->hasPermission(ROLES::ADMINISTRATOR | ROLES::PINJAM_LIHAT_SEMUA))
          <li class="nav-item">
            <a href="{{ isRoute("admin.peminjaman") }}" class="nav-link {{ isActive('admin.peminjaman') }}">
              <i class="nav-icon fas fa-clipboard-list"></i>
              <p>Peminjaman</p>
            </a>
          </li>
          @endif
          @if (auth()->user()->hasPermission(ROLES::ADMINISTRATOR))
          <li class="nav-item">
            <a href="{{ isRoute("admin.users") }}" class="nav-link {{ isActive('admin.users') }}">
              <i class="nav-icon fas fa-users"></i>
              <p>Users</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ isRoute("admin.rp") }}" class="nav-link {{ isActive('admin.rp') }}">
              <i class="nav-icon fas fa-user-tag"></i>
              <p>Roles & Permissions</p>
            </a>
          </li>
          @endif
        </ul>
      </li>
      @endif
    </nav>
  </div>
</aside>