<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Administrator\PengamalController;



Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [\App\Http\Controllers\Administrator\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/pengamal', [PengamalController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('pengamal.index');
Route::get('/pengamal/create', [PengamalController::class, 'create'])
    ->middleware(['auth', 'verified']);

Route::get('/pengamal/show/{pengamal}', [PengamalController::class, 'show']);
Route::delete('/pengamal/show/{pengamal}', [PengamalController::class, 'destroy'])
    ->middleware(['auth', 'verified']);
Route::get('/pengamal/edit/{pengamal}', [PengamalController::class, 'edit'])
    ->middleware(['auth', 'verified'])
    ->name('pengamal.edit');
Route::put('/pengamal/update/{pengamal}', [PengamalController::class, 'update'])
    ->middleware(['auth', 'verified'])
    ->name('pengamal.update');
Route::post('/pengamal/store', [PengamalController::class, 'store']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




















































Route::get('/buttons/text', function () {
    return view('buttons-showcase.text');
})->middleware(['auth'])->name('buttons.text');

Route::get('/buttons/icon', function () {
    return view('buttons-showcase.icon');
})->middleware(['auth'])->name('buttons.icon');

Route::get('/buttons/text-icon', function () {
    return view('buttons-showcase.text-icon');
})->middleware(['auth'])->name('buttons.text-icon');

require __DIR__ . '/auth.php';
