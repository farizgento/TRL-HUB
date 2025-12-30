<?php

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


Route::get('/dashboard', function () {
    return view('/dashboard/index');
});
Route::get('/scan', function () {
    return view('tools/scan');
});

Route::get('/tools', function () {
    return view('/tools/index');
});

Route::get('/borrow', function () {
    return view('/borrow/index');
});

Route::get('/damage', function () {
    return view('/damage/index');
});

Route::get('/repairs', function () {
    return view('/repairs/index');
});

Route::get('/reports', function () {
    return view('/reports/index');
});

Route::get('/login', function () {
    return view('/auth/login');
}); 