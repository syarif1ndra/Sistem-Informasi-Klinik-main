<?php

use Illuminate\Support\Facades\Route;

// ─── CONTROLLERS ──────────────────────────────────────────────────────────────
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PublicController;

use App\Http\Controllers\Api\User\ProfileController       as UserProfileController;
use App\Http\Controllers\Api\User\PatientController       as UserPatientController;
use App\Http\Controllers\Api\User\QueueController         as UserQueueController;

use App\Http\Controllers\Api\Admin\DashboardController    as AdminDashboardController;
use App\Http\Controllers\Api\Admin\UserController         as AdminUserController;
use App\Http\Controllers\Api\Admin\PatientController      as AdminPatientController;
use App\Http\Controllers\Api\Admin\ServiceController      as AdminServiceController;
use App\Http\Controllers\Api\Admin\MedicineController     as AdminMedicineController;
use App\Http\Controllers\Api\Admin\QueueController        as AdminQueueController;
use App\Http\Controllers\Api\Admin\BirthRecordController  as AdminBirthRecordController;
use App\Http\Controllers\Api\Admin\ImmunizationController as AdminImmunizationController;
use App\Http\Controllers\Api\Admin\TransactionController  as AdminTransactionController;
use App\Http\Controllers\Api\Admin\ReportController       as AdminReportController;

use App\Http\Controllers\Api\Bidan\DashboardController    as BidanDashboardController;
use App\Http\Controllers\Api\Bidan\QueueController        as BidanQueueController;
use App\Http\Controllers\Api\Bidan\PatientController      as BidanPatientController;
use App\Http\Controllers\Api\Bidan\ScreeningController    as BidanScreeningController;
use App\Http\Controllers\Api\Bidan\TransactionController  as BidanTransactionController;
use App\Http\Controllers\Api\Bidan\ReportController       as BidanReportController;

use App\Http\Controllers\Api\Dokter\DashboardController   as DokterDashboardController;
use App\Http\Controllers\Api\Dokter\QueueController       as DokterQueueController;
use App\Http\Controllers\Api\Dokter\PatientController     as DokterPatientController;
use App\Http\Controllers\Api\Dokter\ScreeningController   as DokterScreeningController;
use App\Http\Controllers\Api\Dokter\TransactionController as DokterTransactionController;
use App\Http\Controllers\Api\Dokter\ReportController      as DokterReportController;

use App\Http\Controllers\Api\Owner\DashboardController       as OwnerDashboardController;
use App\Http\Controllers\Api\Owner\ReportController          as OwnerReportController;
use App\Http\Controllers\Api\Owner\StaffPerformanceController as OwnerStaffController;
use App\Http\Controllers\Api\Owner\FinanceController          as OwnerFinanceController;

// ══════════════════════════════════════════════════════════════════════════════
// PUBLIC — No authentication required
// ══════════════════════════════════════════════════════════════════════════════
Route::prefix('public')->group(function () {
    Route::get('/services',       [PublicController::class, 'services']);
    Route::get('/medicines',      [PublicController::class, 'medicines']);
    Route::get('/faqs',           [PublicController::class, 'faqs']);
    Route::get('/queues/display', [PublicController::class, 'queueDisplay']);
});

