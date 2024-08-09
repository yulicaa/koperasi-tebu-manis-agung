<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Only User
Route::middleware(['check.auth'])->group(function () {
    // Auth
    Route::post('/register', [AuthenticationController::class, 'register'])->name('register');
    Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');
    Route::patch('/password', [AuthenticationController::class, 'changePassword'])->name('change.password');

    // Pinjaman
    Route::get('/pinjaman/create', [PinjamanController::class, 'showCreatePinjamanPage'])->name('pinjaman.create.page');
    Route::post('/pinjaman', [PinjamanController::class, 'createPinjaman'])->name('pinjaman.create');
    Route::patch('/pinjaman/{pinjamanId}', [PinjamanController::class, 'updateStatusPinjaman'])->name('pinjaman.update');
    Route::get('/pinjaman', [PinjamanController::class, 'getAllPinjaman'])->name('pinjaman.index');
    Route::get('/pinjaman/{pinjamanId}', [PinjamanController::class, 'detailPinjaman'])->name('pinjaman.detail');

    // Tagihan
    Route::delete('/tagihan/upload/{uploadId}', [TagihanController::class, 'deleteBukti'])->name('delete.bukti');
    Route::post('/tagihan/upload', [TagihanController::class, 'uploadBukti'])->name('upload.bukti');
    Route::get('/tagihan/create', [TagihanController::class, 'showCreateTagihanPage'])->name('tagihan.create.page');
    Route::patch('/tagihan/{tagihanId}', [TagihanController::class, 'updateStatusTagihan'])->name('tagihan.update');
    Route::get('/tagihan', [TagihanController::class, 'getAllTagihanUser'])->name('tagihan.index');
    Route::get('/tagihan/{tagihanId}', [TagihanController::class, 'detailTagihan'])->name('tagihan.detail');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'getDataLaporan'])->name('laporan.index');
    Route::get('/laporan/print', [LaporanController::class, 'printLaporan'])->name('laporan.print');
    Route::get('/laporan/{laporanId}', [LaporanController::class, 'detailLaporan'])->name('laporan.detail');

    // Home
    Route::get('/', function () {
        return view('components.home');
    })->name('home');

    // Profile
    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile');    
});


// Only Admin
Route::middleware(['check.admin'])->group(function () {
    Route::get('/admin/users/create', [UserController::class, 'showCreateUserPage'])->name('admin.user.create.page');
    Route::post('/admin/users', [UserController::class, 'createUser'])->name('admin.user.create');
    Route::get('/admin/users', [UserController::class, 'getAllUsers'])->name('admin.user.index');
    Route::get('/admin/users/{userId}', [UserController::class, 'detailUser'])->name('admin.user.detail');
    Route::patch('/admin/users/{userId}', [UserController::class, 'updateUser'])->name('admin.user.update');
    Route::delete('/admin/users/{userId}', [UserController::class, 'deleteUser'])->name('admin.user.delete');
});

Route::get('/notification', [HomeController::class, 'notification'])->name('notification');
Route::get('/dashboard', [HomeController::class, 'getDashboardData'])->name('dashboard.data');

Route::get('/login', [AuthenticationController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthenticationController::class, 'login'])->name('login');