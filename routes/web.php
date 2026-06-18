<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\LaporanHarianController;
use App\Http\Controllers\KejadianController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\TopsisController;
use App\Http\Controllers\SawController;
use App\Http\Controllers\DashboardController;

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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/anggota', [MemberController::class, 'index'])->name('anggota.index');
    Route::get('/anggota/tambah', [MemberController::class, 'create'])->name('anggota.create');
    Route::post('/anggota', [MemberController::class, 'store'])->name('anggota.store');
    Route::delete('/anggota/{id}', [MemberController::class, 'destroy'])->name('anggota.destroy');
    Route::get('/anggota/{id}/edit', [MemberController::class, 'edit'])->name('anggota.edit');
    Route::put('/anggota/{id}', [MemberController::class, 'update'])->name('anggota.update');
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    route::get('/absensi/tambah', [AbsensiController::class, 'create'])->name('absensi.create');
    Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
    Route::get('/absensi/{id}/edit', [AbsensiController::class, 'edit'])->name('absensi.edit');
    Route::put('/absensi/{id}', [AbsensiController::class, 'update'])->name('absensi.update');
    Route::delete('/absensi/{id}', [AbsensiController::class, 'destroy'])->name('absensi.destroy');
    Route::get('/laporan', [LaporanHarianController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/tambah', [LaporanHarianController::class, 'create'])->name('laporan.create');
    Route::post('/laporan', [LaporanHarianController::class, 'store'])->name('laporan.store');
    Route::get('/laporan/{id}/edit', [LaporanHarianController::class, 'edit'])->name('laporan.edit');
    Route::put('/laporan/{id}', [LaporanHarianController::class, 'update'])->name('laporan.update');
    Route::delete('/laporan/{id}', [LaporanHarianController::class, 'destroy'])->name('laporan.destroy');
    Route::get('/kejadian', [KejadianController::class, 'index'])->name('kejadian.index');
    Route::get('/kejadian/tambah', [KejadianController::class, 'create'])->name('kejadian.create');
    Route::post('/kejadian', [KejadianController::class, 'store'])->name('kejadian.store');
    Route::get('/kejadian/{id}/detail', [KejadianController::class, 'show'])->name('kejadian.show');
    Route::get('/kejadian/{id}/edit', [KejadianController::class, 'edit'])->name('kejadian.edit');
    Route::put('/kejadian/{id}', [KejadianController::class, 'update'])->name('kejadian.update');
    Route::delete('/kejadian/{id}', [KejadianController::class, 'destroy'])->name('kejadian.destroy');
    Route::get('/inventaris', [InventarisController::class, 'index'])->name('inventaris.index');
    Route::get('/inventaris/tambah', [InventarisController::class, 'create'])->name('inventaris.create');
    Route::post('/inventaris', [InventarisController::class, 'store'])->name('inventaris.store');
    Route::get('/inventaris/{id}/edit', [InventarisController::class, 'edit'])->name('inventaris.edit');
    Route::put('/inventaris/{id}', [InventarisController::class, 'update'])->name('inventaris.update');
    Route::delete('/inventaris/{id}', [InventarisController::class, 'destroy'])->name('inventaris.destroy');
    Route::get('/analisis-topsis', [TopsisController::class, 'index'])->name('topsis.index');
    Route::get('/analisis-saw', [SawController::class, 'index'])->name('saw.index');
    Route::get('/laporan/cetak-pdf', [LaporanHarianController::class, 'cetakPdf'])->name('laporan.pdf');
    Route::get('/laporan/cetak-lengkap', [LaporanHarianController::class, 'cetakLengkap'])->name('laporan.lengkap');
});

require __DIR__.'/auth.php';
