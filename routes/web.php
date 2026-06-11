<?php

use App\Http\Controllers\{ActivityLogController, ProfileController, RoleController, WilayahController, LaporanController, PostController, DepartemenController, ProgramKerjaController, ReservationController, ScanController, SuratKeluarController, SuratMasukController, SuratTugasController};
use App\Http\Controllers\Administrator\{DashboardController, PengamalController, UserRoleController};
use App\Http\Controllers\PeriodeTahunanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('home'))->name('home');

/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');
});

/*
|--------------------------------------------------------------------------
| PENGAMAL
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/daftar-pengamal', [PengamalController::class, 'createPublic'])
    ->name('pengamal.public.create');

Route::post('/daftar-pengamal', [PengamalController::class, 'store'])
    ->name('pengamal.public.store');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    Route::resource('pengamal', PengamalController::class);

    Route::get('/pengamal/export/excel', [PengamalController::class, 'exportExcel'])
        ->name('pengamal.export.excel');
});
/*
|--------------------------------------------------------------------------
| WILAYAH API
|--------------------------------------------------------------------------
*/
Route::get('/get-regencies/{province}', [PengamalController::class, 'getRegencies']);
Route::get('/get-districts/{regency}', [PengamalController::class, 'getDistricts']);
Route::get('/get-villages/{district}', [PengamalController::class, 'getVillages']);

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/users/{user}/edit-profile', [ProfileController::class, 'editUser'])
        ->name('users.profile.edit');

    Route::patch('/users/{user}/edit-profile', [ProfileController::class, 'updateUser'])
        ->name('users.profile.update');
});

/*
|--------------------------------------------------------------------------
| SURAT TUGAS PDF
|--------------------------------------------------------------------------
*/
Route::get('/surat-tugas/pdf/{id?}', [SuratTugasController::class, 'exportPdf'])
    ->name('surat-tugas.pdf');

Route::prefix('program-kerja/realisasi')
    ->name('program-kerja.realisasi.')
    ->group(function () {

        Route::get('/', [ProgramKerjaController::class, 'realisasiIndex'])
            ->name('index');

        Route::get('/{program_kerja}/edit', [ProgramKerjaController::class, 'realisasiEdit'])
            ->name('edit');

        Route::put('/{program_kerja}', [ProgramKerjaController::class, 'realisasiUpdate'])
            ->name('update');
    });

Route::prefix('program-kerja')
    ->name('program-kerja.')
    ->group(function () {

    // Daftar Program Kerja
    Route::get('/', [ProgramKerjaController::class, 'index'])
            ->name('index');

    // Tambah Program Kerja
    Route::get('/create', [ProgramKerjaController::class, 'create'])
            ->name('create');

        Route::post('/', [ProgramKerjaController::class, 'store'])
            ->name('store');

    // Export PDF
    Route::get('/export/pdf/{waktu?}', [ProgramKerjaController::class, 'exportPdf'])
            ->name('export.pdf');

    // Transfer Periode Sebelumnya
    Route::post('/transfer-periode', [ProgramKerjaController::class, 'transferPeriodeSebelumnya'])
            ->name('transfer-periode');

    // Edit & Update
    Route::get('/{program_kerja}/edit', [ProgramKerjaController::class, 'edit'])
            ->name('edit');

        Route::put('/{program_kerja}', [ProgramKerjaController::class, 'update'])
            ->name('update');

    // Hapus
    Route::delete('/{program_kerja}', [ProgramKerjaController::class, 'destroy'])
            ->name('destroy');

    // Detail (harus paling bawah)
    Route::get('/{program_kerja}', [ProgramKerjaController::class, 'show'])
        ->name('show');
    });

// Export PDF Realisasi
Route::get(
    '/program-kerja/realisasi/pdf',
    [ProgramKerjaController::class, 'exportRealisasiPdf']
)->name('program-kerja.realisasi.pdf');

Route::resource(
    'periode-tahunan',
    PeriodeTahunanController::class
);

Route::put(
    'periode-tahunan/{id}/activate',
    [PeriodeTahunanController::class, 'activate']
)->name('periode-tahunan.activate');

Route::put(
    'periode-tahunan/{id}/finish',
    [PeriodeTahunanController::class, 'finish']
)->name('periode-tahunan.finish');
Route::post(
    '/periode-tahunan/generate',
    [PeriodeTahunanController::class, 'generate']
)->name('periode-tahunan.generate');


/*
|--------------------------------------------------------------------------
| ROLES & USERS
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:admin-provinsi|superAdmin'])->group(function () {

    Route::resource('roles', RoleController::class);

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

    Route::delete('/users/{user}', [UserRoleController::class, 'destroy'])
        ->name('users.destroy');

    Route::post('/users/reset-password', [UserRoleController::class, 'resetPassword'])
        ->name('users.reset-password');
});

/*
|--------------------------------------------------------------------------
| WILAYAH
|--------------------------------------------------------------------------
*/
Route::get('/wilayah', [WilayahController::class, 'index'])
    ->name('wilayah.index');

