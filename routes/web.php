<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CertificateController;

// Homepage.
Route::get('/', function () {
    return view('welcome');
});

// Customer routes.
Route::get('/customers', [CustomerController::class, 'index'])
    ->name('customers.index');

Route::get('/customers/create', function () {
    return view('customers.create');
})->name('customers.create');

Route::post('/customers', [CustomerController::class, 'store'])
    ->name('customers.store');

// Certificate routes.
Route::get('/certificates', [CertificateController::class, 'index'])
    ->name('certificates.index');

Route::get('/certificates/create', [CertificateController::class, 'create'])
    ->name('certificates.create');

Route::post('/certificates', [CertificateController::class, 'store'])
    ->name('certificates.store');