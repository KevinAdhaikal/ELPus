<?php

use App\Models\Roles;
use Illuminate\Support\Facades\Route;

if (!function_exists('isActive')) {
    function isActive($routeName)
    {
        return Route::currentRouteName() == $routeName ? 'active' : '';
    }
}

if (!function_exists('isRoute')) {
    function isRoute($routeName)
    {
        return Route::currentRouteName() == $routeName ? '#' : route($routeName);
    }
}

if (!function_exists('redirectPermissionRoutes')) {
    function redirectPermissionRoutes($user) {
        $routes = [
            Roles::DAFTAR_BUKU => 'daftar_buku',
            Roles::PINJAM_LIHAT_SENDIRI => 'list_pinjaman',
            Roles::MANAJEMEN_BUKU_LIHAT => 'admin.manage_buku',
            Roles::PINJAM_LIHAT_SEMUA => 'admin.peminjaman',
            Roles::ADMINISTRATOR => 'daftar_buku'
        ];

        foreach ($routes as $permission => $routeName) {
            if ($user->hasPermission($permission)) {
                return $routeName;
            }
        }
        return "login";
    }
}