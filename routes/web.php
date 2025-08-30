<?php

use App\Models\Pengamal;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\ProgramKerjaController;
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
    ->name('admin.dashboard');

Route::get('/pengamal', [PengamalController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('pengamal.index');
Route::get('/pengamal/create', [PengamalController::class, 'create'])
    ->middleware(['auth', 'verified'])->name('pengamal.create');

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
Route::get('/get-regencies/{provinceId}', [PengamalController::class, 'getRegencies'])->middleware(['auth', 'verified']);
Route::get('/get-districts/{regencyId}', [PengamalController::class, 'getDistricts'])->middleware(['auth', 'verified']);
Route::get('/get-villages/{districtId}', [PengamalController::class, 'getVillages'])->middleware(['auth', 'verified']);

// roles and permissions
Route::resource('roles', RoleController::class)->middleware(['auth', 'verified']);



// usermanagement
Route::get('/users/assign-role', [UserRoleController::class, 'index'])->name('users.assign-role-index')->middleware(['auth', 'verified']);
Route::get('/users/create', [UserRoleController::class, 'create'])->name('users.create')->middleware(['auth', 'verified']);
Route::post('/users/create', [UserRoleController::class, 'storeUser']);
Route::get('/users/{user}/assign-role', [UserRoleController::class, 'edit'])->name('users.assign-role')->middleware(['auth', 'verified']);
Route::post('/users/{user}/assign-role', [UserRoleController::class, 'update'])->name('users.assign-role.update')->middleware(['auth', 'verified']);
// routes/web.php

Route::delete('/users/remove-role-permission/{user}', [UserRoleController::class, 'removeRolePermission'])->name('users.remove-role-permission');
Route::delete('/users-delete/{user}', [UserRoleController::class, 'destroy'])->name('users.destroy');
// RESET PASWORD
Route::post('/users/reset-password', [UserRoleController::class, 'resetPassword'])->middleware(['auth', 'verified']);




// wilayah
Route::get('/wilayah', [\App\Http\Controllers\WilayahController::class, 'index'])->name('wilayah.index')->middleware(['auth', 'verified']);
Route::get('/wilayah/{regency}', [\App\Http\Controllers\WilayahController::class, 'show'])->name('wilayah.show')->middleware(['auth', 'verified']);
Route::get('/wilayah-desa/{regency}', [\App\Http\Controllers\WilayahController::class, 'detailshow'])->name('wilayah.show')->middleware(['auth', 'verified']);


// laporan
Route::get('/laporan', [LaporanController::class,  'laporan'])->name('laporan.laporan')->middleware(['auth', 'verified']);


// SURAT

Route::resource('surat', SuratKeluarController::class);
Route::post('/surat/{id}/upload', [SuratKeluarController::class, 'upload'])->name('surat.upload');
Route::get('/surat/file/{fileId}/download', [SuratKeluarController::class, 'downloadFile'])->name('surat.file.download');
Route::delete('/surat/file/{fileId}', [SuratKeluarController::class, 'deleteFile'])->name('surat.file.delete');
Route::get('/surat/file/{id}/view', [SuratKeluarController::class, 'viewFile'])->name('surat.file.view');

// SURAT MASUK
Route::resource('surat-masuk', SuratMasukController::class);

#PROGRAM KERJA
Route::resource('program-kerja', ProgramKerjaController::class);
// Route::put('/program-kerja/{program_kerja}', [ProgramKerjaController::class, 'update'])
//     ->name('program-kerja.update');

Route::get('program-kerja/export/pdf/{waktu}', [ProgramKerjaController::class, 'exportPdf'])
    ->name('program-kerja.export.pdf');


// departemen
Route::middleware(['auth'])->group(function () {
    Route::resource('departemen', DepartemenController::class)
        ->parameters(['departemen' => 'departemen']);
});

// post


// Form create post + simpan post
Route::middleware(['auth'])->group(function () {
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/post/store', [PostController::class, 'store']);
    Route::get('/post/approval', [PostController::class, 'approval'])->name('post.approval');
    Route::put('/post/{id}/approve', [PostController::class, 'approve']);
    Route::get('/post/approved', [PostController::class, 'approvedList'])->name('post.approved');
    Route::get('/post/rejected-after-approval', [PostController::class, 'rejectedAfterApproval'])->name('post.rejected.after.approval');
    Route::delete('/post/{id}', [PostController::class, 'destroy'])->name('post.destroy');
});
Route::get('/post-detail/{id}', [PostController::class, 'showPublic'])->name('post.public.show');





// LOG
// Route::middleware(['auth', 'can:view-activity-log'])->get('/admin/activity-logs', [ActivityLogController::class, 'index'])->name('activity.logs');
Route::get('/admin/activity-logs', [ActivityLogController::class, 'index'])->name('activity.logs');









































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
