<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PengamalApiController;

Route::middleware([
  'auth:sanctum',
  'role:superAdmin|admin-provinsi|admin-kabupaten|admin-kecamatan|admin-desa'
])->group(function () {

  Route::get(
    '/pengamal',
    [PengamalApiController::class, 'index']
  );
});
