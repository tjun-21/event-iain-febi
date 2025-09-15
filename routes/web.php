<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MasterData\KategoriController;
use App\Http\Controllers\MasterData\LingkupController;
use App\Http\Controllers\MasterData\JenisRequirementController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\EventRequirementController;
use App\Http\Controllers\ListEventController;
use App\Http\Controllers\ParticipantsController;
use App\Http\Controllers\SubmittingController;
use App\Http\Controllers\ListSubmittingController;
use App\Http\Controllers\UploadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Authentication Routes (untuk guest/belum login)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Placeholder routes (to be implemented later)
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');
});

// Protected Routes (untuk yang sudah login)
Route::middleware(['auth.check'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('kategori')->name('kategori.')->group(function () {
        Route::get('/', [KategoriController::class, 'index'])->name('index');
        Route::get('/create', [KategoriController::class, 'create'])->name('create');
        Route::post('/', [KategoriController::class, 'store'])->name('store');
        Route::get('/{kategori}/edit', [KategoriController::class, 'edit'])->name('edit');
        Route::put('/{kategori}', [KategoriController::class, 'update'])->name('update');
        Route::delete('/{kategori}', [KategoriController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('lingkup')->name('lingkup.')->group(function () {
        Route::get('/', [LingkupController::class, 'index'])->name('index');
        Route::get('/create', [LingkupController::class, 'create'])->name('create');
        Route::post('/', [LingkupController::class, 'store'])->name('store');
        Route::get('/{lingkup}/edit', [LingkupController::class, 'edit'])->name('edit');
        Route::put('/{lingkup}', [LingkupController::class, 'update'])->name('update');
        Route::delete('/{lingkup}', [LingkupController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [EventsController::class, 'index'])->name('index');
        Route::get('/create', [EventsController::class, 'create'])->name('create');
        Route::post('/', [EventsController::class, 'store'])->name('store');
        Route::get('/{event}', [EventsController::class, 'show'])->name('show');
        Route::get('/{event}/edit', [EventsController::class, 'edit'])->name('edit');
        Route::put('/{event}', [EventsController::class, 'update'])->name('update');
        Route::delete('/{event}', [EventsController::class, 'destroy'])->name('destroy');
    });

    // List Events Routes (Card View)
    Route::prefix('list-events')->name('list-events.')->group(function () {
        Route::get('/', [ListEventController::class, 'index'])->name('index');
        Route::get('/{event}', [ListEventController::class, 'show'])->name('show');
        Route::post('/{event}/register', [ListEventController::class, 'register'])->name('register');
    });

    // Event Requirements Routes
    Route::prefix('events/{event}/requirements')->name('event-requirements.')->group(function () {
        Route::get('/', [EventRequirementController::class, 'index'])->name('index');
        Route::get('/create', [EventRequirementController::class, 'create'])->name('create');
        Route::post('/', [EventRequirementController::class, 'store'])->name('store');
        Route::get('/{requirement}', [EventRequirementController::class, 'show'])->name('show');
        Route::get('/{requirement}/edit', [EventRequirementController::class, 'edit'])->name('edit');
        Route::put('/{requirement}', [EventRequirementController::class, 'update'])->name('update');
        Route::delete('/{requirement}', [EventRequirementController::class, 'destroy'])->name('destroy');
    });

    // Participant requirement routes
    Route::prefix('participants/')->name('participants.')->group(function () {
        Route::get('/', [ParticipantsController::class, 'index'])->name('index');
        Route::get('/create', [ParticipantsController::class, 'create'])->name('create');
        Route::post('/', [ParticipantsController::class, 'store'])->name('store');
        Route::get('/{event}', [ParticipantsController::class, 'list'])->name('list');
        Route::get('/{event}/{participant}', [ParticipantsController::class, 'show'])->name('show');
        // Route::get('/{participant}/edit', [ParticipantsController::class, 'edit'])->name('edit');
        Route::put('/{participant}', [ParticipantsController::class, 'update'])->name('update');
        // Route::delete('/{participant}', [ParticipantsController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('submitting')->name('submitting.')->group(function () {
        Route::get('/', [SubmittingController::class, 'index'])->name('index');
        Route::get('/create/{submitting}', [SubmittingController::class, 'create'])->name('create');
        Route::post('/', [SubmittingController::class, 'store'])->name('store');
        Route::get('/{submitting}', [SubmittingController::class, 'show'])->name('show');
        Route::get('/{submitting}/edit', [SubmittingController::class, 'edit'])->name('edit');
        Route::put('/{submitting}', [SubmittingController::class, 'update'])->name('update');
        Route::delete('/{submitting}', [SubmittingController::class, 'destroy'])->name('destroy');

        // Custom route for upload by event slug
        // Route::get('/upload/{event}', [SubmittingController::class, 'upload'])->name('upload');
    });

    // list submitting routes
    Route::prefix('submissions')->name('submissions.')->group(function () {
        Route::get('/', [ListSubmittingController::class, 'index'])->name('index');
        Route::get('/create/{submissions}', [ListSubmittingController::class, 'create'])->name('create');
        Route::post('/', [ListSubmittingController::class, 'store'])->name('store');
        Route::get('/{submissions}', [ListSubmittingController::class, 'list'])->name('list');
        Route::get('/{event}/{participant}', [ParticipantsController::class, 'show'])->name('show');
        Route::get('/{submissions}/edit', [ListSubmittingController::class, 'edit'])->name('edit');
        Route::put('/{submissions}', [ListSubmittingController::class, 'update'])->name('update');
        Route::delete('/{submissions}', [ListSubmittingController::class, 'destroy'])->name('destroy');
    });


    // Upload Routes
    Route::post('/upload/image', [UploadController::class, 'uploadImage'])->name('upload.image');
    Route::delete('/upload/image', [UploadController::class, 'deleteImage'])->name('upload.delete');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
