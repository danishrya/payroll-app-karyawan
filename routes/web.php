<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\KaryawanPageController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KaryawanCrudController;
use App\Http\Controllers\Admin\AbsensiAdminController;
use App\Http\Controllers\Admin\GajiAdminController;
use Illuminate\Support\Facades\Auth; // Tambahkan ini
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

// Di route/web.php
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminDashboardController::class, 'index']);
});

Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user()->isKaryawan()) {
            return redirect()->route('karyawan.dashboard');
        }
    }
    return redirect()->route('login'); // Arahkan ke halaman login jika belum login
});

// Auth Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Middleware 'auth' untuk semua user yang sudah login
Route::middleware('auth')->group(function () {
    // Route untuk profile edit (jika diperlukan, bisa dibuat manual)
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Halaman Karyawan
    Route::middleware(['role:karyawan'])->prefix('karyawan')->name('karyawan.')->group(function () {
        Route::get('/dashboard', [KaryawanPageController::class, 'dashboard'])->name('dashboard');
        Route::post('/presensi-masuk', [KaryawanPageController::class, 'presensiMasuk'])->name('presensi.masuk');
        Route::post('/presensi-pulang', [KaryawanPageController::class, 'presensiPulang'])->name('presensi.pulang');
        Route::get('/riwayat-absensi', [KaryawanPageController::class, 'riwayatAbsensi'])->name('riwayat.absensi');
        Route::get('/invoice-gaji', [KaryawanPageController::class, 'invoiceGaji'])->name('invoice.gaji');
    });

    // Halaman Admin
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('karyawan', KaryawanCrudController::class); // Ini sudah mencakup CRUD routes
        Route::get('/absensi/rekap', [AbsensiAdminController::class, 'rekap'])->name('absensi.rekap');
        Route::get('/gaji', [GajiAdminController::class, 'index'])->name('gaji.index');
        Route::get('/gaji/hitung', [GajiAdminController::class, 'formHitung'])->name('gaji.form_hitung');
        Route::post('/gaji/proses-hitung', [GajiAdminController::class, 'prosesHitung'])->name('gaji.proses_hitung');
    });
});