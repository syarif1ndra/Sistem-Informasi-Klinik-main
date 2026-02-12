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
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\Auth\RegisteredUserController as UserRegisteredUserController;
use App\Http\Controllers\User\Auth\AuthenticatedSessionController as UserAuthenticatedSessionController;
use App\Http\Controllers\User\PatientProfileController as UserPatientProfileController;
use App\Http\Controllers\User\ClinicRegistrationController as UserClinicRegistrationController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [PublicController::class, 'index'])->name('public.home');
Route::get('/layanan', [PublicController::class, 'services'])->name('public.services');
Route::get('/obat', [PublicController::class, 'medicines'])->name('public.medicines');
Route::get('/faq', [PublicController::class, 'faqs'])->name('public.faqs');
Route::get('/daftar', [PatientRegistrationController::class, 'create'])->name('public.register');
Route::post('/daftar', [PatientRegistrationController::class, 'store'])->name('public.register.store');

// User Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('user/register', [UserRegisteredUserController::class, 'create'])->name('user.register');
    Route::post('user/register', [UserRegisteredUserController::class, 'store']);
    Route::get('user/login', [UserAuthenticatedSessionController::class, 'create'])->name('user.login');
    Route::post('user/login', [UserAuthenticatedSessionController::class, 'store']);
});

Route::post('user/logout', [UserAuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('user.logout');

// Google Auth Routes
Route::get('auth/google', [App\Http\Controllers\Auth\SocialController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\SocialController::class, 'handleGoogleCallback']);

// Admin Routes (Protected by Breeze)
Route::middleware(['auth', 'verified', 'role.admin'])->prefix('admin')->name('admin.')->group(function () {
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

// User Dashboard
Route::get('/dashboard', [UserDashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'role.user'])
    ->name('dashboard');

// Patient Profile Routes
Route::middleware(['auth', 'verified', 'role.user'])->prefix('user/patient')->name('user.patient.')->group(function () {
    Route::get('/create', [UserPatientProfileController::class, 'create'])->name('create');
    Route::post('/', [UserPatientProfileController::class, 'store'])->name('store');
    Route::get('/edit', [UserPatientProfileController::class, 'edit'])->name('edit');
    Route::put('/', [UserPatientProfileController::class, 'update'])->name('update');
});

// Clinic Registration Routes (Protected by EnsurePatientData)
Route::middleware(['auth', 'verified', 'role.user', 'patient.data'])->prefix('user/registration')->name('user.registration.')->group(function () {
    Route::get('/', [UserClinicRegistrationController::class, 'index'])->name('index');
    Route::get('/create', [UserClinicRegistrationController::class, 'create'])->name('create');
    Route::post('/', [UserClinicRegistrationController::class, 'store'])->name('store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
