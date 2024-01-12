<?php

use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...

]);

Route::middleware(['auth'])->group(function (){
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('all-videos', [VideoController::class, 'index'])->name('videos');
    Route::get('videos/create', [VideoController::class, 'create'])->name('videos.create');
    Route::post('videos/store', [VideoController::class, 'store'])->name('videos.store');
    Route::get('videos/edit/{id}', [VideoController::class, 'edit'])->name('videos.edit');
    Route::put('videos/update/{video}', [VideoController::class, 'update'])->name('videos.update');
    Route::delete('videos/trash/{video}', [VideoController::class, 'destroy'])->name('videos.destroy');
    Route::get('trashed-videos', [VideoController::class, 'trashed'])->name('trashed-videos.index');
    Route::put('restore.video/{video}', [VideoController::class, 'restore'])->name('restore-video');

    Route::get('users', [UsersController::class, 'index'])->name('users.index');
    Route::get('users/profile', [UsersController::class, 'edit'])->name('users.edit-profile');
    Route::put('users/profile/{user}', [UsersController::class, 'update'])->name('users.update-profile');
    Route::get('company-detail', [CompanyController::class, 'index'])->name('company');
    Route::put('company-detail/update/{company}', [CompanyController::class, 'update'])->name('company.update');

    Route::resource('articles', ArticlesController::class);
    Route::resource('services', ServicesController::class);
    Route::resource('faqs', FaqsController::class);

    Route::get('logout', [LoginController::class, 'logout']);


});
