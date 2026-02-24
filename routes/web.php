<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\PatientRegistrationController;
use App\Http\Controllers\QueueDisplayController;
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
use App\Http\Controllers\User\PatientProfileController as UserPatientProfileController;
use App\Http\Controllers\User\ClinicRegistrationController as UserClinicRegistrationController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [PublicController::class, 'index'])->name('public.home');
Route::get('/antrian-display', [QueueDisplayController::class, 'index'])->name('public.queue_display');
Route::get('/antrian-display/data', [QueueDisplayController::class, 'data'])->name('public.queue_display.data');
Route::get('/layanan', [PublicController::class, 'services'])->name('public.services');
Route::get('/obat', [PublicController::class, 'medicines'])->name('public.medicines');
Route::get('/faq', [PublicController::class, 'faqs'])->name('public.faqs');
Route::get('/daftar', [PatientRegistrationController::class, 'create'])->name('public.register');
Route::post('/daftar', [PatientRegistrationController::class, 'store'])->name('public.register.store');

// User Auth Routes
Route::middleware('guest')->group(function () {
    // User login/register now handled by standard Breeze routes
    Route::get('user/register', [UserRegisteredUserController::class, 'create'])->name('user.register');
    Route::post('user/register', [UserRegisteredUserController::class, 'store']);
});

// Logout is handled by standard auth routes


// Google Auth Routes
Route::get('auth/google', [App\Http\Controllers\Auth\SocialController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\SocialController::class, 'handleGoogleCallback']);

