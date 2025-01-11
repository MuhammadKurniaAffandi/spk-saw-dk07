<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('kriteria', 'App\Http\Controllers\KriteriaController')->except(['create']);
Route::resource('guru', 'App\Http\Controllers\GuruController')->except(['create']);
Route::resource('crips', 'App\Http\Controllers\CripsController')->except(['index', 'create', 'show']);
// Route::get('/penilaian', [App\Http\Controllers\PenilaianController::class, 'index'])->name('penilaian.index');
Route::resource('/penilaian', 'App\Http\Controllers\PenilaianController');
Route::resource('user', 'App\Http\Controllers\UserController')->except(['create']);
Route::resource('profile', ProfileController::class);
Route::resource('laporan', 'App\Http\Controllers\LaporanController')->except(['create']);
Route::get('/perhitungan', [App\Http\Controllers\AlgoritmaController::class, 'index'])->name('perhitungan.index');
Route::post('/perhitungan/simpan', [App\Http\Controllers\AlgoritmaController::class, 'simpanLaporan'])->name('perhitungan.simpan');
// Route::get('/laporan', [App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');
// Route::get('/laporan/{periode}', [App\Http\Controllers\LaporanController::class, 'show']);
Route::get('download-perhitungan-pdf', [App\Http\Controllers\AlgoritmaController::class, 'downloadPDF']);
Route::get('download-guru-pdf', [App\Http\Controllers\GuruController::class, 'downloadPDF']);
Route::get('download-user-pdf', [App\Http\Controllers\UserController::class, 'downloadPDF']);
Route::get('download-kriteria-pdf', [App\Http\Controllers\KriteriaController::class, 'downloadPDF']);
Route::get('/download-crips-pdf/{id}', [App\Http\Controllers\KriteriaController::class, 'downloadCripsPDF']);
Route::get('download-penilaian-pdf', [App\Http\Controllers\PenilaianController::class, 'downloadPDF']);
Route::get('/cetak-laporan/{id}', [App\Http\Controllers\LaporanController::class, 'cetakLaporan']);
