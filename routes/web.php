<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AddCertificateController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\VerifyController;
use App\Http\Controllers\PublicVerifyController;
use App\Http\Controllers\PublicStorageController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\NotificationsController;
use Illuminate\Support\Facades\Route;

// Public pages
Route::get('/', [HomeController::class, 'index'])->name('index');


// Public storage fallback for uploaded PDFs and generated QR codes.
// This keeps files visible on Windows/Linux even if `php artisan storage:link` cannot create a symlink.
Route::get('/files/{path}', [PublicStorageController::class, 'show'])
    ->where('path', '.*')
    ->name('public.files.show');

Route::get('/verify', [PublicVerifyController::class, 'index'])->name('public.verify.index');
Route::get('/verify/{identifier}', [PublicVerifyController::class, 'show'])->name('public.verify.show');

// Guest only
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated pages
Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::get('/add-certificate', [AddCertificateController::class, 'index'])->name('add-certificate');

    Route::post('/certificates/store-and-submit', [AddCertificateController::class, 'storeAndSubmit'])
        ->name('certificates.store-and-submit');

    Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
    Route::get('/certificates/{certificate}', [CertificateController::class, 'show'])->name('certificates.show');
    Route::post('/certificates/{certificate}/approve', [CertificateController::class, 'approve'])->name('certificates.approve');

    Route::get('/qr-code', [AddCertificateController::class, 'qrCode'])->name('qr-code');

    Route::get('/verify', [VerifyController::class, 'index'])->name('verify');
    Route::post('/verify', [VerifyController::class, 'check'])->name('verify.check');
    Route::get('/users', [UsersController::class, 'index'])->name('users');
    Route::post('/users', [UsersController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [UsersController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('users.destroy');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Search & Notifications
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/notifications', [NotificationsController::class, 'index'])->name('notifications');
    Route::post('/notifications/read-all', [NotificationsController::class, 'markAllRead'])->name('notifications.read-all');

    // Admin role requests
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/role-requests', [\App\Http\Controllers\AdminRoleRequestController::class, 'pending'])->name('role-requests.pending');
        Route::post('/role-requests/{id}/accept', [\App\Http\Controllers\AdminRoleRequestController::class, 'accept'])->name('role-requests.accept');
        Route::post('/role-requests/{id}/reject', [\App\Http\Controllers\AdminRoleRequestController::class, 'reject'])->name('role-requests.reject');
    });
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
