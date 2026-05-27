<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PengamalApiController;

Route::get('/pengamal', [
  PengamalApiController::class,
  'index'
]);
