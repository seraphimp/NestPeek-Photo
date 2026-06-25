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
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\AdminController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search');

/*
|--------------------------------------------------------------------------
| Creator Routes (Public Browsing)
|--------------------------------------------------------------------------
*/
Route::prefix('creators')->name('creators.')->group(function () {
    Route::get('/', [CreatorController::class, 'index'])->name('index');
    Route::get('/{creatorProfile:slug}', [CreatorController::class, 'show'])->name('show');
});

/*
|--------------------------------------------------------------------------
| Studio Routes (Public Browsing)
|--------------------------------------------------------------------------
*/
Route::prefix('studios')->name('studios.')->group(function () {
    Route::get('/', [StudioController::class, 'index'])->name('index');
});

// Public studio detail page - Must come AFTER static routes
Route::get('/studios/{studio:slug}', [StudioController::class, 'showPublic'])->name('studios.public');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
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
        Route::patch('/{booking}/accept', [BookingController::class, 'accept'])->name('accept');
        Route::patch('/{booking}/decline', [BookingController::class, 'decline'])->name('decline');
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

    // Portfolio (Read-only for all authenticated users)
    Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');

    // Creator & Studio Owner Routes
    Route::middleware('role:creator,studio_owner')->group(function () {

        // Creator Profile Management
        Route::get('/my-profile/edit', [CreatorController::class, 'edit'])->name('creators.edit');
        Route::put('/my-profile', [CreatorController::class, 'update'])->name('creators.update');

        // Portfolio Management
        Route::post('/portfolios', [PortfolioController::class, 'store'])->name('portfolios.store');
        Route::delete('/portfolios/{portfolio}', [PortfolioController::class, 'destroy'])->name('portfolios.destroy');

        // Service Management
        Route::prefix('studios/{studio}')->group(function () {
            Route::get('/services', [ServiceController::class, 'index'])->name('studios.services.index');
            Route::get('/services/create', [ServiceController::class, 'create'])->name('studios.services.create');
            Route::post('/services', [ServiceController::class, 'store'])->name('studios.services.store');
            Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('studios.services.edit');
            Route::put('/services/{service}', [ServiceController::class, 'update'])->name('studios.services.update');
            Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('studios.services.destroy');
        });

        // Studio Management
        Route::get('/studios/create', [StudioController::class, 'create'])->name('studios.create');
        Route::post('/studios', [StudioController::class, 'store'])->name('studios.store');
        Route::get('/studios/{studio}/edit', [StudioController::class, 'edit'])->name('studios.edit');
        Route::put('/studios/{studio}', [StudioController::class, 'update'])->name('studios.update');

        // Studio Members Management
        Route::prefix('studios/{studio}')->group(function () {
            Route::get('/members', [StudioController::class, 'members'])->name('studios.members.index');
            Route::get('/members/create', [StudioController::class, 'createMember'])->name('studios.members.create');
            Route::post('/members', [StudioController::class, 'addMember'])->name('studios.members.store');
            Route::delete('/members/{creator}', [StudioController::class, 'removeMember'])->name('studios.members.destroy');
            Route::patch('/members/{creator}/role', [StudioController::class, 'updateMemberRole'])->name('studios.members.update-role');
        });

        // Studio Availability
        Route::prefix('studios/{studio}')->group(function () {
            Route::get('/availability', [AvailabilityController::class, 'index'])->name('studios.availability.index');
            Route::post('/availability', [AvailabilityController::class, 'update'])->name('studios.availability.update');
        });

        // Studio Gallery/Photos
        Route::prefix('studios/{studio}')->group(function () {
            Route::post('/photos', [StudioController::class, 'uploadPhoto'])->name('studios.photos.store');
            Route::delete('/photos/{photo}', [StudioController::class, 'deletePhoto'])->name('studios.photos.destroy');
        });

        // Studio Dashboard
        Route::get('/studios/{studio:slug}/dashboard', [StudioController::class, 'show'])->name('studios.show');
    });

    // Payment Routes - Commented out until Stripe is configured
    // Route::post('/bookings/{booking}/pay', [PaymentController::class, 'processDeposit'])->name('payments.deposit');
    // Route::post('/bookings/{booking}/pay-full', [PaymentController::class, 'processFull'])->name('payments.full');
    // Route::get('/payments/success', [PaymentController::class, 'success'])->name('payments.success');

    // Profile Settings - Commented out until ProfileController is ready
    // Route::get('/settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::put('/settings/profile', [ProfileController::class, 'update'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users/{user}/verify', [AdminController::class, 'verifyCreator'])->name('verify');
    Route::post('/users/{user}/feature', [AdminController::class, 'featureCreator'])->name('feature');
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    Route::get('/studios', [AdminController::class, 'studios'])->name('studios');
});

// Stripe Webhooks - Commented out until Stripe is configured
// Route::post('/stripe/webhook', [PaymentController::class, 'webhook'])->name('stripe.webhook');