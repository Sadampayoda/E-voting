<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\KandidatController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SuaraController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::controller(BerandaController::class)->group(function () {
    Route::get('/', 'index')->name('beranda.index');
    Route::post('/', 'nik')->name('beranda.nik');
    Route::get('/login', 'login')->name('beranda.login');
    Route::get('/hasil', 'hasil')->name('beranda.hasil');
    Route::get('/lihat-kandidat/{id}', 'kandidat')->name('beranda.kandidat');
    Route::post('/login', 'validasilogin')->name('beranda.validasi');

    Route::get('/dashboard', 'admin')->name('beranda.admin')->middleware(['auth','admin']);
    Route::get('/logout', 'validasilogin')->name('beranda.logout')->middleware(['auth']);
});


Route::resource('suara', SuaraController::class)->middleware('auth');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('kandidat', KandidatController::class);
    Route::resource('kegiatan', KegiatanController::class);
    Route::resource('user-manejement', UserController::class);
    Route::resource('santri', SantriController::class);
    Route::get('search/user', [SearchController::class, 'user'])->name('search.user');
    Route::get('search/kegiatan', [SearchController::class, 'kegiatan'])->name('search.kegiatan');
    Route::get('search/kandidat', [SearchController::class, 'kandidat'])->name('search.kandidat');
    Route::get('search/santri', [SearchController::class, 'santri'])->name('search.santri');
});
