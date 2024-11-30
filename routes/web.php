<?php

use App\Livewire\Laporan;
use App\Livewire\Pangkas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\PangkasController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UseradminController;

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index2'])->name('home.admin');
    Route::post('/home/update', [App\Http\Controllers\HomeController::class, 'update'])->name('home-update');

    //kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/getdata/{id}', [KategoriController::class, 'getdata'])->name('getdatakategori');
    Route::post('/kategori/input', [KategoriController::class, 'store'])->name('kategori-input');
    Route::post('/kategori/update', [KategoriController::class, 'update'])->name('kategori-update');
    Route::get('/kategori/hapus/{id}', [KategoriController::class, 'destroy'])->name('kategori-delete');

    //mitra
    Route::get('/mitra-kita', [MitraController::class, 'index'])->name('mitra.index');
    Route::get('/mitra/getdata/{id}', [MitraController::class, 'getdata'])->name('getdatamitra');
    Route::post('/mitra/input', [MitraController::class, 'store'])->name('mitra-input');
    Route::post('/mitra/update', [MitraController::class, 'update'])->name('mitra-update');
    Route::post('/mitra/validasi', [MitraController::class, 'validasi'])->name('mitra-validasi');
    Route::get('/mitra/hapus/{id}', [MitraController::class, 'destroy'])->name('mitra-delete');

    //pangkas
    Route::get('/getpangkas', [PangkasController::class, 'index'])->name('pangkas.index');
    Route::get('/pangkas', Pangkas::class)->name('pangkas');

    //user admin
    Route::get('/user-admin', [UseradminController::class, 'index'])->name('useradmin');
    Route::get('/user-admin/getdata/{id}', [UseradminController::class, 'getdata'])->name('getdatauseradmin');
    Route::post('/user-admin/input', [UseradminController::class, 'store'])->name('useradmin-input');
    Route::post('/user-admin/update', [UseradminController::class, 'update'])->name('useradmin-update');
    Route::get('/user-admin/hapus/{id}', [UseradminController::class, 'destroy'])->name('useradmin-delete');

    //user
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('/user/getdata/{id}', [UserController::class, 'getdata'])->name('getdatauser');
    Route::post('/user/input', [UserController::class, 'store'])->name('user-input');
    Route::post('/user/update', [UserController::class, 'update'])->name('user-update');
    Route::get('/user/hapus/{id}', [UserController::class, 'destroy'])->name('user-delete');

    //laporan
    Route::get('/laporan', Laporan::class)->name('laporan');
});
