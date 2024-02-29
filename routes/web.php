<?php

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

Route::get('/', function () {
    return view('component.app');
});

Route::resource('kandidat', KandidatController::class);
Route::resource('suara', SuaraController::class);
Route::resource('kegiatan', KegiatanController::class);
Route::resource('user-manejement', UserController::class);
Route::resource('santri', SantriController::class);
Route::get('search/user',[SearchController::class,'user'])->name('search.user');
Route::get('search/kegiatan',[SearchController::class,'kegiatan'])->name('search.kegiatan');
Route::get('search/kandidat',[SearchController::class,'kandidat'])->name('search.kandidat');
Route::get('search/santri',[SearchController::class,'santri'])->name('search.santri');

