<?php
use App\Http\Controllers\AdminJTIKController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\LacakSuratController;

Route::get('/', function () {
    return view('esurat.home');
})->name('home');

/*
|--------------------------------------------------------------------------
| USER
|--------------------------------------------------------------------------
*/
Route::get('/lacak-surat', [LacakSuratController::class, 'index'])
    ->name('surat.lacak');

Route::post('/lacak-surat', [LacakSuratController::class, 'track'])
    ->name('surat.track');

Route::get('/surat/kirim', [SuratController::class, 'create'])
    ->name('surat.create');

Route::post('/surat/store', [SuratController::class, 'store'])
    ->name('surat.store');

/*
|--------------------------------------------------------------------------
| ADMIN LOGIN
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])
    ->name('admin.login');

Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->name('admin.login.process');

Route::post('/admin/logout', [AdminAuthController::class, 'logout'])
    ->name('admin.logout');

/*
|--------------------------------------------------------------------------
| ADMIN AREA (LOGIN REQUIRED)
|--------------------------------------------------------------------------
*/
Route::middleware(['AdminAuth'])->group(function () {

    // --- DASHBOARD ADMIN JTIK (PUSAT) ---
    Route::get('/admin/jtik/dashboard', [AdminJTIKController::class, 'index'])
        ->name('admin.jtik.index');
        
    Route::post('/adminjtik/surat/kirim/{id}', [AdminJTIKController::class, 'kirim'])
        ->name('adminjtik.surat.kirim');
    // Route Hapus Surat (Admin JTIK)
    Route::delete('/adminjtik/surat/hapus/{id}', [App\Http\Controllers\AdminJTIKController::class, 'destroy'])
        ->name('adminjtik.surat.hapus');
    
        Route::delete('/adminjtik/surat/hapus/{id}', [App\Http\Controllers\AdminJTIKController::class, 'destroy'])
        ->name('adminjtik.surat.hapus');

    // 2. Lihat Halaman Sampah
    Route::get('/adminjtik/sampah', [App\Http\Controllers\AdminJTIKController::class, 'sampah'])
        ->name('adminjtik.sampah.index');
        
    // 3. Restore (Kembalikan Surat)
    Route::get('/adminjtik/sampah/restore/{id}', [App\Http\Controllers\AdminJTIKController::class, 'restore'])
        ->name('adminjtik.sampah.restore');

    // 4. Hapus Permanen (Force Delete)
    Route::delete('/adminjtik/sampah/force-delete/{id}', [App\Http\Controllers\AdminJTIKController::class, 'forceDelete'])
        ->name('adminjtik.sampah.force');

    // Route Batalkan/Cabut Kiriman ke Prodi
    Route::delete('/adminjtik/kiriman/batal/{id}', [App\Http\Controllers\AdminJTIKController::class, 'batalKirim'])
        ->name('adminjtik.kiriman.batal');
    // Route Batalkan/Cabut Kiriman ke Prodi Spesifik
    Route::delete('/adminjtik/kiriman/batal/{id}', [App\Http\Controllers\AdminJTIKController::class, 'batalKirim'])
        ->name('adminjtik.kiriman.batal');




    // --- DASHBOARD ADMIN PRODI (CABANG) ---
    Route::get('/admin/prodi/dashboard', [ProdiController::class, 'index'])
        ->name('admin.prodi.index');

    Route::post('/prodi/surat/update/{id}', [ProdiController::class, 'updateStatus'])
        ->name('prodi.surat.update');

    // --- RUTE CETAK (INI POSISI YANG BENAR) ---
    // Dia harus berdiri sendiri, tidak boleh di dalam route lain
    Route::get('/admin/prodi/cetak/{id}', [ProdiController::class, 'cetak'])
        ->name('prodi.surat.cetak');

    // Route Export Excel (CSV)
    Route::get('/adminjtik/export/excel', [App\Http\Controllers\AdminJTIKController::class, 'exportExcel'])
        ->name('adminjtik.export');


    // -- ROUTE REDIRECT DASHBOARD UMUM --
    Route::get('/admin/dashboard', function() {
        if(session('admin_role') == 'admin_jtik'){
            return redirect()->route('admin.jtik.index');
        } else {
            return redirect()->route('admin.prodi.index');
        }
    })->name('admin.dashboard');

});