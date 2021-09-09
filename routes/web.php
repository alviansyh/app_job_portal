<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobAdsController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ValidationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('clear', [HomeController::class, 'clearCache'])->name('clear_cache');

Route::get('jobseeker-register', [UserController::class, 'registerJobSeeker'])->name('register_job_seeker');
Route::post('jobseeker-register', [UserController::class, 'registerJobSeekerPost']);

Route::get('employer-register', [UserController::class, 'registerEmployer'])->name('register_employer');
Route::post('employer-register', [UserController::class, 'registerEmployerPost']);

Route::post('get-area-options', [LocationController::class, 'getAreaOption'])->name('get_area_option_by_country');

//Single Sigment View
Route::get('jobs/{slug}', [JobAdsController::class, 'find'])->name('view_job_ads');

//User Route
Route::group(['prefix' => 'account'], function () {
    Route::group(['middleware' => 'users'], function () {
        Route::get('dashboard', [AccountController::class, 'dashboard'])->name('user_dashboard');

        Route::get('applied-jobs', [JobApplicationController::class, 'index'])->name('applied_jobs');

        Route::get('reviews', [ReviewController::class, 'index'])->name('reviews');

        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications');

        Route::get('profile-settings', [AccountController::class, 'editProfile'])->name('profile_settings');
        Route::post('profile-settings', [AccountController::class, 'editProfilePost']);
        Route::post('file/upload-image', [FileController::class, 'uploadImage'])->name('upload_image');

        Route::get('change-password', [AccountController::class, 'changePassword'])->name('change_password');
        Route::post('change-password', [AccountController::class, 'changePasswordPost']);
    });

    Route::group(['middleware' => 'only_employer'], function () {
        Route::group(['prefix' => 'job-ads'], function () {
            Route::get('/', [JobAdsController::class, 'index'])->name('job_ads');

            Route::get('new', [JobAdsController::class, 'create'])->name('new_job_ads');
            Route::post('new', [JobAdsController::class, 'store']);

            Route::get('edit/{id}', [JobAdsController::class, 'edit'])->name('edit_job_ads');
            Route::put('edit/{id}', [JobAdsController::class, 'update'])->name('update_job_ads');

            Route::get('delete/{id}', [JobAdsController::class, 'destroy'])->name('delete_job_ads');
        });

        Route::group(['prefix' => 'validations'], function () {
            Route::get('/', [ValidationController::class, 'index'])->name('validation');

            Route::get('new', [ValidationController::class, 'create'])->name('new_validation');
            Route::post('new', [ValidationController::class, 'store']);

            Route::get('edit/{id}', [ValidationController::class, 'edit'])->name('edit_validation');
            Route::put('edit/{id}', [ValidationController::class, 'update'])->name('update_validation');
        });
    });
});

//Admin Route
Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'admin'], function () {
        Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('admin_dashboard');
    });
});
