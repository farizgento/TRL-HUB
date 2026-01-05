<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BorrowRequestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ToolController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect('/dashboard'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/scan', fn () => view('tools.scan'));
    Route::get('/damage', fn () => view('damage.index'));
    Route::get('/repairs', fn () => view('repairs.index'));
    Route::get('/reports', fn () => view('reports.index'));

    Route::middleware('role:admin,staff')->group(function () {
    Route::get('/tools', [ToolController::class, 'index'])->name('tools.index');
    Route::post('/tools', [ToolController::class, 'store'])->name('tools.store');
    Route::put('/tools/{tool}', [ToolController::class, 'update'])->name('tools.update');
    Route::delete('/tools/{tool}', [ToolController::class, 'destroy'])->name('tools.destroy');
    });
    
    // daftar permintaan
    Route::get('/borrow-requests', [BorrowRequestController::class, 'index'])
        ->name('borrow-requests.index');

    // form tambah permintaan
    Route::get('/borrow-requests/create', [BorrowRequestController::class, 'create'])
        ->name('borrow-requests.create');

    // simpan permintaan
    Route::post('/borrow-requests', [BorrowRequestController::class, 'store'])
        ->name('borrow-requests.store');

    // delete permintaan
    Route::delete('/borrow-requests/{id}', [BorrowRequestController::class, 'destroy'])
        ->name('borrow-requests.destroy');

        // update permintaan
    Route::put('/borrow-requests/{id}', [BorrowRequestController::class, 'update'])
        ->name('borrow-requests.update');

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/users', [AdminController::class, 'users']);
        Route::get('/admin/masters', [AdminController::class, 'masters']);
    });

    Route::post('/reports/export/requests', [ReportController::class, 'exportRequests']);
    Route::post('/reports/export/tools', [ReportController::class, 'exportTools']);
    Route::post('/reports/export/damage', [ReportController::class, 'exportDamage']);
});