// ══════════════════════════════════════════════════════════════════════════════
// AUTH
// ══════════════════════════════════════════════════════════════════════════════
Route::post('/login',    [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',      [AuthController::class, 'me']);

    // ══════════════════════════════════════════════════════════════════════════
    // USER (role: user)
    // ══════════════════════════════════════════════════════════════════════════
    Route::middleware('api.role:user')->prefix('user')->group(function () {
        // Profile
        Route::get('/profile',  [UserProfileController::class, 'show']);
        Route::put('/profile',  [UserProfileController::class, 'update']);
        // Patient data
        Route::get('/patient',  [UserPatientController::class, 'show']);
        Route::post('/patient', [UserPatientController::class, 'store']);
        Route::put('/patient',  [UserPatientController::class, 'update']);
        // Queue (clinic registration)
        Route::get('/queues',               [UserQueueController::class, 'index']);
        Route::post('/queues',              [UserQueueController::class, 'store']);
        Route::patch('/queues/{id}/cancel', [UserQueueController::class, 'cancel']);
    });

    // ══════════════════════════════════════════════════════════════════════════
    // ADMIN (role: admin)
    // ══════════════════════════════════════════════════════════════════════════
    Route::middleware('api.role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index']);

        // Users
        Route::get('/users',         [AdminUserController::class, 'index']);
        Route::post('/users',        [AdminUserController::class, 'store']);
        Route::get('/users/{id}',    [AdminUserController::class, 'show']);
        Route::put('/users/{id}',    [AdminUserController::class, 'update']);
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy']);

        // Patients
        Route::get('/patients',         [AdminPatientController::class, 'index']);
        Route::post('/patients',        [AdminPatientController::class, 'store']);
        Route::get('/patients/{id}',    [AdminPatientController::class, 'show']);
        Route::put('/patients/{id}',    [AdminPatientController::class, 'update']);
        Route::delete('/patients/{id}', [AdminPatientController::class, 'destroy']);

        // Services
        Route::get('/services',         [AdminServiceController::class, 'index']);
        Route::post('/services',        [AdminServiceController::class, 'store']);
        Route::get('/services/{id}',    [AdminServiceController::class, 'show']);
        Route::put('/services/{id}',    [AdminServiceController::class, 'update']);
        Route::delete('/services/{id}', [AdminServiceController::class, 'destroy']);

        // Medicines
        Route::get('/medicines',         [AdminMedicineController::class, 'index']);
        Route::post('/medicines',        [AdminMedicineController::class, 'store']);
        Route::get('/medicines/{id}',    [AdminMedicineController::class, 'show']);
        Route::put('/medicines/{id}',    [AdminMedicineController::class, 'update']);
        Route::delete('/medicines/{id}', [AdminMedicineController::class, 'destroy']);

        // Queues
        Route::get('/queues',                    [AdminQueueController::class, 'index']);
        Route::post('/queues',                   [AdminQueueController::class, 'store']);
        Route::get('/queues/{id}',               [AdminQueueController::class, 'show']);
        Route::put('/queues/{id}',               [AdminQueueController::class, 'update']);
        Route::patch('/queues/{id}/status',      [AdminQueueController::class, 'updateStatus']);

        // Birth Records
        Route::get('/birth-records',         [AdminBirthRecordController::class, 'index']);
        Route::post('/birth-records',        [AdminBirthRecordController::class, 'store']);
        Route::get('/birth-records/{id}',    [AdminBirthRecordController::class, 'show']);
        Route::put('/birth-records/{id}',    [AdminBirthRecordController::class, 'update']);
        Route::delete('/birth-records/{id}', [AdminBirthRecordController::class, 'destroy']);

        // Immunizations
        Route::get('/immunizations',         [AdminImmunizationController::class, 'index']);
        Route::post('/immunizations',        [AdminImmunizationController::class, 'store']);
        Route::get('/immunizations/{id}',    [AdminImmunizationController::class, 'show']);
        Route::put('/immunizations/{id}',    [AdminImmunizationController::class, 'update']);
        Route::delete('/immunizations/{id}', [AdminImmunizationController::class, 'destroy']);

        // Transactions
        Route::get('/transactions',         [AdminTransactionController::class, 'index']);
        Route::post('/transactions',        [AdminTransactionController::class, 'store']);
        Route::get('/transactions/{id}',    [AdminTransactionController::class, 'show']);
        Route::put('/transactions/{id}',    [AdminTransactionController::class, 'update']);
        Route::delete('/transactions/{id}', [AdminTransactionController::class, 'destroy']);

        // Reports
        Route::get('/reports', [AdminReportController::class, 'index']);
    });

    // ══════════════════════════════════════════════════════════════════════════
    // BIDAN (role: bidan)
    // ══════════════════════════════════════════════════════════════════════════
    Route::middleware('api.role:bidan')->prefix('bidan')->group(function () {
        Route::get('/dashboard', [BidanDashboardController::class, 'index']);

        // Queues
        Route::get('/queues',      [BidanQueueController::class, 'index']);
        Route::get('/queues/{id}', [BidanQueueController::class, 'show']);

        // Patients
        Route::get('/patients',      [BidanPatientController::class, 'index']);
        Route::get('/patients/{id}', [BidanPatientController::class, 'show']);

        // Screenings (nested under patient)
        Route::get('/patients/{patientId}/screenings',           [BidanScreeningController::class, 'index']);
        Route::post('/patients/{patientId}/screenings',          [BidanScreeningController::class, 'store']);
        Route::get('/patients/{patientId}/screenings/{id}',      [BidanScreeningController::class, 'show']);
        Route::put('/patients/{patientId}/screenings/{id}',      [BidanScreeningController::class, 'update']);

        // Transactions
        Route::get('/transactions',      [BidanTransactionController::class, 'index']);
        Route::post('/transactions',     [BidanTransactionController::class, 'store']);
        Route::get('/transactions/{id}', [BidanTransactionController::class, 'show']);

        // Reports
        Route::get('/reports', [BidanReportController::class, 'index']);
    });

    // ══════════════════════════════════════════════════════════════════════════
    // DOKTER (role: dokter)
    // ══════════════════════════════════════════════════════════════════════════
    Route::middleware('api.role:dokter')->prefix('dokter')->group(function () {
        Route::get('/dashboard', [DokterDashboardController::class, 'index']);

        // Queues
        Route::get('/queues',               [DokterQueueController::class, 'index']);
        Route::get('/queues/{id}',          [DokterQueueController::class, 'show']);
        Route::patch('/queues/{id}/status', [DokterQueueController::class, 'updateStatus']);

        // Patients
        Route::get('/patients',      [DokterPatientController::class, 'index']);
        Route::get('/patients/{id}', [DokterPatientController::class, 'show']);

        // Screenings
        Route::get('/patients/{patientId}/screenings',      [DokterScreeningController::class, 'index']);
        Route::post('/patients/{patientId}/screenings',     [DokterScreeningController::class, 'store']);
        Route::get('/patients/{patientId}/screenings/{id}', [DokterScreeningController::class, 'show']);
        Route::put('/patients/{patientId}/screenings/{id}', [DokterScreeningController::class, 'update']);

        // Transactions
        Route::get('/transactions',      [DokterTransactionController::class, 'index']);
        Route::post('/transactions',     [DokterTransactionController::class, 'store']);
        Route::get('/transactions/{id}', [DokterTransactionController::class, 'show']);

        // Reports
        Route::get('/reports', [DokterReportController::class, 'index']);
    });

    // ══════════════════════════════════════════════════════════════════════════
    // OWNER (role: owner)
    // ══════════════════════════════════════════════════════════════════════════
    Route::middleware('api.role:owner')->prefix('owner')->group(function () {
        Route::get('/dashboard', [OwnerDashboardController::class, 'index']);

        // Reports & payment toggle
        Route::get('/reports',                              [OwnerReportController::class, 'index']);
        Route::patch('/reports/toggle-payment/{id}',       [OwnerReportController::class, 'togglePayment']);

        // Staff performance
        Route::get('/staff-performance',                    [OwnerStaffController::class, 'index']);
        Route::put('/staff/{userId}/fee',                   [OwnerStaffController::class, 'updateFee']);
        Route::post('/staff/{userId}/salary-payment',       [OwnerStaffController::class, 'toggleSalaryPayment']);

        // Finance / Expenses
        Route::get('/finance',                              [OwnerFinanceController::class, 'index']);
        Route::post('/finance/expenses',                    [OwnerFinanceController::class, 'storeExpense']);
        Route::delete('/finance/expenses/{id}',             [OwnerFinanceController::class, 'destroyExpense']);
    });
});
