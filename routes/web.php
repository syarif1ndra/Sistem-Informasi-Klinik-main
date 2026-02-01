<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\PatientRegistrationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\QueueController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\MedicineController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\MedicalRecordController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BirthRecordController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ImmunizationController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [PublicController::class, 'index'])->name('public.home');
Route::get('/layanan', [PublicController::class, 'services'])->name('public.services');
Route::get('/obat', [PublicController::class, 'medicines'])->name('public.medicines');
Route::get('/faq', [PublicController::class, 'faqs'])->name('public.faqs');
Route::get('/daftar', [PatientRegistrationController::class, 'create'])->name('public.register');
Route::post('/daftar', [PatientRegistrationController::class, 'store'])->name('public.register.store');

// Admin Routes (Protected by Breeze)
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Queue Management
    Route::get('/queues', [QueueController::class, 'index'])->name('queues.index');
    Route::patch('/queues/{queue}/status', [QueueController::class, 'updateStatus'])->name('queues.updateStatus');

    // Services Management
    Route::resource('services', ServiceController::class);

    // Resource Routes
    Route::resource('patients', PatientController::class);
    Route::resource('medicines', MedicineController::class);
    Route::resource('transactions', TransactionController::class);
    Route::get('/transactions/{transaction}/print-struk', [TransactionController::class, 'printStruk'])->name('transactions.print_struk');
    Route::resource('medical-records', MedicalRecordController::class);
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::resource('users', UserController::class);
    Route::resource('birth_records', BirthRecordController::class);
    Route::get('/birth_records/{birthRecord}/pdf', [BirthRecordController::class, 'generatePdf'])->name('birth_records.generatePdf');
    Route::resource('immunizations', ImmunizationController::class);
});

// Redirect default dashboard to admin dashboard
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