/*
|--------------------------------------------------------------------------
| LAPORAN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])
    ->prefix('laporan')
    ->name('laporan.')
    ->group(function () {

        Route::get('/', [LaporanController::class, 'laporan'])
            ->name('index');

        Route::get('/rekap-kabupaten', [LaporanController::class, 'rekapKabupaten'])
            ->name('rekap-kabupaten');

        Route::get('/wilayah-kosong', [LaporanController::class, 'wilayahBelumAdaPengamal'])
            ->name('wilayah-kosong');

        Route::get('/export-kategori/{kategori}', [LaporanController::class, 'exportKategoriPdf'])
            ->name('export-kategori');
    });


// Alias untuk route lama

Route::get('/laporan-file', [LaporanController::class, 'index'])
    ->name('laporan-file.index');
Route::get('/laporan/download', [LaporanController::class, 'downloadLaporan'])
    ->name('laporan.download');

/*
|--------------------------------------------------------------------------
| POST
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/post/store', [PostController::class, 'store'])->name('post.store');

    Route::get('/post/approval', [PostController::class, 'approval'])->name('post.approval');
    Route::put('/post/{id}/approve', [PostController::class, 'approve']);

    Route::get('/post/approved', [PostController::class, 'approvedList'])->name('post.approved');
    Route::delete('/post/{id}', [PostController::class, 'destroy'])->name('post.destroy');

    Route::get('/post-detail/{id}', [PostController::class, 'showPublic'])
        ->name('post.public.show');
});

/*
|--------------------------------------------------------------------------
| ACTIVITY LOG
|--------------------------------------------------------------------------
*/
Route::get('/admin/activity-logs', [ActivityLogController::class, 'index'])
    ->name('activity.logs');

/*
|--------------------------------------------------------------------------
| SURAT
|--------------------------------------------------------------------------
*/
Route::resource('surat', SuratKeluarController::class);
Route::resource('surat-masuk', SuratMasukController::class);
Route::resource('surat-tugas', SuratTugasController::class);
Route::post(
    '/surat/upload',
    [SuratKeluarController::class, 'upload']
)->name('surat.upload');
Route::get(
    '/surat/file/{file}/download',
    [SuratKeluarController::class, 'downloadFile']
)->name('surat.file.download');


Route::delete(
    '/surat/file/{file}',
    [SuratKeluarController::class, 'deleteFile']
)->name('surat.file.delete');

/*
|--------------------------------------------------------------------------
| RESERVASI PUBLIC
|--------------------------------------------------------------------------
*/
Route::prefix('reservasi')
    ->name('reservasi.')
    ->group(function () {

        Route::get('/', [ReservationController::class, 'create'])
            ->name('create');

        Route::post('/store', [ReservationController::class, 'store'])
            ->name('store');

        Route::get('/show/{id}', [ReservationController::class, 'show'])
            ->name('show');

        Route::get('/edit', [ReservationController::class, 'lookup'])
            ->name('lookup');

        Route::post('/find', [ReservationController::class, 'find'])
            ->name('find');

        Route::get('/edit/{id}', [ReservationController::class, 'edit'])
            ->name('edit');

        Route::put('/update/{id}', [ReservationController::class, 'update'])
            ->name('update');

        Route::put('/cancel/{id}', [ReservationController::class, 'cancel'])
            ->name('cancel');

        Route::delete('/delete/{id}', [ReservationController::class, 'destroy'])
            ->name('destroy');
    });

/*
|--------------------------------------------------------------------------
| ADMIN RESERVASI
|--------------------------------------------------------------------------
*/
Route::middleware([
    'auth',
    'verified',
    'role:superAdmin|admin-provinsi|admin-kabupaten|admin-kecamatan'
])
    ->prefix('admin/reservasi')
    ->name('admin.reservasi.')
    ->group(function () {

    Route::get('/', [ScanController::class, 'index'])->name('dashboard');
    Route::get('/data', [ScanController::class, 'reservations'])->name('data');
    Route::get('/checked-in', [ScanController::class, 'checkedIn'])->name('checked-in');
    Route::get('/pending', [ScanController::class, 'pending'])->name('pending');

        Route::get('/scan', [ScanController::class, 'scan'])->name('scan');
        Route::post('/checkin', [ScanController::class, 'checkin'])->name('checkin');
    Route::get('/cancelled', [ScanController::class, 'cancelledReservations'])
        ->name('cancelled');
    });

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
