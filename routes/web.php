<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\RitaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\DriverRitaseController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/driver/profile', function () {
        return view('driver.profile', ['user' => auth()->user()]);
    })->name('driver.profile');

    // Driver Ritase
    Route::get('/driver/ritase/create', [DriverRitaseController::class, 'create'])->name('driver.ritase.create');
    Route::post('/driver/ritase/store', [DriverRitaseController::class, 'store'])->name('driver.ritase.store');
    Route::get('/driver/ritase', [DriverRitaseController::class, 'index'])->name('driver.ritase.index');

    // Absensi
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::patch('/attendance/{id}/verify', [AttendanceController::class, 'verify'])->name('attendance.verify');
    Route::patch('/attendance/{id}/reject', [AttendanceController::class, 'reject'])->name('attendance.reject');
    Route::patch('/attendance/{id}/update', [AttendanceController::class, 'update'])->name('attendance.update'); // ← BARU: edit jam

    // Halaman riwayat absensi admin
    Route::get('/admin/absensi/riwayat', [AttendanceController::class, 'index'])->name('admin.attendance.index');

    // Antrian
    Route::post('/queue/store', [QueueController::class, 'store'])->name('queue.store');
    Route::put('/queue/{id}/update', [QueueController::class, 'update'])->name('queue.update');

    // Ritase admin
    Route::get('/ritase/create/{queue_id}', [RitaseController::class, 'create'])->name('ritase.create');
    Route::post('/ritase/store', [RitaseController::class, 'store'])->name('ritase.store');

    // Laporan
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::put('/ritase/{id}/update', [ReportController::class, 'updateRitase'])->name('ritase.update.admin');
    Route::delete('/ritase/{id}/destroy', [ReportController::class, 'destroyRitase'])->name('ritase.destroy.admin');

    // Driver Management
    Route::middleware('verified')->group(function () {
        Route::get('/drivers', [DriverController::class, 'index'])->name('drivers.index');
        Route::get('/drivers/{id}/edit', [DriverController::class, 'edit'])->name('drivers.edit');
        Route::put('/drivers/{id}', [DriverController::class, 'update'])->name('drivers.update');
        Route::delete('/drivers/{id}', [DriverController::class, 'destroy'])->name('drivers.destroy');
    });
});

require __DIR__.'/auth.php';