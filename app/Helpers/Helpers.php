<?php

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