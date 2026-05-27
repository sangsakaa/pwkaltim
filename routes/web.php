<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Administrator\PengamalController;
use App\Http\Controllers\Administrator\UserRoleController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramKerjaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratTugasController;
use App\Http\Controllers\WilayahController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('welcome'));

Route::get('/dashboard', [\App\Http\Controllers\Administrator\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('admin.dashboard');

/*
|--------------------------------------------------------------------------
| PENGAMAL (PUBLIC + ADMIN)
|--------------------------------------------------------------------------
*/

// PUBLIC
Route::get('/daftar-pengamal', [PengamalController::class, 'createPublic'])
    ->name('pengamal.public.create');

// ADMIN
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/pengamal', [PengamalController::class, 'index'])
        ->name('pengamal.index');

    Route::get('/pengamal/create', [PengamalController::class, 'create'])
        ->name('pengamal.create');

    Route::get('/pengamal/show/{pengamal}', [PengamalController::class, 'show'])->name('pengamal.show');

    Route::delete('/pengamal/show/{pengamal}', [PengamalController::class, 'destroy']);

    Route::get('/pengamal/edit/{pengamal}', [PengamalController::class, 'edit'])
        ->name('pengamal.edit');

    Route::put('/pengamal/update/{pengamal}', [PengamalController::class, 'update'])
        ->name('pengamal.update');
});

Route::post('/pengamal/store', [PengamalController::class, 'store'])
    ->name('pengamal.store');

/*
|--------------------------------------------------------------------------
| WILAYAH API
|--------------------------------------------------------------------------
*/

Route::get('/get-regencies/{province}', [PengamalController::class, 'getRegencies']);
Route::get('/get-districts/{regency}', [PengamalController::class, 'getDistricts']);
Route::get('/get-villages/{district}', [PengamalController::class, 'getVillages']);


Route::get(
    '/pengamal/sync',
    [PengamalController::class, 'sync']
)
    ->middleware('role:superAdmin|admin-provinsi')
    ->name('pengamal.sync');

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ROLES & USERS
|--------------------------------------------------------------------------
*/

Route::resource('roles', RoleController::class)
    ->middleware([
        'auth',
        'verified',
        'role:admin-provinsi|superAdmin'
    ]);

Route::middleware([
    'auth',
    'verified',
    'role:admin-provinsi|superAdmin'
])->group(function () {

    Route::get('/users/assign-role', [UserRoleController::class, 'index'])
        ->name('users.assign-role-index');

    Route::get('/users/create', [UserRoleController::class, 'create'])
        ->name('users.create');

    Route::post('/users/create', [UserRoleController::class, 'storeUser'])
        ->name('users.store');

    Route::get('/users/{user}/assign-role', [UserRoleController::class, 'edit'])
        ->name('users.assign-role');

    Route::post('/users/{user}/assign-role', [UserRoleController::class, 'update'])
        ->name('users.assign-role.update');

    Route::post('/users/{user}/change-role', [UserRoleController::class, 'changeRole'])
        ->name('users.change-role');

    Route::delete('/users/remove-role-permission/{user}', [UserRoleController::class, 'removeRolePermission'])
        ->name('users.remove-role-permission');

    Route::delete('/users-delete/{user}', [UserRoleController::class, 'destroy'])
        ->name('users.destroy');

    Route::post('/users/reset-password', [UserRoleController::class, 'resetPassword']);
});
/*
|--------------------------------------------------------------------------
| WILAYAH
|--------------------------------------------------------------------------
*/

Route::get('/wilayah', [WilayahController::class, 'index'])
    ->name('wilayah.index');

Route::get('/wilayah/province/{province}', [WilayahController::class, 'province'])
    ->name('wilayah.province');

Route::get('/wilayah/regency/{regency}', [WilayahController::class, 'show'])
    ->name('wilayah.show');

Route::get('/wilayah/district/{district}', [WilayahController::class, 'detailshow'])
    ->name('wilayah.detail');



Route::get('/laporan', [LaporanController::class, 'laporan'])
    ->middleware(['auth', 'verified'])
    ->name('laporan.laporan');

Route::get('/laporan-file', [LaporanController::class, 'index'])
    ->name('laporan-file.index');

Route::get('/laporan/download', [LaporanController::class, 'downloadLaporan'])
    ->name('laporan.download');

/*
|--------------------------------------------------------------------------
| SURAT
|--------------------------------------------------------------------------
*/

Route::resource('surat', SuratKeluarController::class);

Route::post('/surat/{id}/upload', [SuratKeluarController::class, 'upload'])
    ->name('surat.upload');

Route::get('/surat/file/{fileId}/download', [SuratKeluarController::class, 'downloadFile'])
    ->name('surat.file.download');

Route::delete('/surat/file/{fileId}', [SuratKeluarController::class, 'deleteFile'])
    ->name('surat.file.delete');

Route::get('/surat/file/{id}/view', [SuratKeluarController::class, 'viewFile'])
    ->name('surat.file.view');

/*
|--------------------------------------------------------------------------
| SURAT MASUK
|--------------------------------------------------------------------------
*/

Route::resource('surat-masuk', SuratMasukController::class);

Route::get('/export/surat-masuk', [SuratMasukController::class, 'exportSuratMasuk']);

/*
|--------------------------------------------------------------------------
| SURAT TUGAS
|--------------------------------------------------------------------------
*/

Route::resource('surat-tugas', SuratTugasController::class);

Route::get('/surat-tugas/{id}/pdf', [SuratTugasController::class, 'cetakPdf'])
    ->name('surat-tugas.pdf');

/*
|--------------------------------------------------------------------------
| PROGRAM KERJA
|--------------------------------------------------------------------------
*/

Route::resource('program-kerja', ProgramKerjaController::class);

Route::get('/program-kerja/export/{waktu}', [ProgramKerjaController::class, 'exportPdf'])
    ->name('program-kerja.exportPdf');

Route::get('/program-kerja/export/pdf/{waktu}', [ProgramKerjaController::class, 'exportPdf'])
    ->name('program-kerja.export.pdf');

/*
|--------------------------------------------------------------------------
| DEPARTEMEN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::resource('departemen', DepartemenController::class);
});

/*
|--------------------------------------------------------------------------
| POST
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');

    Route::post('/post/store', [PostController::class, 'store'])->name('post.store');

    Route::get('/post/approval', [PostController::class, 'approval'])->name('post.approval');

    Route::put('/post/{id}/approve', [PostController::class, 'approve']);

    Route::get('/post/approved', [PostController::class, 'approvedList'])->name('post.approved');

    Route::get('/post/rejected-after-approval', [PostController::class, 'rejectedAfterApproval'])
        ->name('post.rejected.after.approval');

    Route::delete('/post/{id}', [PostController::class, 'destroy'])->name('post.destroy');
});

Route::get('/post-detail/{id}', [PostController::class, 'showPublic'])
    ->name('post.public.show');

/*
|--------------------------------------------------------------------------
| ACTIVITY LOG
|--------------------------------------------------------------------------
*/

Route::get('/admin/activity-logs', [ActivityLogController::class, 'index'])
    ->name('activity.logs');

/*
|--------------------------------------------------------------------------
| BUTTON SHOWCASE
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/buttons/text', fn() => view('buttons-showcase.text'))->name('buttons.text');
    Route::get('/buttons/icon', fn() => view('buttons-showcase.icon'))->name('buttons.icon');
    Route::get('/buttons/text-icon', fn() => view('buttons-showcase.text-icon'))->name('buttons.text-icon');
});

require __DIR__ . '/auth.php';