// Bidan Routes (Protected by Breeze)
Route::middleware(['auth', 'verified', 'role.bidan'])->prefix('bidan')->name('bidan.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Bidan\DashboardController::class, 'index'])->name('dashboard');

    // Realtime Queue specific for Bidan Board
    Route::get('/queues/table-data', [\App\Http\Controllers\Bidan\DashboardController::class, 'queueTableData'])->name('queues.tableData');

    // Transactions
    Route::resource('transactions', \App\Http\Controllers\Bidan\TransactionController::class);
    Route::get('/transactions/{transaction}/print-struk', [\App\Http\Controllers\Bidan\TransactionController::class, 'printStruk'])->name('transactions.print_struk');

    // Patient List (filtered by handled_by)
    Route::get('/patients', [\App\Http\Controllers\Bidan\PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/{patient}', [\App\Http\Controllers\Bidan\PatientController::class, 'show'])->name('patients.show');

    // Screenings (Skrining & Diagnosis)
    Route::get('/patients/{patient}/screenings/create', [\App\Http\Controllers\Bidan\ScreeningController::class, 'create'])->name('patients.screenings.create');
    Route::post('/patients/{patient}/screenings', [\App\Http\Controllers\Bidan\ScreeningController::class, 'store'])->name('patients.screenings.store');
    Route::get('/patients/{patient}/screenings/{screening}/edit', [\App\Http\Controllers\Bidan\ScreeningController::class, 'edit'])->name('patients.screenings.edit');
    Route::put('/patients/{patient}/screenings/{screening}', [\App\Http\Controllers\Bidan\ScreeningController::class, 'update'])->name('patients.screenings.update');

    // Financial Report (filtered by handled_by)
    Route::get('/reports', [\App\Http\Controllers\Bidan\ReportController::class, 'index'])->name('reports.index');
});

// Dokter Routes
Route::middleware(['auth', 'verified', 'role.dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Dokter\DashboardController::class, 'index'])->name('dashboard');

    // Realtime Queue specific for Dokter Board
    Route::get('/queues/table-data', [\App\Http\Controllers\Dokter\DashboardController::class, 'queueTableData'])->name('queues.tableData');

    Route::get('/queues', [\App\Http\Controllers\Dokter\QueueController::class, 'index'])->name('queues.index');
    Route::get('/queues/table-data-list', [\App\Http\Controllers\Dokter\QueueController::class, 'tableData'])->name('queues.tableDataList');
    Route::patch('/queues/{queue}/status', [\App\Http\Controllers\Dokter\QueueController::class, 'updateStatus'])->name('queues.updateStatus');

    Route::resource('transactions', \App\Http\Controllers\Dokter\TransactionController::class);
    Route::get('/transactions/{transaction}/print-struk', [\App\Http\Controllers\Dokter\TransactionController::class, 'printStruk'])->name('transactions.print_struk');

    // Patient List (filtered by handled_by)
    Route::get('/patients', [\App\Http\Controllers\Dokter\PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/{patient}', [\App\Http\Controllers\Dokter\PatientController::class, 'show'])->name('patients.show');

    // Screenings (Skrining & Diagnosis)
    Route::get('/patients/{patient}/screenings/create', [\App\Http\Controllers\Dokter\ScreeningController::class, 'create'])->name('patients.screenings.create');
    Route::post('/patients/{patient}/screenings', [\App\Http\Controllers\Dokter\ScreeningController::class, 'store'])->name('patients.screenings.store');
    Route::get('/patients/{patient}/screenings/{screening}/edit', [\App\Http\Controllers\Dokter\ScreeningController::class, 'edit'])->name('patients.screenings.edit');
    Route::put('/patients/{patient}/screenings/{screening}', [\App\Http\Controllers\Dokter\ScreeningController::class, 'update'])->name('patients.screenings.update');

    // Financial Report (filtered by handled_by)
    Route::get('/reports', [\App\Http\Controllers\Dokter\ReportController::class, 'index'])->name('reports.index');
});

// Admin, Bidan, & Dokter Shared Routes
Route::middleware([
    'auth',
    'verified',
    \App\Http\Middleware\EnsureAdminOrBidanRole::class
])->prefix('admin')->name('admin.')->group(function () {
    // Patient Exports
    Route::get('/patients/export/excel', [PatientController::class, 'exportExcel'])->name('patients.exportExcel');
    Route::get('/patients/export/pdf', [PatientController::class, 'exportPdf'])->name('patients.exportPdf');

    // Queue Management
    Route::get('/queues', [QueueController::class, 'index'])->name('queues.index');
    Route::get('/queues/table-data', [QueueController::class, 'tableData'])->name('queues.tableData');
    Route::patch('/queues/{queue}/status', [QueueController::class, 'updateStatus'])->name('queues.updateStatus');
    Route::put('/queues/{queue}', [QueueController::class, 'update'])->name('queues.update');

    // Resource Routes
    Route::resource('patients', PatientController::class);
    Route::get('/patients/{queue}/edit-visit', [PatientController::class, 'editVisit'])->name('patients.editVisit');
    Route::put('/patients/{queue}/update-visit', [PatientController::class, 'updateVisit'])->name('patients.updateVisit');

    // Birth Records
    Route::get('/birth_records/export/excel', [BirthRecordController::class, 'exportExcel'])->name('birth_records.exportExcel');
    Route::get('/birth_records/export/pdf', [BirthRecordController::class, 'exportPdf'])->name('birth_records.exportPdf');
    Route::resource('birth_records', BirthRecordController::class);
    Route::get('/birth_records/{birthRecord}/pdf', [BirthRecordController::class, 'generatePdf'])->name('birth_records.generatePdf');

    // Immunizations
    Route::get('/immunizations/export/excel', [ImmunizationController::class, 'exportExcel'])->name('immunizations.exportExcel');
    Route::get('/immunizations/export/pdf', [ImmunizationController::class, 'exportPdf'])->name('immunizations.exportPdf');
    Route::resource('immunizations', ImmunizationController::class);
});

// Admin Routes (Protected by Breeze)
Route::middleware(['auth', 'verified', 'role.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Services Management
    Route::resource('services', ServiceController::class);
    Route::resource('medicines', MedicineController::class);

    Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.exportExcel');
    Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.exportPdf');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::resource('users', UserController::class);
});

// Admin & Dokter Shared Routes (Additional capabilities for Dokter)
Route::middleware([
    'auth',
    'verified',
    // We can reuse EnsureAdminOrBidanRole here since we just updated it to also allow 'dokter'.
    // A better name would technically be EnsureStaffRole, but to save refactoring time we will just use it.
    \App\Http\Middleware\EnsureAdminOrBidanRole::class
])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('transactions', TransactionController::class);
    Route::get('/transactions/{transaction}/print-struk', [TransactionController::class, 'printStruk'])->name('transactions.print_struk');
    Route::resource('medical-records', MedicalRecordController::class);
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
    Route::patch('/{queue}/cancel', [UserClinicRegistrationController::class, 'cancel'])->name('cancel');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Owner Routes (Protected by Breeze and EnsureOwnerRole)
Route::middleware(['auth', 'verified', 'role.owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Owner\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/export/excel', [\App\Http\Controllers\Owner\DashboardController::class, 'exportExcel'])->name('export.excel');
    Route::get('/export/pdf', [\App\Http\Controllers\Owner\DashboardController::class, 'exportPdf'])->name('export.pdf');

    // New Owner Features
    Route::get('/reports', [\App\Http\Controllers\Owner\ReportController::class, 'index'])->name('reports');
    Route::get('/staff-performance', [\App\Http\Controllers\Owner\StaffPerformanceController::class, 'index'])->name('staff.performance');
    Route::get('/finance', [\App\Http\Controllers\Owner\FinanceController::class, 'index'])->name('finance');
    Route::post('/finance/expense', [\App\Http\Controllers\Owner\FinanceController::class, 'storeExpense'])->name('finance.expense.store');
    Route::delete('/finance/expense/{expense}', [\App\Http\Controllers\Owner\FinanceController::class, 'destroyExpense'])->name('finance.expense.destroy');
});

require __DIR__ . '/auth.php';
