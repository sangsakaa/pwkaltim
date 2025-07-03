<?php

use App\Models\Pengamal;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\Administrator\PengamalController;
use App\Http\Controllers\Administrator\DashboardController;

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



// WILAYAH
Route::get('/get-regencies/{provinceId}', [PengamalController::class, 'getRegencies']);
Route::get('/get-districts/{regencyId}', [PengamalController::class, 'getDistricts']);
Route::get('/get-villages/{districtId}', [PengamalController::class, 'getVillages']);

// roles and permissions
Route::resource('roles', RoleController::class);



// usermanagement
Route::get('/users/create', [UserRoleController::class, 'create'])->name('users.create');
Route::post('/users/create', [UserRoleController::class, 'storeUser']);
Route::get('/users/assign-role', [UserRoleController::class, 'index'])->name('users.assign-role-index');
Route::get('/users/{user}/assign-role', [UserRoleController::class, 'edit'])->name('users.assign-role');
Route::post('/users/{user}/assign-role', [UserRoleController::class, 'update'])->name('users.assign-role.update');

// wilayah
Route::get('/wilayah', [\App\Http\Controllers\WilayahController::class, 'index'])->name('wilayah.index');
Route::get('/wilayah/{regency}', [\App\Http\Controllers\WilayahController::class, 'show'])->name('wilayah.show');

















































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
