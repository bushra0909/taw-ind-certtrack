<?php
// Route: connects website URLs to controller functions.
use Illuminate\Support\Facades\Route;

// AuthenticatedSessionController: handles administrator login and logout.
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// CustomerController: handles customer records.
use App\Http\Controllers\CustomerController;

// CertificateController: handles certificate records.
use App\Http\Controllers\CertificateController;

// ReminderController: handles renewal reminder records.
use App\Http\Controllers\ReminderController;



// Display the login page to guests.
Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    // Limit repeated login attempts to protect against password guessing.
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('login.store');
});

// Only authenticated administrators can access these routes.
Route::middleware('auth')->group(function () {

    // Log out the authenticated administrator.
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // Send authenticated users to the customer management page.
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

    Route::post('/reminders/prepare', [ReminderController::class, 'prepare'])
        ->name('reminders.prepare');
});
