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
        Route::get('/tools', [ToolController::class, 'index']);
        Route::get('/tools/create', [ToolController::class, 'create']);
        Route::post('/tools', [ToolController::class, 'store']);
        Route::get('/tools/{tool}', [ToolController::class, 'show']);
        Route::get('/tools/{tool}/edit', [ToolController::class, 'edit']);
        Route::put('/tools/{tool}', [ToolController::class, 'update']);
    });

    Route::get('/borrow', [BorrowRequestController::class, 'index']);
    Route::get('/borrow/create', [BorrowRequestController::class, 'create'])->middleware('role:peminjam,admin');
    Route::post('/borrow', [BorrowRequestController::class, 'store'])->middleware('role:peminjam,admin');
    Route::get('/borrow/{borrowRequest}', [BorrowRequestController::class, 'show']);
    Route::get('/borrow/{borrowRequest}/edit', [BorrowRequestController::class, 'edit'])->middleware('role:staff,admin');
    Route::put('/borrow/{borrowRequest}', [BorrowRequestController::class, 'update'])->middleware('role:staff,admin');

    Route::post('/borrow/{borrowRequest}/action/submit', [BorrowRequestController::class, 'submit'])
        ->middleware('role:peminjam,admin');
    Route::post('/borrow/{borrowRequest}/action/approve-l1', [BorrowRequestController::class, 'approveL1'])
        ->middleware('role:staff,admin');
    Route::post('/borrow/{borrowRequest}/action/approve-final', [BorrowRequestController::class, 'approveFinal'])
        ->middleware('role:approval,admin');
    Route::post('/borrow/{borrowRequest}/action/dispatch', [BorrowRequestController::class, 'dispatch'])
        ->middleware('role:staff,admin');
    Route::post('/borrow/{borrowRequest}/action/return', [BorrowRequestController::class, 'markReturned'])
        ->middleware('role:staff,admin');

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/users', [AdminController::class, 'users']);
        Route::get('/admin/masters', [AdminController::class, 'masters']);
    });

    Route::post('/reports/export/requests', [ReportController::class, 'exportRequests']);
    Route::post('/reports/export/tools', [ReportController::class, 'exportTools']);
    Route::post('/reports/export/damage', [ReportController::class, 'exportDamage']);
});
