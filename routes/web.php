<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\BerandaController;
use App\Http\Controllers\Frontend\VillaController;
use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\AkunController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\Owner\VillaController as OwnerVillaController;
use App\Http\Controllers\Owner\PesananController as OwnerPesananController;
use App\Http\Controllers\Owner\AuthController as OwnerAuthController;
use App\Http\Controllers\Owner\AkunController as OwnerAkunController;

// ===================================================================
// FRONTEND (Tamu / Customer)  //
// ===================================================================
Route::prefix('')->group(function () {

    // PUBLIC
    Route::get('/beranda',     [BerandaController::class, 'index'])->name('beranda');
    Route::get('/villa',       [VillaController::class,   'index'])->name('villa.index');
    Route::get('/villa/{id}',  [VillaController::class,   'detail'])->name('villa.detail');
    Route::get('/login',       [AuthController::class,    'showLogin'])->name('login');
    Route::post('/login',      [AuthController::class,    'login']);
    Route::get('/register',    [AuthController::class,    'showRegister'])->name('register');
    Route::post('/register',   [AuthController::class,    'register']);

    // PROTECTED — harus login sebagai Customer
    Route::middleware(['auth'])->group(function () {
        Route::post('/logout',              [AuthController::class, 'logout'])->name('logout');
        Route::get('/booking/riwayat',      [BookingController::class, 'riwayat'])->name('booking.riwayat');
        Route::get('/booking/{id}',         [BookingController::class, 'form'])->name('booking.form');
        Route::post('/booking',             [BookingController::class, 'store'])->name('booking.store');
        Route::delete('/booking/{id}/batal', [BookingController::class, 'batal'])->name('booking.batal');
        Route::delete('/booking/{id}/hapus', [BookingController::class, 'hapus'])->name('booking.hapus');
        Route::get('/booking/{id}/detail', [BookingController::class, 'detail'])->name('booking.detail');
        Route::get('/akun/profil',          [AkunController::class,   'profil'])->name('akun.profil');
        Route::post('/akun/profil',         [AkunController::class,   'updateProfil'])->name('akun.updateProfil');
    });
});

// ===================================================================
// OWNER  //
// ===================================================================
Route::prefix('owner')->name('owner.')->group(function () {

    // Login & Logout Owner (PUBLIC — belum perlu guard)
    Route::get('/login',  [OwnerAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [OwnerAuthController::class, 'login']);
    Route::get('/register',  [OwnerAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [OwnerAuthController::class, 'register']);

    // Panel Owner — PROTECTED dengan guard owner
    Route::middleware(['auth:owner'])->group(function () {
        Route::post('/logout', [OwnerAuthController::class, 'logout'])->name('logout');

        // Profil owner
        Route::get('/akun/profil',  [OwnerAkunController::class, 'profil'])->name('akun.profil');
        Route::post('/akun/profil', [OwnerAkunController::class, 'updateProfil'])->name('akun.updateProfil');

        // Dashboard
        Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');

        // Villa CRUD
        Route::get('/villa',              [OwnerVillaController::class, 'index'])->name('villa.index');
        Route::get('/villa/create',       [OwnerVillaController::class, 'create'])->name('villa.create');
        Route::post('/villa',             [OwnerVillaController::class, 'store'])->name('villa.store');
        Route::get('/villa/{id}/edit',    [OwnerVillaController::class, 'edit'])->name('villa.edit');
        Route::put('/villa/{id}',         [OwnerVillaController::class, 'update'])->name('villa.update');
        Route::delete('/villa/{id}',      [OwnerVillaController::class, 'destroy'])->name('villa.destroy');

        // Pesanan
        Route::get('/pesanan',                        [OwnerPesananController::class, 'index'])->name('pesanan.index');
        Route::patch('/pesanan/{id}/konfirmasi',      [OwnerPesananController::class, 'konfirmasi'])->name('pesanan.konfirmasi');
        Route::patch('/pesanan/{id}/tolak',           [OwnerPesananController::class, 'tolak'])->name('pesanan.tolak');
    });
});

// ===================================================================
// SUPER ADMIN //
// ===================================================================
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    Route::get('/beranda', [\App\Http\Controllers\Admin\BerandaController::class, 'index'])->name('beranda');

    Route::get('/customer',         [\App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('customer.index');
    Route::delete('/customer/{id}', [\App\Http\Controllers\Admin\CustomerController::class, 'destroy'])->name('customer.destroy');

    Route::get('/owner',         [\App\Http\Controllers\Admin\OwnerController::class, 'index'])->name('owner.index');
    Route::delete('/owner/{id}', [\App\Http\Controllers\Admin\OwnerController::class, 'destroy'])->name('owner.destroy');

    Route::get('/villa',              [\App\Http\Controllers\Admin\VillaController::class, 'index'])->name('villa.index');
    Route::patch('/villa/{id}/status', [\App\Http\Controllers\Admin\VillaController::class, 'updateStatus'])->name('villa.status');
    Route::delete('/villa/{id}',      [\App\Http\Controllers\Admin\VillaController::class, 'destroy'])->name('villa.destroy');

    Route::get('/pesanan', [\App\Http\Controllers\Admin\PesananController::class, 'index'])->name('pesanan.index');
});
