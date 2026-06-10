<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SupplierDashboardController;
use App\Http\Controllers\OperatorDashboardController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\KonsumenController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PelabuhanController;
use App\Http\Controllers\RuteController;
use App\Http\Controllers\StatusDeliveryController;

/*
|--------------------------------------------------------------------------
| KasaLog - Frontend Routes (UI/UX Only)
|--------------------------------------------------------------------------
| Semua route mengembalikan view langsung tanpa controller.
| Parameter ?role= digunakan untuk demo switching role.
|--------------------------------------------------------------------------
*/

// Redirect root ke login
Route::get('/', fn() => view('landing.index'));

// Auth
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get ('/logout', [AuthController::class, 'logout'])->name('logout');


use App\Http\Controllers\DashboardController;

// Dashboard per role
Route::get('/dashboard/supplier', [SupplierDashboardController::class, 'index'])->middleware('auth');
Route::get('/dashboard/operator', [OperatorDashboardController::class, 'index'])->middleware('auth');

Route::get('/dashboard/{role?}', [DashboardController::class, 'index'])->name('dashboard');


// Kelola Supplier
Route::resource('suppliers', SupplierController::class)->middleware('auth');

// Kelola Konsumen
Route::resource('konsumen', KonsumenController::class)->middleware('auth');

// Kelola Operator
Route::resource('operators', OperatorController::class)->middleware('auth');

// Kelola Pelabuhan
Route::resource('pelabuhan', PelabuhanController::class)->middleware('auth');

// Kelola Rute
Route::resource('rute', RuteController::class)->middleware('auth');

// Order
Route::get('/orders', function (Request $request) {
    return view('orders.index', [
        'role' => $request->query('role', 'staff'),
        'pageTitle' => 'Kelola Order',
    ]);
});

Route::get('/orders/{id}', function (Request $request, string $id) {
    return view('orders.show', [
        'role' => $request->query('role', 'staff'),
        'pageTitle' => 'Detail Order',
        'orderId' => $id,
    ]);
});

// Tracking Delivery
Route::get('/tracking', function (Request $request) {
    return view('tracking.index', [
        'role' => $request->query('role', 'staff'),
        'pageTitle' => 'Tracking Delivery',
    ]);
});

Route::get('/tracking/{id}', function (Request $request, string $id) {
    return view('tracking.show', [
        'role' => $request->query('role', 'staff'),
        'pageTitle' => 'Detail Tracking',
        'trackingId' => $id,
    ]);
});

// Manajemen Status Delivery (Superadmin)
Route::resource('/status-delivery', StatusDeliveryController::class);
// Profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});