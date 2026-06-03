<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('userHasRole')) {
  function userHasRole($role)
  {
    return Auth::check() && Auth::user()->hasRole($role);
  }
}

if (!function_exists('userHasAnyRole')) {
  function userHasAnyRole(array $roles)
  {
    return Auth::check() && Auth::user()->hasAnyRole($roles);
  }
}

if (!function_exists('userIsSuperAdmin')) {
  function userIsSuperAdmin()
  {
    return userHasRole('superAdmin');
  }
}
