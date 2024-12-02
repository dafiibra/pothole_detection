<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ValidationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ForgetPasswordManager;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\LogActivityController;

Route::middleware(['auth:inspektor,admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::redirect('/', '/login');

//Dashboard
Route::middleware(['check.session'])->group(function () {
    //Log-activity
    Route::post('/log-activity', [LogActivityController::class, 'store'])->name('log.activity');

    //Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/filter', [DashboardController::class, 'filterData'])->name('dashboard.filter');

    //Validation
    Route::get('validation', [ValidationController::class,'fetch_data'])->name('validation.fetch_data');
    Route::patch('validation/{id_deteksi}/approve', [ValidationController::class,'approveResult']);
    Route::patch('validation/{id_deteksi}/reject', [ValidationController::class,'rejectResult']);

    //History
    Route::get('history', [HistoryController::class,'fetch_data'])->name('history.fetch_data');
    Route::post('history/update', [HistoryController::class, 'update'])->name('history.update');

    //Upload
    Route::get('/upload', [UploadController::class, 'index'])->name('upload');
    Route::post('/upload/store', [UploadController::class, 'store'])->name('upload.store');
});

//Login Route
Route::get('/login', [AuthController::class, "Login"])->name("login");
Route::post('/login', [AuthController::class,"LoginPost"])->name("login.post");

//Register Route
Route::get('/register', [AuthController::class, "register"])->name("register");
Route::post('/register', [AuthController::class,"RegisterPost"])->name("register.post");

//Forget Password
Route::get('/forget-password', [ForgetPasswordManager::class, "forgetPassword"])->name("forget.password");
Route::post('/forget-password', [ForgetPasswordManager::class, "forgetPasswordPost"])->name("forget.password.post");
Route::get('/reset-password/{token}', [ForgetPasswordManager::class, "resetPassword"])->name("reset.password");
Route::post('/reset-password', [ForgetPasswordManager::class, "resetPasswordPost"])->name("reset.password.post");

// logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/user', [AdminController::class, 'index'])->name('user-management')->middleware('auth.admin');
Route::get('/approve-user/{id}', [AdminController::class, 'approve'])->name('approve-user')->middleware('auth.admin');
Route::get('/reject-user/{id}', [AdminController::class, 'reject'])->name('reject-user')->middleware('auth.admin');
Route::get('/delete-user/{id}', [AdminController::class, 'delete'])->name('delete-user')->middleware('auth.admin');