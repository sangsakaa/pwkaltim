<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    ActivityLogController,
    ProfileController,
    RoleController,
    WilayahController,
    LaporanController,
    PostController,
    DepartemenController,
    ProgramKerjaController,
    ReservationController,
    ScanController,
    SuratKeluarController,
    SuratMasukController,
    SuratTugasController
};

use App\Http\Controllers\Administrator\{
    DashboardController,
    PengamalController,
    UserRoleController
};

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

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
Route::get('/daftar-pengamal', [PengamalController::class, 'createPublic'])
    ->name('pengamal.public.create');

// public
Route::middleware(['auth', 'verified'])->group(function () {

    // CRUD utama (pakai resource biar otomatis lengkap)
    Route::resource('pengamal', PengamalController::class);

    // store tetap manual kalau kamu mau pisah dari resource
    Route::post('/pengamal/store', [PengamalController::class, 'store'])
        ->name('pengamal.store');
    Route::delete('/pengamal/show/{pengamal}', [PengamalController::class, 'destroy'])->name('pengamal.destroy');
    Route::get('/pengamal/{pengamal}/edit', [PengamalController::class, 'edit'])->name('pengamal.edit');
    Route::put('/pengamal/{pengamal}', [PengamalController::class, 'update'])->name('pengamal.update');
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
});

/*
|--------------------------------------------------------------------------
| ROLES & USERS
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:admin-provinsi|superAdmin'])->group(function () {

    Route::resource('roles', RoleController::class);

    Route::get('/users/assign-role', [UserRoleController::class, 'index'])->name('users.assign-role-index');
    Route::get('/users/create', [UserRoleController::class, 'create'])->name('users.create');
    Route::post('/users/create', [UserRoleController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/assign-role', [UserRoleController::class, 'edit'])->name('users.assign-role');
    Route::post('/users/{user}/assign-role', [UserRoleController::class, 'update'])->name('users.assign-role.update');
    Route::post('/users/{user}/change-role', [UserRoleController::class, 'changeRole'])->name('users.change-role');
    Route::delete('/users/{user}', [UserRoleController::class, 'destroy'])->name('users.destroy');
});

/*
|--------------------------------------------------------------------------
| WILAYAH
|--------------------------------------------------------------------------
*/

Route::get('/wilayah', [WilayahController::class, 'index'])->name('wilayah.index');

/*
|--------------------------------------------------------------------------
| LAPORAN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/laporan', [LaporanController::class, 'laporan'])->name('laporan.laporan');
    Route::get('/laporan-file', [LaporanController::class, 'index'])->name('laporan-file.index');
    Route::get('/laporan/download', [LaporanController::class, 'downloadLaporan'])->name('laporan.download');
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
Route::resource('program-kerja', ProgramKerjaController::class);

/*
|--------------------------------------------------------------------------
| RESERVASI PUBLIC (FIXED - ONLY ONE GROUP)
|--------------------------------------------------------------------------
*/

Route::prefix('reservasi')->name('reservasi.')->group(function () {

    Route::get('/', [ReservationController::class, 'create'])->name('create');
    Route::post('/store', [ReservationController::class, 'store'])->name('store');

    Route::get('/show/{id}', [ReservationController::class, 'show'])->name('show');

    Route::get('/edit', [ReservationController::class, 'lookup'])->name('lookup');

    Route::post('/find', [ReservationController::class, 'find'])->name('find'); // ✅ FIX

    Route::put('/update/{reservation}', [ReservationController::class, 'update'])->name('update');
});

/*
|--------------------------------------------------------------------------
| ADMIN RESERVASI (FIXED - NO DUPLICATE)
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
    });
Route::middleware(['auth', 'verified'])->group(function () {

    Route::prefix('laporan')->name('laporan.')->group(function () {

        Route::get('/', [LaporanController::class, 'laporan'])
            ->name('laporan');

        Route::get('/rekap-kabupaten', [LaporanController::class, 'rekapKabupaten'])
            ->name('rekap-kabupaten');

        Route::get('/wilayah-kosong', [LaporanController::class, 'wilayahBelumAdaPengamal'])
            ->name('wilayah-kosong');

        Route::get('/export-kategori/{kategori}', [LaporanController::class, 'exportKategoriPdf'])
            ->name('export-kategori');
    });
});
Route::get('/pengamal/sync', [PengamalController::class, 'sync'])
    ->middleware('role:superAdmin|admin-provinsi')
    ->name('pengamal.sync');



Route::post('/reservations', [ReservationController::class, 'store'])
    ->name('reservations.store');
Route::get('/reservasi/create', [ReservationController::class, 'create'])
    ->name('reservations.create');
Route::get('/reservasi/{id}', [ReservationController::class, 'show'])
    ->name('reservations.show');
Route::get('/reservations/{reservation}/edit', [ReservationController::class, 'edit'])
    ->name('reservations.edit');

require __DIR__ . '/auth.php';
