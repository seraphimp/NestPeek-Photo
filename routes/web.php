<?php
// ============================================================
// FILE: routes/web.php
// ============================================================

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CreatorController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;

// Public routes
Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Creators
Route::prefix('creators')->name('creators.')->group(function () {
    Route::get('/', [CreatorController::class, 'index'])->name('index');
    Route::get('/{creatorProfile:slug}', [CreatorController::class, 'show'])->name('show');
});

// Studios
Route::prefix('studios')->name('studios.')->group(function () {
    Route::get('/', [StudioController::class, 'index'])->name('index');
    Route::get('/{studio:slug}', [StudioController::class, 'show'])->name('show');
});

// Auth
require __DIR__ . '/auth.php';

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Onboarding
    Route::get('/onboarding', [OnboardingController::class, 'start'])->name('onboarding.start');
    Route::post('/onboarding/profile', [OnboardingController::class, 'profile'])->name('onboarding.profile');
    Route::get('/onboarding/services', [OnboardingController::class, 'services'])->name('onboarding.services');
    Route::post('/onboarding/complete', [OnboardingController::class, 'complete'])->name('onboarding.complete');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Bookings
    Route::prefix('bookings')->name('bookings.')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->name('index');
        Route::get('/create', [BookingController::class, 'create'])->name('create');
        Route::post('/', [BookingController::class, 'store'])->name('store');
        Route::get('/{booking}', [BookingController::class, 'show'])->name('show');
        Route::post('/{booking}/confirm', [BookingController::class, 'confirm'])->name('confirm');
        Route::post('/{booking}/cancel', [BookingController::class, 'cancel'])->name('cancel');
    });

    // Reviews
    Route::post('/bookings/{booking}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Messages
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::get('/{conversation}', [MessageController::class, 'show'])->name('show');
        Route::post('/{conversation}/send', [MessageController::class, 'send'])->name('send');
    });

    // Favorites
    Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // Creator profile management
    Route::middleware('role:creator,studio_owner')->group(function () {
        Route::get('/my-profile/edit', [CreatorController::class, 'edit'])->name('creators.edit');
        Route::put('/my-profile', [CreatorController::class, 'update'])->name('creators.update');

        // Services
        //Route::resource('services', ServiceController::class)->except(['show']);

        // Portfolio
        Route::post('/portfolios', [PortfolioController::class, 'store'])->name('portfolios.store');
        Route::delete('/portfolios/{portfolio}', [PortfolioController::class, 'destroy'])->name('portfolios.destroy');

        // Availability
        //Route::post('/availability', [AvailabilityController::class, 'update'])->name('availability.update');

        // Studio management
        Route::get('/studios/create', [StudioController::class, 'create'])->name('studios.create');
        Route::post('/studios', [StudioController::class, 'store'])->name('studios.store');
        Route::get('/studios/{studio}/edit', [StudioController::class, 'edit'])->name('studios.edit');
        Route::put('/studios/{studio}', [StudioController::class, 'update'])->name('studios.update');
    });

    // Payments
//    Route::post('/bookings/{booking}/pay', [PaymentController::class, 'processDeposit'])->name('payments.deposit');
  //  Route::post('/bookings/{booking}/pay-full', [PaymentController::class, 'processFull'])->name('payments.full');
    //Route::get('/payments/success', [PaymentController::class, 'success'])->name('payments.success');

    // Profile settings
    //Route::get('/settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //Route::put('/settings/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users/{user}/verify', [AdminController::class, 'verifyCreator'])->name('verify');
    Route::post('/users/{user}/feature', [AdminController::class, 'featureCreator'])->name('feature');
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    Route::get('/studios', [AdminController::class, 'studios'])->name('studios');
});

Route::prefix('bookings')->name('bookings.')->group(function () {
    Route::get('/', [BookingController::class, 'index'])->name('index');
    Route::get('/create', [BookingController::class, 'create'])->name('create');
    Route::post('/', [BookingController::class, 'store'])->name('store');
    Route::get('/{booking}', [BookingController::class, 'show'])->name('show');
    Route::post('/{booking}/confirm', [BookingController::class, 'confirm'])->name('confirm');
    Route::post('/{booking}/cancel', [BookingController::class, 'cancel'])->name('cancel');
    // ADD THESE TWO:
    Route::patch('/{booking}/accept', [BookingController::class, 'accept'])->name('accept');
    Route::patch('/{booking}/decline', [BookingController::class, 'decline'])->name('decline');
});

Route::patch('/{booking}/accept', [BookingController::class, 'accept'])->name('accept');
Route::patch('/{booking}/decline', [BookingController::class, 'decline'])->name('decline');

Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
// Stripe Webhooks
//Route::post('/stripe/webhook', [PaymentController::class, 'webhook'])->name('stripe.webhook');
