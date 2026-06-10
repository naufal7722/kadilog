<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SupplierDashboardController;
use App\Http\Controllers\OperatorDashboardController;
use App\Http\Controllers\StatusDeliveryController;

/*
|--------------------------------------------------------------------------
| KasaLog - Frontend Routes (UI/UX Only)
|--------------------------------------------------------------------------
| Semua route mengembalikan view langsung tanpa controller.
| Parameter ?role= digunakan untuk demo switching role.
|--------------------------------------------------------------------------
*/

// Landing Page
Route::get('/', fn() => view('landing.index'));

// Auth
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get ('/logout', [AuthController::class, 'logout'])->name('logout');


// Dashboard per role
Route::get('/dashboard/supplier', [SupplierDashboardController::class, 'index'])->middleware('auth');
Route::get('/dashboard/operator', [OperatorDashboardController::class, 'index'])->middleware('auth');

Route::get('/dashboard/{role?}', function (string $role = 'staff') {
    $validRoles = ['superadmin', 'staff', 'supplier', 'operator'];
    $role = in_array($role, $validRoles) ? $role : 'staff';
    return view("dashboard.{$role}", [
        'role' => $role,
        'pageTitle' => 'Dashboard',
    ]);
});

// Kelola Supplier
Route::get('/supp   liers', function (Request $request) {
    return view('suppliers.index', [
        'role' => $request->query('role', 'staff'),
        'pageTitle' => 'Kelola Supplier',
    ]);
});

// Kelola Konsumen
Route::get('/konsumen', function (Request $request) {
    return view('konsumen.index', [
        'role' => $request->query('role', 'staff'),
        'pageTitle' => 'Kelola Konsumen',
    ]);
});

// Kelola Operator
Route::get('/operators', function (Request $request) {
    return view('operators.index', [
        'role' => $request->query('role', 'staff'),
        'pageTitle' => 'Kelola Operator',
    ]);
});

// Kelola Pelabuhan
Route::get('/pelabuhan', function (Request $request) {
    return view('pelabuhan.index', [
        'role' => $request->query('role', 'staff'),
        'pageTitle' => 'Kelola Pelabuhan',
    ]);
});

// Kelola Rute
Route::get('/rute', function (Request $request) {
    return view('rute.index', [
        'role' => $request->query('role', 'staff'),
        'pageTitle' => 'Kelola Rute',
    ]);
});

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
Route::get('/status-delivery', [StatusDeliveryController::class, 'index'])->name('status-delivery.index');
Route::post('/status-delivery', [StatusDeliveryController::class, 'store'])->name('status-delivery.store');
Route::put('/status-delivery/{kode}', [StatusDeliveryController::class, 'update'])->name('status-delivery.update');
Route::delete('/status-delivery/{kode}', [StatusDeliveryController::class, 'destroy'])->name('status-delivery.destroy');

// Profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
