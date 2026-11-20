<?php

// Route connects website URLs to controller functions.
use Illuminate\Support\Facades\Route;

// Import the controllers used by the application.
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ReminderController;

// Send visitors directly to the customer management page.
Route::redirect('/', '/customers');

// CUSTOMER ROUTES
Route::get('/customers', [CustomerController::class, 'index'])
    ->name('customers.index');

Route::get('/customers/create', function () {
    return view('customers.create');
})->name('customers.create');

Route::post('/customers', [CustomerController::class, 'store'])
    ->name('customers.store');

Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])
    ->name('customers.edit');

Route::put('/customers/{customer}', [CustomerController::class, 'update'])
    ->name('customers.update');

Route::patch('/customers/{customer}/archive', [CustomerController::class, 'archive'])
    ->name('customers.archive');

Route::patch('/customers/{customer}/restore', [CustomerController::class, 'restore'])
    ->name('customers.restore');

Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])
    ->name('customers.destroy');

// CERTIFICATE ROUTES
Route::get('/certificates', [CertificateController::class, 'index'])
    ->name('certificates.index');

Route::get('/certificates/create', [CertificateController::class, 'create'])
    ->name('certificates.create');

Route::post('/certificates', [CertificateController::class, 'store'])
    ->name('certificates.store');

Route::get('/certificates/{certificate}/edit', [CertificateController::class, 'edit'])
    ->name('certificates.edit');

Route::put('/certificates/{certificate}', [CertificateController::class, 'update'])
    ->name('certificates.update');

Route::delete('/certificates/{certificate}', [CertificateController::class, 'destroy'])
    ->name('certificates.destroy');

// REMINDER ROUTES
Route::get('/reminders', [ReminderController::class, 'index'])
    ->name('reminders.index');
// Prepare new 30-day and 7-day reminder records.
Route::post('/reminders/prepare', [ReminderController::class, 'prepare'])
    ->name('reminders.prepare');